<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {
            
            return view('MasterPage/PaginaPrincipal');
        }
        

        
    }
}
