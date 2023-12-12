<?php
include("../connection.php");


try {
    // Recibir el ID del formulario
    $id = $_POST['id'];

    // Preparar la consulta SQL para eliminar el contacto por ID
    $sql = "DELETE FROM contactos WHERE id = :id";
    $consulta = $conn->prepare($sql);

    // Vincular parámetros
    $consulta->bindParam(':id', $id);

    // Ejecutar la consulta
    $consulta->execute();

    echo "Contacto eliminado exitosamente";
} catch (PDOException $e) {
    echo "Error al eliminar contacto: " . $e->getMessage();
}
header("refresh:2; url=index.php");
?>
