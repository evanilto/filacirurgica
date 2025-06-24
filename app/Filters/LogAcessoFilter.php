<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LogAcessoFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $ip        = $request->getIPAddress();
        $metodo    = $request->getMethod(); // GET, POST, etc.
        //$uri       = current_url();
        $rota = $request->getUri()->getPath(); 
        $navegador = $this->detectarNavegador($_SERVER['HTTP_USER_AGENT'] ?? 'Desconhecido');
        $dataHora  = date('Y-m-d H:i:s');

        $session = session();
        //$usuario = $session->get('usuario_nome') ?? 'Anônimo';
        $usuario = $_SESSION['Sessao']['Nome'] ?? 'Anônimo';
        //$dadosPost = $request->getPost();
        //$dadosTexto = empty($dadosPost) ? '' : "\nPOST Data: " . json_encode($dadosPost, JSON_UNESCAPED_UNICODE);

        $linha = "[{$dataHora}] IP: {$ip} - Usuário: {$usuario} - {$rota} - Navegador: {$navegador}\n";

        $arquivoNome = 'acessos-' . date('Y-m-d') . '.log';
        $logPath = WRITEPATH . 'logs/' . $arquivoNome;

        file_put_contents($logPath, $linha, FILE_APPEND);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nenhuma ação no after
    }

    private function detectarNavegador($agente)
    {
        if (strpos($agente, 'Firefox') !== false) return 'Firefox';
        if (strpos($agente, 'Edg') !== false) return 'Edge';
        if (strpos($agente, 'Chrome') !== false && strpos($agente, 'Edg') === false) return 'Chrome';
        if (strpos($agente, 'Safari') !== false && strpos($agente, 'Chrome') === false) return 'Safari';
        if (strpos($agente, 'Opera') !== false || strpos($agente, 'OPR') !== false) return 'Opera';
        if (strpos($agente, 'MSIE') !== false || strpos($agente, 'Trident/') !== false) return 'Internet Explorer';
        return 'Desconhecido';
    }
}
