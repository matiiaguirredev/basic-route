<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Contactos;

class ContactController extends Controller{

    public function index() {
        
        $model = new Contactos();

        if(isset($_GET['search'])){
            $contactos = $model->where('name', 'LIKE' , '%' .  $_GET['search'] . '%')->paginate(5);

        }else {
            $contactos = $model->paginate(3);
        }

        return $this->view('contactos.index', compact("contactos"));
    }

    public function create() {

        return $this->view('contactos.create');

    }

    public function store() {

        $data = $_POST;
        $model = new Contactos();
        $model->create($data);

        return $this->redirect("/contacts");

    }

    public function show($id) {
        $model = new Contactos();
        $contacto = $model->find($id);
        return $this->view('contactos/show', compact('contacto'));
    }

    public function edit($id) {
        $model = new Contactos();
        $contacto = $model->find($id);

        return $this->view('contactos/edit', compact('contacto'));
    }

    public function update($id) {

        $data = $_POST;
        $model = new Contactos();
        $model->update($id, $data);

        $this->redirect("/contacts/$id");

    }

    public function destroy($id) {

        $model = new Contactos();
        $model->delete($id);

        return $this->redirect("/contacts");

    }
}