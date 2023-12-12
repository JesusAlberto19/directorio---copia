<?php
include("../connection.php");

try {
    // Verifica si se proporciona el ID del grupo a eliminar
    if (!isset($_GET['id'])) {
        echo "No se proporcionó un ID de grupo.";
        exit;
    }

    $id_grupo = $_GET['id'];

    // Verifica la existencia del grupo antes de la eliminación
    $verificar_grupo = "SELECT COUNT(*) FROM grupos WHERE id = :grupo_id";
    $stmt_verificar_grupo = $conn->prepare($verificar_grupo);
    $stmt_verificar_grupo->bindParam(':grupo_id', $id_grupo);
    $stmt_verificar_grupo->execute();

    if ($stmt_verificar_grupo->fetchColumn() <= 0) {
        echo "El grupo no existe.";
        header("refresh:2; url=index.php");
        exit;
    }

    // Obtén la ruta de la foto del grupo antes de la eliminación
    $sql_obtener_foto = "SELECT foto FROM grupos WHERE id = :grupo_id";
    $stmt_obtener_foto = $conn->prepare($sql_obtener_foto);
    $stmt_obtener_foto->bindParam(':grupo_id', $id_grupo);
    $stmt_obtener_foto->execute();
    $foto_a_eliminar = $stmt_obtener_foto->fetchColumn();

    // Elimina la foto del grupo si existe
    if ($foto_a_eliminar && file_exists($foto_a_eliminar)) {
        unlink($foto_a_eliminar);
    }

    // Elimina todas las relaciones con contactos
    $sql_eliminar_relaciones = "DELETE FROM contacto_grupo_relacion WHERE grupo_id = :grupo_id";
    $stmt_eliminar_relaciones = $conn->prepare($sql_eliminar_relaciones);
    $stmt_eliminar_relaciones->bindParam(':grupo_id', $id_grupo);
    $stmt_eliminar_relaciones->execute();

    // Elimina el grupo
    $sql_eliminar_grupo = "DELETE FROM grupos WHERE id = :grupo_id";
    $stmt_eliminar_grupo = $conn->prepare($sql_eliminar_grupo);
    $stmt_eliminar_grupo->bindParam(':grupo_id', $id_grupo);
    $stmt_eliminar_grupo->execute();

    echo "Grupo y relaciones eliminados con éxito.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header("refresh:2; url=index.php");
?>
