<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        
        if (!session()->get('isLoggedIn') && strpos($request->getUri()->getPath(), 'login') === false && trim($request->getUri()->getPath(), '/') != 'index.php') {
                return redirect()->to('/');
        }
        
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não precisa de lógica no after
    }
}
