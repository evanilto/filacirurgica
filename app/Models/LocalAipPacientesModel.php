<?php

namespace App\Models;

use CodeIgniter\Model;

class LocalAipPacientesModel extends Model
{
    protected $table            = 'local_aip_pacientes';
    protected $primaryKey       = 'prontuario';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'codigo',                                    
        'prontuario',                                
        'nome',                                      
        'nm_mae',                                    
        'email',                                  
        'nm_resp',                                   
        'dt_nascimento',                             
        'idade',                           
        'uf',                                   
        'cor',                                      
        'sexo',                                     
        'nacionalidade',                             
        'tel_1',                           
        'tel_2',                                     
        'logradouro',                                
        'num_logr',                                  
        'compl_logr',                                
        'bairro',                                    
        'cidade',                                    
        'cep',                                       
        'cpf',                                       
        'rg',                                        
        'orgao_emis_rg',                             
        'descricao',                                 
        'data_emissao_docto',                        
        'uf_sigla_emitiu_docto',                     
        'doc',                                       
        'cns',                                       
        'be',                                        
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
