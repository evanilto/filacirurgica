<?php

namespace App\Controllers;

class Testecli extends \CodeIgniter\Controller
{
    public function ola()
    {
        if (!is_cli()) {
            echo "NÃO É CLI\n";
            return;
        }

        echo "FUNCIONOU VIA CLI!\n";
    }
}
