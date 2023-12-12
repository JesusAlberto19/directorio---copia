<?php
include("../connection.php");

try {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $id_grupo = $_POST['id'];
    $contactos = isset($_POST['contactos']) ? $_POST['contactos'] : array();

    // Verifica la existencia del grupo antes de la actualización
    $verificar_grupo = "SELECT COUNT(*) FROM grupos WHERE id = :grupo_id";
    $stmt_verificar_grupo = $conn->prepare($verificar_grupo);
    $stmt_verificar_grupo->bindParam(':grupo_id', $id_grupo);
    $stmt_verificar_grupo->execute();

    if ($stmt_verificar_grupo->fetchColumn() <= 0) {
        echo "El grupo no existe.";
        exit;
    }

    // Procesa la foto
    if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_temp = $_FILES['foto']['tmp_name'];
        $foto_nombre = $_FILES['foto']['name'];
        $foto_ruta = "../imgs/$foto_nombre";

        // Elimina la foto anterior si existe
        $sql_eliminar_foto = "SELECT foto FROM grupos WHERE id = :grupo_id";
        $stmt_eliminar_foto = $conn->prepare($sql_eliminar_foto);
        $stmt_eliminar_foto->bindParam(':grupo_id', $id_grupo);
        $stmt_eliminar_foto->execute();
        $foto_anterior = $stmt_eliminar_foto->fetchColumn();

        if ($foto_anterior && file_exists($foto_anterior)) {
            unlink($foto_anterior);
        }

        // Mueve la nueva foto a la carpeta
        move_uploaded_file($foto_temp, $foto_ruta);
    } else {
        $foto_ruta = null;
    }

    // Actualiza los datos del grupo
    $sql_actualizar_grupo = "UPDATE grupos SET nombre = :nombre, descripcion = :descripcion, foto = :foto WHERE id = :grupo_id";
    $stmt_actualizar_grupo = $conn->prepare($sql_actualizar_grupo);
    $stmt_actualizar_grupo->bindParam(':nombre', $nombre);
    $stmt_actualizar_grupo->bindParam(':descripcion', $descripcion);
    $stmt_actualizar_grupo->bindParam(':foto', $foto_ruta);
    $stmt_actualizar_grupo->bindParam(':grupo_id', $id_grupo);
    $stmt_actualizar_grupo->execute();

    // Elimina todas las relaciones existentes
    $sql_eliminar_relaciones = "DELETE FROM contacto_grupo_relacion WHERE grupo_id = :grupo_id";
    $stmt_eliminar_relaciones = $conn->prepare($sql_eliminar_relaciones);
    $stmt_eliminar_relaciones->bindParam(':grupo_id', $id_grupo);
    $stmt_eliminar_relaciones->execute();

    // Inserta las nuevas relaciones
    foreach ($contactos as $contacto_id) {
        $sql_insertar_relacion = "INSERT INTO contacto_grupo_relacion (contacto_id, grupo_id) VALUES (:contacto_id, :grupo_id)";
        $stmt_insertar_relacion = $conn->prepare($sql_insertar_relacion);
        $stmt_insertar_relacion->bindParam(':grupo_id', $id_grupo);
        $stmt_insertar_relacion->bindParam(':contacto_id', $contacto_id);
        $stmt_insertar_relacion->execute();
    }

    echo "Datos almacenados con éxito.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

header("refresh:2; url=index.php");
?>