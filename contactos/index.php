<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Contactos</title>
    <!-- Agrega el enlace al archivo CSS de Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../navbar.html"); ?>

<div class="container mt-4">
    <?php
    echo '<h2>Lista de Contactos</h2>';

    include("../connection.php");

    try {


        echo "<a href='add.php' class='btn btn-success btn-sm'>Agregar un contacto nuevo</a>";
        // Consulta SQL para obtener todos los contactos
        $contacto_especifico = isset($_GET['id_contacto']) ? $_GET['id_contacto'] : null;
        $sql = "SELECT * FROM contactos";
        if ($contacto_especifico !== null){
            $sql = "SELECT * FROM contactos WHERE contactos.id = {$contacto_especifico}";
        }
        else{
            $sql = "SELECT * FROM contactos";
        }
        
        
        $resultados = $conn->query($sql);

        // Verificar si hay resultados
        if ($resultados->rowCount() > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead class='thead-light'>";
            echo "<tr><th>Nombre</th><th>Número</th><th>Dirección</th><th>Acciones</th></tr>";
            echo "</thead><tbody>";

            // Mostrar los datos en la tabla
            foreach ($resultados as $fila) {
                echo "<tr>";
                //echo "<td>" . $fila['id'] . "</td>";
                echo "<td>" . $fila['nombre'] . "</td>";
                echo "<td>" . $fila['numero'] . "</td>";
                echo "<td>" . $fila['direccion'] . "</td>";
                echo "<td>";
                echo "<a href='edit.php?id=" . $fila['id'] . "' class='btn btn-primary btn-sm'>Editar</a> ";
                echo "<a href='delete.php?id=" . $fila['id'] . "' class='btn btn-danger btn-sm'>Eliminar</a> ";
                echo "<a href='../grupos/index.php' class='btn btn-warning btn-sm'>Agregar a un grupo</a>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-info'>No hay contactos para mostrar.</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error al obtener contactos: " . $e->getMessage() . "</div>";
    }
    ?>
</div>
    <!-- Agrega los scripts de Bootstrap y jQuery al final del cuerpo del documento para mejorar el rendimiento -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
