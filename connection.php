<?php


#Inicio de colección de errores
try {
	#Credenciales de la base de datos

	#URL de la base de datos - Nombre - Usuario - Contraseña
	$servername = "localhost";
	$dbname = "directorio";
	$username = "root";
	$password = "";

	#Inicio de conexión con PDO PHP
	$conn = new PDO(
		"mysql:host=$servername; dbname=$dbname",
		$username, $password
	);
	
	#Colocar atributos al inicio de conexión:
	#Se coloca atributo para mostrar errores y lanzar una excepción en caso de un error
	$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
#En caso de error ejecutar un mensaje de error
catch(PDOException $e) {echo "Error de conexión: " . $e->getMessage();}

?>
