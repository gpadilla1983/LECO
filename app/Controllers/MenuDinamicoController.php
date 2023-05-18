<?php

namespace App\Controllers;
use App\Models\{menuDinamicoModel};

class MenuDinamicoController extends BaseController
{

    private $miMenuDinamico;

    function __construct()
    {
        $this->miMenuDinamico = new menuDinamicoModel();
    }

    public function GetVista()
    {
        if (session()->get('id_usuario') == null) {
            return redirect()->route('/');
        } else {

            $id_usuario = session()->get('id_usuario');

            $datos['MenuDinamico'] = $this->miMenuDinamico->where('id_usuario', $id_usuario)->findAll();
            return view('MasterPage/Menu/menuDinamico', $datos);

            
        }
        
    }
}