<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use PDO;
use PDOException;

class PacientesController extends Controller
{
    public function inserir_paciente()
    {
        // Simulação de dados recebidos (exemplo de dados)
        $data = [
            'prontuario' => '52345',
            'especialidade' => '1',
            'cid' => '10',
            'complexidade' => 'Baixa',
            'fila' => '1',
            'risco' => '2',
            'origem' => '1',
            'congelacao' => 'sim',
            'procedimento' => '1',
            'lateralidade' => 'Nenhuma',
            'info' => 'Informações adicionais',
            'justorig' => 'Justificativa de origem'
        ];

        // Configurações do banco de dados
        $dsn = 'pgsql:host=10.88.1.79;port=5432;dbname=dbfilacirurgica;';
        $username = 'postgres';
        $password = 'postgres';

        try {
            // Conectar ao banco de dados com PDO
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Preparar a instrução SQL
            $sql = "INSERT INTO lista_espera (numprontuario, idespecialidade, numcid, nmcomplexidade, idtipoprocedimento, idriscocirurgico,
             idorigempaciente, indcongelacao, idprocedimento, nmlateralidade, txtinfoadicionais, txtorigemjustificativa) 
             VALUES (:numprontuario, :idespecialidade, :numcid, :nmcomplexidade, :idtipoprocedimento, :idriscocirurgico, :idorigempaciente,
              :indcongelacao, :idprocedimento, :nmlateralidade, :txtinfoadicionais, :txtorigemjustificativa)";

            // Preparar a instrução para execução
            $stmt = $pdo->prepare($sql);

            // Associar os valores aos parâmetros
            $stmt->bindParam(':numprontuario', $data['prontuario']);
            $stmt->bindParam(':idespecialidade', $data['especialidade']);
            $stmt->bindParam(':numcid', $data['cid']);
            $stmt->bindParam(':nmcomplexidade', $data['complexidade']);
            $stmt->bindParam(':idtipoprocedimento', $data['fila']);
            $stmt->bindParam(':idriscocirurgico', $data['risco']);
            $stmt->bindParam(':idorigempaciente', $data['origem']);
            $stmt->bindParam(':indcongelacao', $data['congelacao']);
            $stmt->bindParam(':idprocedimento', $data['procedimento']);
            $stmt->bindParam(':nmlateralidade', $data['lateralidade']);
            $stmt->bindParam(':txtinfoadicionais', $data['info']);
            $stmt->bindParam(':txtorigemjustificativa', $data['justorig']);

            // Definir o valor da situação
            $indsituacao = 'A';

            // Executar a inserção
            $stmt->execute();

            echo "Paciente incluído com sucesso!";
        } catch (PDOException $e) {
            echo 'Erro de PDO: ' . $e->getMessage();
        } catch (\Exception $e) {
            echo 'Erro geral: ' . $e->getMessage();
        }
    }
}