<?php
// Configuración de la base de datos
include("../connection.php");


try {
    // Recibir datos del formulario
    $nombre = $_POST['nombre'];
    $numero = $_POST['numero'];
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';

    // Preparar la consulta SQL utilizando marcadores de posición
    $sql = "INSERT INTO contactos (nombre, numero, direccion) VALUES (:nombre, :numero, :direccion)";
    $consulta = $conn->prepare($sql);

    // Vincular parámetros
    $consulta->bindParam(':nombre', $nombre);
    $consulta->bindParam(':numero', $numero);
    $consulta->bindParam(':direccion', $direccion);

    // Ejecutar la consulta
    $consulta->execute();

    echo "Contacto agregado exitosamente";
} catch (PDOException $e) {
    echo "Error al agregar contacto: " . $e->getMessage();
}
    
header("refresh:2; url=index.php");

?>
