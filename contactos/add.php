<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Contactos</title>
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2 class="mb-4">Crear un contacto nuevo</h2>

    <form action="fadd.php" method="post">

        <!-- Grupo de Nombre -->
        <div class="form-group">
            <label for="nombre">Nombre*</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <!-- Grupo de Número de Teléfono -->
        <div class="form-group">
            <label for="numero">Número de Teléfono*</label>
            <input type="tel" class="form-control" name="numero" pattern="[0-9+]{1,15}" required>
        </div>
        
        <!-- Grupo de Dirección -->
        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" class="form-control" name="direccion">
        </div>

        <!-- Botón de Agregar Contacto -->
        <button type="submit" class="btn btn-primary">Agregar Contacto</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>

    <!-- Agrega los scripts de Bootstrap y jQuery al final del cuerpo del documento para mejorar el rendimiento -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
