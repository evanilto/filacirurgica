import pandas as pd
import psycopg2
from datetime import datetime

# === CONFIGURAÇÕES DO BANCO ===
DB_CONFIG = {
    'host': '10.88.1.79',
    'dbname': 'dbfilacirurgica_dev',
    'user': 'postgres',
    'password': 'postgres',
    'port': 5432
}

# === LEITURA DO CSV ===
df = pd.read_csv('ANGIOPLASTIA_CORONARIANA_.CSV', sep=';', encoding='latin1')

# Renomear colunas conforme necessário (14 colunas no CSV + created_at no banco)
df.columns = [
    'data_inscricao',
    'prontuario',
    'especialidade',
    'fila',
    'codigo_procedimento',
    'cid',
    'origem',
    'risco',
    'data_risco',
    'complexidade',
    'lateralidade',
    'congelacao',
    'opme',
    'informacoes_adicionais'
]

# === LIMPEZA ===
df = df.apply(lambda col: col.map(lambda x: x.strip() if isinstance(x, str) else x))

# Corrigir datas
def parse_date(d):
    try:
        return pd.to_datetime(d, dayfirst=True).date()
    except:
        return None

df['data_inscricao'] = df['data_inscricao'].apply(parse_date)
# Converte datas ausentes (NaT ou NaN) para None
df['data_risco'] = df['data_risco'].apply(lambda x: x if pd.notnull(x) else None)

# Adiciona a data de criação
df['created_at'] = datetime.now().replace(microsecond=0)
df['updated_at'] = datetime.now().replace(microsecond=0)

# Reordena as colunas para bater com a ordem do insert
df = df[[
    'created_at',
    'updated_at',
    'prontuario',
    'especialidade',
    'fila',
    'codigo_procedimento',
    'cid',
    'origem',
    'risco',
    'data_risco',
    'complexidade',
    'lateralidade',
    'congelacao',
    'opme',
    'informacoes_adicionais'
]]

# === INSERÇÃO NO BANCO ===
conn = psycopg2.connect(**DB_CONFIG)
cur = conn.cursor()

insert_sql = """
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
        indsituacao
    ) VALUES (
        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
        %s, %s, %s, %s, 'A'
    );
"""

# Corrigir datas vazias para None (NULL no PostgreSQL)
for col in ['data_risco', 'informacoes_adicionais']:
    df[col] = df[col].apply(lambda x: x if pd.notnull(x) else None)

# Converte DataFrame em lista de tuplas
records = [tuple(row) for row in df.itertuples(index=False, name=None)]

# Inserção em lote
cur.executemany(insert_sql, records)

conn.commit()
cur.close()
conn.close()

print("Importação concluída com sucesso!")
