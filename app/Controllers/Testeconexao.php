<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Oracle\Connection;

class Testeconexao extends Controller
{
    protected $db;

    public function __construct()
    {
    }

    public function index($db)
    {
        $this->db = db_connect($db); // Use o nome da conexão definido em $dbamv no seu arquivo Database.php

        if (!$this->db->initialize()) {
            die("Falha ao conectar ao banco de dados.");
        } else {
            echo "Conexão bem-sucedida!";
        }
    }
}

