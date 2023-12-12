<?php
// Configuración de la base de datos
include("../connection.php");

try {
    // Recibir datos del formulario
    $id = $_POST['id'];
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
    $numero = isset($_POST['numero']) ? $_POST['numero'] : null;
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : null;

    // Comprobar si se proporcionó al menos un campo para actualizar
    if (!$nombre && !$numero && !$direccion) {
        echo "No se proporcionaron datos para actualizar.";
        exit;
    }

    // Construir la consulta SQL dinámicamente según los campos proporcionados
    $sql = "UPDATE contactos SET ";
    $actualizaciones = [];

    if ($nombre) {
        $actualizaciones[] = "nombre = :nombre";
    }

    if ($numero) {
        $actualizaciones[] = "numero = :numero";
    }

    if ($direccion) {
        $actualizaciones[] = "direccion = :direccion";
    }

    $sql .= implode(", ", $actualizaciones);
    $sql .= " WHERE id = :id";

    // Preparar la consulta SQL utilizando marcadores de posición
    $consulta = $conn->prepare($sql);

    // Vincular parámetros
    $consulta->bindParam(':id', $id);

    if ($nombre) {
        $consulta->bindParam(':nombre', $nombre);
    }

    if ($numero) {
        $consulta->bindParam(':numero', $numero);
    }

    if ($direccion) {
        $consulta->bindParam(':direccion', $direccion);
    }

    // Ejecutar la consulta
    $consulta->execute();

    echo "Contacto editado exitosamente";
} catch (PDOException $e) {
    echo "Error al editar contacto: " . $e->getMessage();
}
header("refresh:2; url=index.php");

?>
