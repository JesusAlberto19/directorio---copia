<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Grupo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Eliminar Grupo</h2>
    <form action="fdelete.php" method="GET">

        <!-- Input oculto para pasar el ID del grupo a eliminar -->
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            echo '<input type="text" name="id" value="'.$id.'" hidden required>';
        } else {
            echo '<div class="alert alert-danger">No se seleccionó ningún contacto.</div>';
            exit();
        }
        ?>
        <p>¿Estás seguro de que deseas eliminar este grupo?</p>

        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>