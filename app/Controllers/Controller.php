<?php

namespace App\Controllers;

class Controller {
    
    public function view($route, $data = []) {

        extract($data);

        $route = str_replace(".", "/", $route);

        if (file_exists("../public/resources/views/{$route}.php")) {

            ob_start();
            include("../public/resources/views/{$route}.php");
            $content = ob_get_clean();
            
            return $content;

        } else {
            echo "El archivo NO existe";
        }
    }

    public function redirect($route) {
        header("Location: $route");
        exit;
    }
}
