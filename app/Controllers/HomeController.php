<?php

namespace App\Controllers;

use App\Models\Contactos;

class HomeController extends Controller{

    public function index() {

        $contactoModel = new Contactos();

        // return $contactoModel->create([
        //     "name" => "John Doe",
        //     "email" => "johndoe@example.com",
        //     "phone" => "1234567890",

        // ]);


        return $this->view("home", [
            "title" => "Home",
            "message" => "Hello World",
        ]);
        
    }

}
