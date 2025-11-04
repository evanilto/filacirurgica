<?php

if (!function_exists('nomeCentroCirurgico')) {
    function nomeCentroCirurgico($nome_ext)
    {
        $centros = [
            'HOSPITAL DIA  AMBULATORIAL'=> 'CCAMB',
            'HOSPITAL DIA 3º ANDAR' => 'CC3',
            'HOSPITAL DIA 5º ANDAR' => 'CC5',
            'HEMODINÂMICA' => 'HEMO',
            'UNIDADE CORONARIANA' => 'UCOR',
            'UNIDADE DE TERAPIA INTENSIVA I' => 'UTI I'        ];

        return $centros[$nome_ext] ?? $nome_ext;
    }
}
