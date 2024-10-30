<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

    <div class="container p-10">

        <h1 class="text-2x1 font-bold mb-2">LISTADO DE CONTACTOS</h1>

        <form action="/contacts" method="" class="flex">
            <input type="text" name="search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Escriba el contacto que quiere buscar" required />

            <button class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Buscar
            </button>
        </form>

        <a href="/contacts/create">Crear contacto</a>

        <ul class="list-disc list-inside">

            <?php foreach ($contactos['data'] as $contacto) { ?>
                <li>
                    <a href="/contacts/<?= $contacto["id"] ?>">
                        <?= ucfirst($contacto["name"]) ?>
                    </a>
                </li>

            <?php }; ?>
        </ul>

        <?php
        $paginate = "contactos";

        require_once '../resources/views/assets/pagination.php';

        ?>
    </div>
</body>

</html>