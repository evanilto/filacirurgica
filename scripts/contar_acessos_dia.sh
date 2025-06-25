#!/bin/bash

# Caminho fixo do arquivo de log
LOG_FILE="/var/www/html/filacirurgica/writable/logs/acessos-$(date +%Y-%m-%d).log"

if [ ! -f "$LOG_FILE" ]; then
    echo "Arquivo de log não encontrado: $LOG_FILE"
    exit 1
fi

echo "Usuário - Rota - Quantidade de Acessos"
echo "--------------------------------------"

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
    acessos[usuario " - " rota]++
}
END {
    for (chave in acessos) {
        print chave " - " acessos[chave]
    }
}
' "$LOG_FILE" | sort
