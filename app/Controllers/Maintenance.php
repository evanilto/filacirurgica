<?php

namespace App\Controllers;

class Maintenance extends BaseController
{
    public function index()
    {
        $this->response->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', '0');
        
        return view('maintenance');
    }
}
