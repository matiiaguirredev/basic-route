<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Contactos;

class ContactController extends Controller{

    public function index() {

        $model = new Contactos();
        $contactos = $model->all();

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
        return "aqui se mostrara el formulario para editar el contacto con id: {$id}";
    }

    public function update($id) {
        return "aqui se procesara el formulario para editar el contacto con id: {$id}";
    }

    public function destroy($id) {
        return "aqui se eliminara el contacto con id: {$id}";
    }
}