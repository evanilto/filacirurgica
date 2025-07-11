#!/bin/bash

# Verifica se uma data foi passada como argumento (formato: YYYY-MM-DD)
if [ -n "$1" ]; then
    DATA="$1"
else
    DATA=$(date +%Y-%m-%d)
fi

# Caminho do arquivo de log baseado na data fornecida ou atual
LOG_FILE="/var/www/html/filacirurgica/writable/logs/acessos-${DATA}.log"

# Verifica se o arquivo existe
if [ ! -f "$LOG_FILE" ]; then
    echo "Arquivo de log não encontrado: $LOG_FILE"
    exit 1
fi

echo "Rota - Usuário - Quantidade de Acessos"
echo "--------------------------------------"

# Processa e agrupa os dados
awk -F' - ' '
{
    for (i=1; i<=NF; i++) {
        if ($i ~ /Usuário:/) {
            split($i, u, ": "); usuario = u[2]
        }
        if ($i ~ /^\//) {
            rota = $i
        }
    }
    acessos[rota " - " usuario]++
}
END {
    for (chave in acessos) {
        print chave " - " acessos[chave]
    }
}
' "$LOG_FILE" | sort
