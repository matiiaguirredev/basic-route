<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>LISTADO DE CONTACTOS</h1>

    <a href="/contacts/create">Crear contacto</a>

    <ul>
        <?php foreach ($contactos as $contacto): ?>
            <li>
                <a href="/contacts/<?= $contacto["id"] ?>">
                    <?= ucfirst($contacto["name"]) ?>
                </a>
            </li>

        <?php endforeach; ?>
    </ul>
</body>

</html>