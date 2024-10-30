<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="/contacts/">Volver</a>
    <a href="/contacts/<?= $contacto['id'] ?>/edit">Editar</a>

    <h1>Detalle del contacto</h1>
    <p>Nombre:<?= $contacto['name'] ?> </p>
    <p>Email: <?= $contacto['email'] ?></p>
    <p>Phone: <?= $contacto['phone'] ?></p>

    <!-- <form action="/contacts/<?= $contacto['id'] ?>/delete" method="post">
        <input type="submit" value="Eliminar">
    </form> -->
</body>

</html>