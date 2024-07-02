<?php

namespace App\Controllers;

use App\Libraries\HUAP_Functions;
use CodeIgniter\RESTful\ResourceController;

class Aghu extends ResourceController
{
    private $db;
    
    public function __construct()
    {
        $this->db = \Config\Database::connect('aghux');

    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
    }

    /**
     * Retorna todos os Aghus cadastrados
     *
     * @return mixed
     */
    public function getSetores() {

        $sql = "SELECT seq, descricao FROM  AGH.AGH_UNIDADES_FUNCIONAIS uf WHERE ind_sit_unid_func = 'A'";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna todos os Aghus cadastrados
     *
     * @return mixed
     */
    public function getSetor(string $setor = null) {

        $sql = "SELECT * FROM  AGH.AGH_UNIDADES_FUNCIONAIS uf WHERE upper(descricao) = upper('$setor')";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getPaciente(int $prontuario) {

        $sql = "SELECT * FROM agh.aip_pacientes WHERE prontuario = $prontuario";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getPacientePorCodigo(int $codigo) {

        $sql = "SELECT * FROM agh.aip_pacientes WHERE prontuario NOTNULL AND codigo = $codigo";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getPacientePorNome(string $nome) {

        $nome =  strtoupper(HUAP_Functions::remove_accents($nome));

        $sql = "SELECT * FROM agh.aip_pacientes WHERE prontuario NOTNULL AND nome like '$nome'";

        //var_dump($sql);die();

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
    /**
     * Retorna o prontuario cadastrado no aghu
     *
     * @return mixed
     */
    public function getPacientePorNomeMae(string $nome) {

        $nome =  strtoupper(HUAP_Functions::remove_accents($nome));

        $sql = "SELECT * FROM agh.aip_pacientes WHERE prontuario NOTNULL AND nome_mae like '$nome'";

        $query = $this->db->query($sql);

        $result = $query->getResult();

        return $result;

    }
}
