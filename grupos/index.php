<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Visualizar Grupos</title>
</head>
<body>
<?php include("../navbar.html"); ?>
<div class="container mt-4">
    <h2>Grupos de Contactos</h2>
    <a href='add.php' class='btn btn-success btn-sm'>Agregar un grupo nuevo</a>
    <div id="accordion">
    <?php
    // Configuración de la base de datos (modifica los valores según tu configuración)
    include("../connection.php");

    try {
        // Consulta para obtener los grupos y sus contactos asociados
        $sql = "SELECT grupos.id as grupo_id, grupos.nombre as grupo_nombre, grupos.descripcion, grupos.foto as grupo_foto, contactos.id as contacto_id, contactos.nombre as contacto_nombre, contactos.numero as contacto_numero, contactos.direccion as contacto_direccion
                FROM grupos
                LEFT JOIN contacto_grupo_relacion ON grupos.id = contacto_grupo_relacion.grupo_id
                LEFT JOIN contactos ON contacto_grupo_relacion.contacto_id = contactos.id
                ORDER BY grupos.id, contactos.id";

        $grupo_especifico = isset($_GET['id_grupo']) ? $_GET['id_grupo'] : null;

        if ($grupo_especifico !== null){
            $sql = "SELECT grupos.id as grupo_id, grupos.nombre as grupo_nombre, grupos.descripcion, grupos.foto as grupo_foto, contactos.id as contacto_id, contactos.nombre as contacto_nombre, contactos.numero as contacto_numero, contactos.direccion as contacto_direccion
                FROM grupos
                LEFT JOIN contacto_grupo_relacion ON grupos.id = contacto_grupo_relacion.grupo_id
                LEFT JOIN contactos ON contacto_grupo_relacion.contacto_id = contactos.id
                WHERE grupos.id = {$grupo_especifico}
                ORDER BY grupos.id, contactos.id";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $currentGroupId = null;

        foreach ($result as $row) {
            $grupo_id = $row['grupo_id'];
            if ($grupo_id !== $currentGroupId) {
                // Cerrar la tabla si hay un grupo anterior
                if ($currentGroupId !== null) {
                    echo "</tbody></table></div></div>  ";
                }

                // Iniciar la card y el accordion para el nuevo grupo
                echo "<div class='card'>";
                
                echo "<div class='card-header' id='heading{$grupo_id}'>";
                
                echo "<h5 class='mb-0'>";
                if (!empty($row['grupo_foto'])) {
                    echo "<img src='{$row['grupo_foto']}' alt='{$row['grupo_nombre']}' style='height:15%;max-height:100px;width:15%;max-width:100px;'>";
                } else {
                    echo "";
                }
                
                echo "<button class='btn btn-link' data-toggle='collapse' data-target='#collapse{$grupo_id}' aria-expanded='true' aria-controls='collapse{$grupo_id}'>";

                echo "{$row['grupo_nombre']}";
                
                echo "</button>";

                echo "<a href='edit.php?id={$grupo_id}' class='btn btn-warning'>Editar</a>  ";
                echo "<a href='delete.php?id={$grupo_id}' class='btn btn-danger'>Eliminar</a>";
                echo "</h5>";
                echo "</div>";

                echo "<div id='collapse{$grupo_id}' class='collapse' aria-labelledby='heading{$grupo_id}' data-parent='#accordion'>";
                echo "<div class='card-body'>";
                echo "<table class='table'>";
                echo "<thead><tr><th>Número</th><th>Nombre</th><th>Direcciones</th><th>Acciones</th></tr></thead>";
                echo "<tbody>";
                $currentGroupId = $grupo_id;
            }

            // Mostrar fila de contacto
            echo "<tr>";
            echo "<td>{$row['contacto_numero']}</td>";
            echo "<td>{$row['contacto_nombre']}</td>";
            echo "<td>{$row['contacto_direccion']}</td>";
            echo "<td><a href='../contactos/index.php?id_contacto={$row['contacto_id']}' class='btn btn-warning'>Editar contacto</a></td>";
            //echo "<td><a href='editar_contacto.php?id={$row['contacto_id']}' class='btn btn-warning'>Editar</a> ";
            //echo "<a href='eliminar_contacto.php?id={$row['contacto_id']}' class='btn btn-danger'>Eliminar</a></td>";
            echo "</tr>";
            
        }
        

        // Cerrar la última tabla y la card
        if ($currentGroupId !== null) {
            echo "</tbody></table>";
            echo "</div></div>";
        }

        if (empty($result)) {
            echo "<p>No hay grupos de contactos disponibles.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Cierra la conexión
    //$pdo = null;
    ?>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>
