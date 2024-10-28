<?php

namespace App\Controllers;

use App\Models\Contactos;

class HomeController extends Controller{

    public function index() {

        $contactoModel = new Contactos();

        return $contactoModel->where("id", ">" , "2")->get();

        return $this->view("home", [
            "title" => "Home",
            "message" => "Hello World",
        ]);
        
    }

}
