<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Editar Grupo</title>
</head>
<body>

<div class="container mt-5">
    <h2>Editar Grupo</h2>

    <form action="fedit.php" method="POST" enctype="multipart/form-data">
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            echo '<input type="text" name="id" value="'.$id.'" hidden required>';
        } else {
            echo '<div class="alert alert-danger">No se seleccionó ningún contacto.</div>';
            exit();
        }
        ?> 
        
        <div class="form-group">
            <label for="nombre">Nombre del Grupo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción del Grupo</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label for="foto">Foto</label>
            <input type="file" class="form-control-file" id="foto" name="foto">
        </div>
        <div class="form-group">
            <label>Contactos a Agregar</label>
            <!-- Utilizar checkboxes para la selección de contactos -->
            <?php
                include('../connection.php');
                $sql = "SELECT * FROM contactos";
                $resultados = $conn->query($sql);
                // Se obtiene el array de los contactos mediante el SELECT
                $contactos = $resultados->fetchAll();
                if ($resultados->rowCount() > 0) {
                    foreach ($contactos as $contacto) {
                        echo '<div class="form-check">';
                        echo '<input type="checkbox" class="form-check-input" id="contacto' . $contacto['id'] . '" name="contactos[]" value="' . $contacto['id'] . '">';
                        echo '<label class="form-check-label" for="contacto' . $contacto['id'] . '">' . $contacto['nombre'] . ' (' . $contacto['numero'] . ')</label>';
                        echo '</div>';
                    }
                }
                else {
                    echo "<div class='alert alert-info'>No hay contactos para mostrar.</div>";
                }
            ?>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Captura el evento de envío del formulario
        $('form').submit(function(event) {
            // Encuentra todos los checkboxes marcados
            var checkboxesSeleccionados = $('input[type="checkbox"]:checked');

            // Verifica si al menos un checkbox está seleccionado
            if (checkboxesSeleccionados.length === 0) {
                // Si no hay checkboxes seleccionados, muestra un mensaje de alerta y evita el envío del formulario
                alert('Debe seleccionar al menos un contacto antes de enviar el formulario.');
                event.preventDefault();
            }
        });

        // Script para resaltar opciones seleccionadas
        $('input[type="checkbox"]').change(function() {
            // Toggle la clase 'selected-option' al contenedor del checkbox
            $(this).closest('.form-check').toggleClass('selected-option', this.checked);
        });
    });
</script>
</body>
</html>
