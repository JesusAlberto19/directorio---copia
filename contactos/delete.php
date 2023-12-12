<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Contacto</title>
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Eliminar Contacto</h2>

    <form action="fdelete.php" method="post">

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            echo '<input type="text" name="id" value="'.$id.'" hidden required>';
        } else {
            echo '<div class="alert alert-danger">No se seleccionó ningún contacto.</div>';
            exit();
        }
        ?> 

        <!-- Grupo de Confirmación -->
        <div class="form-group">
            <label for="id">¿Está seguro de eliminar este registro?</label>
        </div>

        <!-- Botón de Eliminar Contacto -->
        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <!-- Agrega los scripts de Bootstrap y jQuery al final del cuerpo del documento para mejorar el rendimiento -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
