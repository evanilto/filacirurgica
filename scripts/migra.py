import sys
import pandas as pd
import psycopg2
from datetime import datetime

# === CONFIGURAÇÕES DO BANCO ===
DB_CONFIG = {
    'host': '10.88.1.79',
    'dbname': 'dbfilacirurgica_dev',
    #'dbname': 'dbfilacirurgica',
    'user': 'postgres',
    'password': '@ebser_passwd#$',
    'port': 5432
}

# Verifica se o argumento do nome do arquivo foi passado
if len(sys.argv) < 2:
    print("Uso: python seu_script.py nome_do_arquivo.csv")
    sys.exit(1)

arquivo_csv = sys.argv[1]

# Lê o arquivo CSV fornecido como argumento
df = pd.read_csv(arquivo_csv, sep=';', encoding='utf-8')

# === LEITURA DO CSV ===
#df = pd.read_csv('ANGIOPLASTIA_CORONARIANA_TESTE.CSV', sep=';', encoding='latin1')
#df = pd.read_csv('RADIOLOGIA_INTERVENCIONISTA.CSV', sep=';', encoding='utf-8')

# Renomear colunas conforme necessário
colunas_esperadas = [
    'data_inscricao',
    'prontuario',
    'especialidade',
    'fila',
    'codigo_procedimento',
    'cid',
    'origem',
    'risco',
    'data risco',
    'complexidade',
    'lateralidade',
    'congelacao',
    'opme',
    'informações adicionais'
]

# Renomear apenas as colunas esperadas
df.columns = colunas_esperadas + [f'ignorar_{i}' for i in range(len(df.columns) - len(colunas_esperadas))]

# Descartar colunas extras
df = df[colunas_esperadas]

# === LIMPEZA ===
df = df.apply(lambda col: col.map(lambda x: x.strip() if isinstance(x, str) else x))

# Remover pontos e hífens de codigo_procedimento
#df['codigo_procedimento'] = df['codigo_procedimento'].astype(str).str.replace(r'[.\-]', '', regex=True)
df['codigo_procedimento'] = (
    df['codigo_procedimento']
    .astype(str)
    .str.replace(r'[.\-\s]', '', regex=True)  # Remove ponto, traço e espaço
    .str.lstrip('0')                          # Remove zeros à esquerda
)

# Corrigir datas
def parse_date(d):
    try:
        return pd.to_datetime(d, dayfirst=True).date()
    except:
        return None

df['data_inscricao'] = df['data_inscricao'].apply(parse_date)
df['data risco'] = df['data risco'].apply(lambda x: x if pd.notnull(x) else None)
df['opme'] = df['opme'].apply(lambda x: x if pd.notnull(x) else None)

def ajustar_data_risco(row):
    #if str(row['risco']).strip().upper() == 'LIBERADO':
        #return None
    try:
        return pd.to_datetime(row['data_risco'], dayfirst=True).date()
    except:
        return None

df['data_risco'] = df.apply(ajustar_data_risco, axis=1)


# Mapear complexidade para o código correspondente
def map_complexidade(valor):
    if valor == 'BAIXA COMPLEXIDADE':
        return 'B'
    elif valor == 'MÉDIA COMPLEXIDADE':
        return 'M'
    elif valor == 'ALTA COMPLEXIDADE':
        return 'A'
    else:
        return None  # Grava NULL

# Normalizar valores da coluna 'congelacao'
def map_congelacao(valor):
    if isinstance(valor, str):
        valor = valor.strip().upper()
        if valor == 'SIM':
            return 'S'
        elif valor == 'NÃO':
            return 'N'
    return None  # para valores vazios ou inválidos

df['congelacao'] = df['congelacao'].apply(map_congelacao)

print(df['prontuario'])

# === INSERÇÃO NO BANCO ===
conn = psycopg2.connect(**DB_CONFIG)
cur = conn.cursor()

# SQL para inserir na lista_espera
insert_sql_lista = """
    INSERT INTO lista_espera (
        created_at,
        updated_at,
        numprontuario,
        idespecialidade,
        idtipoprocedimento,
        idprocedimento,
        numcid,
        idorigempaciente,
        idriscocirurgico,
        dtriscocirurgico,
        idcomplexidade,
        idlateralidade,
        indcongelacao,
        indopme,
        txtinfoadicionais,
        indsituacao,
        idunidadeorigem
    ) VALUES (
        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
        %s, %s, %s, %s, %s, 'A', %s
    ) RETURNING id;
"""

