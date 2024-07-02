<?php
// Verifica se o driver OCI8 está ativado no PHP
if (extension_loaded('oci8')) {
    echo 'OCI8 está ativado no PHP.<br>';

    // Verifica se a extensão OCI8 está habilitada no servidor web
    if (function_exists('oci_connect')) {
        echo 'Extensão OCI8 está habilitada no servidor web.';
    } else {
        echo 'Extensão OCI8 não está habilitada no servidor web.';
    }
} else {
    echo 'OCI8 não está ativado no PHP. Verifique a configuração do PHP.';
}