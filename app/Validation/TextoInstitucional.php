<?php

namespace App\Validation;

class TextoInstitucional
{
    /**
     * Valida se o texto possui ao menos X caracteres não brancos
     */
    public function minimoCaracteresNaoBrancos(string $str, string $min): bool
    {
        // Remove TODOS os espaços, tabs e quebras de linha
        $conteudo = preg_replace('/\s+/u', '', $str);

        return mb_strlen($conteudo) >= (int) $min;
    }
}