# SQL para inserir no histórico
insert_sql_historico = """
    INSERT INTO historico (
        dthrevento,
        idlistaespera,
        idevento,
        idlogin
    ) VALUES (
        %s, %s, %s, %s
    );
"""

# SQL para buscar id's
select_lateralidade_sql = "SELECT id FROM public.lateralidades WHERE descricao = %s;"
select_especialidade_sql = "SELECT seq FROM public.local_agh_especialidades WHERE nome_especialidade = %s;"
select_fila_sql = "SELECT id FROM public.tipos_procedimentos WHERE nmtipoprocedimento = %s;"
select_origem_sql = "SELECT id FROM public.origem_paciente WHERE nmorigem ILIKE %s;"
select_cid_sql = """SELECT seq FROM public.local_agh_cids WHERE REPLACE(REPLACE(codigo, '.', ''), '-', '') = %s;"""
select_risco_sql = "SELECT id FROM public.risco_cirurgico WHERE nmrisco = %s;"
select_lateralidade_sql = "SELECT id FROM public.lateralidades WHERE descricao = %s;"
select_unidade_sql = "SELECT seq FROM public.local_agh_instituicoes_hospitalares WHERE nome ILIKE %s;"

# Itera sobre o DataFrame
for _, row in df.iterrows():
    created_at = datetime.now().replace(microsecond=0)
    updated_at = created_at

    # Buscar id's
    lateralidade_desc = row['lateralidade']
    id_lateralidade = 5  # valor padrão quando vazio

    if isinstance(lateralidade_desc, str) and lateralidade_desc.strip():
        cur.execute(select_lateralidade_sql, (lateralidade_desc.strip(),))
        result = cur.fetchone()
        if result:
            id_lateralidade = result[0]

    especialidade_desc = row['especialidade']
    id_especialidade = None
    if especialidade_desc:
        cur.execute(select_especialidade_sql, (especialidade_desc,))
        result = cur.fetchone()
        if result:
            id_especialidade = result[0]

    fila_desc = row['fila']
    id_fila = None
    if fila_desc:
        cur.execute(select_fila_sql, (fila_desc,))
        result = cur.fetchone()
        if result:
            id_fila = result[0]

    origem_desc = row['origem']
    id_origem = None
    if pd.notnull(origem_desc):
        cur.execute(select_origem_sql, (origem_desc[:4] + '%',))
        result = cur.fetchone()
        if result:
            id_origem = result[0]

    cid_desc = row['cid']
    cid_limpo = cid_desc.replace('.', '').replace('-', '') if pd.notnull(cid_desc) else None
    id_cid = None
    if cid_limpo:
        cur.execute(select_cid_sql, (cid_limpo,))
        result = cur.fetchone()
        if result:
            id_cid = result[0]


    risco_desc = row['risco']
    id_risco = None
    if risco_desc:
        cur.execute(select_risco_sql, (risco_desc,))
        result = cur.fetchone()
        if result:
            id_risco = result[0]

    unidade_desc = row['informações adicionais']
    id_unidade = None
    if pd.notnull(unidade_desc):
        cur.execute(select_unidade_sql, (unidade_desc[:22] + '%',))
        result = cur.fetchone()
        if result:
            id_unidade = result[0]

    # Mapear complexidade para o código (B/M/A)
    cod_complexidade = map_complexidade(row['complexidade'])

    values_lista = (
        created_at,
        updated_at,
        row['prontuario'],
        id_especialidade,
        id_fila,
        row['codigo_procedimento'],
        id_cid,
        id_origem,
        id_risco,
        row['data_risco'],
        cod_complexidade,
        id_lateralidade,
        row['congelacao'],
        row['opme'],
        row['informações adicionais'] if pd.notnull(row['informações adicionais']) else None,
        id_unidade
    )

    # Inserir na lista_espera e capturar id
    cur.execute(insert_sql_lista, values_lista)
    id_lista = cur.fetchone()[0]

    # Inserir no histórico
    cur.execute(insert_sql_historico, (created_at, id_lista, 5, 'infohu'))

# Commit e fechar conexão
conn.commit()
cur.close()
conn.close()

print("Importação e histórico concluídos com sucesso!")
