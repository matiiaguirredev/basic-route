
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Actualizar contacto</h1>
    <a href="/contacts/">Volver</a>


    <form action="/contacts/<?= $contacto['id'] ?>" method="post">

        Id del usuario: <?=$contacto['id'] ?><br>
        <input type="text" name="name" value='<?=$contacto['name'] ?>'><br>
        <input type="email" name="email" value='<?=$contacto['email'] ?>'><br>
        <input type="text" name="phone" value='<?=$contacto['phone'] ?>'><br>

        <input type="submit" value="Actualizar">
    </form>

    <form action="/contacts/<?= $contacto['id'] ?>/delete" method="post">
        <input type="submit" value="Eliminar">
    </form>
</body>
</html>