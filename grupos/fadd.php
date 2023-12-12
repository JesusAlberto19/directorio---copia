<?php
// Configuración de la base de datos (modifica los valores según tu configuración)
include("../connection.php");

try {
    // Obtiene los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $contactos = isset($_POST['contactos']) ? $_POST['contactos'] : array();

    // Procesa la foto (guarda el archivo en una carpeta y guarda la ruta en la base de datos)
    if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $foto_temp = $_FILES['foto']['tmp_name'];
        $foto_nombre = $_FILES['foto']['name'];
        $foto_ruta = "imgs/$foto_nombre";
        move_uploaded_file($foto_temp, $foto_ruta);
    } else {
        $foto_ruta = null;
    }

    // Inserta los datos en la tabla "grupos" usando una consulta preparada
    $sql = "INSERT INTO grupos (nombre, descripcion, foto) VALUES (:nombre, :descripcion, :foto)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':descripcion', $descripcion);
    $stmt->bindParam(':foto', $foto_ruta);
    $stmt->execute();

    $nuevo_grupo_id = $conn->lastInsertId();

    // Asocia los contactos seleccionados al nuevo grupo en una tabla de relación
    foreach ($contactos as $contacto_id) {
        $sql_relacion = "INSERT INTO contacto_grupo_relacion (grupo_id, contacto_id) VALUES (:grupo_id, :contacto_id)";
        $stmt_relacion = $conn->prepare($sql_relacion);
        $stmt_relacion->bindParam(':grupo_id', $nuevo_grupo_id);
        $stmt_relacion->bindParam(':contacto_id', $contacto_id);
        $stmt_relacion->execute();
    }

    echo "Datos almacenados con éxito.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cierra la conexión
header("refresh:2; url=index.php");
?>
