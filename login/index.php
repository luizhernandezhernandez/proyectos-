<?php
	echo "El servidor ha recibido los siguientes datos: <br>";


	$nombre		= isset($_POST['nombre'])?$_POST['nombre']:"";
	$direccion	= isset($_POST['direccion'])?$_POST['direccion']:"";
	$telefono	= isset($_POST['telefono'])?$_POST['telefono']:"";
	$correo 		= isset($_POST['correo'])?$_POST['correo']:"";

	$nombre		= filter_var($nombre,FILTER_SANITIZE_STRING);
	$direccion	= filter_var($direccion,FILTER_SANITIZE_STRING);
	$telefono	= filter_var($telefono,FILTER_SANITIZE_STRING);
	$correo		= filter_var($correo,FILTER_SANITIZE_STRING);

	$mysqli = new mysqli("localhost", "hacker",
		 "seguridadmaxima", "vulnerable");

	$sql = "INSERT INTO cliente ".
			 "(nombre,direccion,telefono, correo) ".
			" VALUES (?,?,?,?)";

	//--- Preparar la sentencia
	$sentencia = $mysqli->prepare($sql);
	if($sentencia === false) {
	trigger_error('ERROR: ' . $mysqli->errno .
		 ' ' . $mysqli->error,	E_USER_ERROR);
	}
	//--- establecer los parametros
	$sentencia->bind_param('ssss', 
					$nombre,$direccion,$telefono,$correo);
	//--- Ejecutar la sentencia
	$sentencia->execute();
	//--- recuperar resultado en un arreglo

	$resultado = $mysqli->query("SELECT * FROM cliente");

	$tabla="<table border='1'>";
	foreach ($resultado as $fila){
		$tabla=$tabla."<tr>";
		foreach ($fila as $k=>$v){
			$tabla=$tabla."<td>".$v."</td>";						
		}
		$tabla=$tabla."</tr>";
	}
	$tabla=$tabla."</table>";
	echo $tabla;



?>

