<?php

use App\Models\Contactos;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Detalle del contacto</h1>

    <form action="" method="GET">

    <a href="/contacts/<?= $contacto['id'] ?>/edit">Editar</a>
    <br>
        <?=$contacto['id'] ?>
        <input type="text" name="name" value='<?=$contacto['name'] ?>'>
        <input type="email" name="email" value='<?=$contacto['email'] ?>'>
        <input type="text" name="phone" value='<?=$contacto['phone'] ?>'>

        <input type="submit" value="Actualizar">
    </form>
</body>
</html>