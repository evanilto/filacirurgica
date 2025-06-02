import pandas as pd
import psycopg2
from datetime import datetime

# === CONFIGURAÇÕES DO BANCO ===
DB_CONFIG = {
    'host': '10.88.1.79',       # ou IP do seu servidor
    'dbname': 'dbfilacirurgica_dev',
    'user': 'postgres',
    'password': 'postgres',  # altere se necessário
    'port': 5432               # altere se necessário
}

# === LEITURA E LIMPEZA DO CSV ===
df = pd.read_csv('ANGIOPLASTIA_CORONARIANA_.CSV', sep=';', encoding='latin1')

# Renomear as colunas para corresponder ao banco
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

# Remover espaços e tabs
df = df.applymap(lambda x: x.strip() if isinstance(x, str) else x)

# Corrigir datas (pode ajustar formato conforme necessário)
def parse_date(d):
    try:
        return pd.to_datetime(d, dayfirst=True).date()
    except:
        return None

df['data_inscricao'] = df['data_inscricao'].apply(parse_date)

# === INSERÇÃO NO BANCO ===
conn = psycopg2.connect(**DB_CONFIG)
cur = conn.cursor()

insert_sql = """
    INSERT INTO lista_espera (
        created_at,
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
        txtinfoadicionais
    ) VALUES (
        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
        %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,
        %s, %s, %s, %s
    );
"""

for _, row in df.iterrows():
    values = tuple(row)
    cur.execute(insert_sql, values)

conn.commit()
cur.close()
conn.close()

print("Importação concluída com sucesso!")
