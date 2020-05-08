<?php 
	include_once 'conexion.php';
	
	if(isset($_POST['guardar'])){
		$id_categoria=$_POST['id_categoria'];
		$nombre=$_POST['nombre'];
		$descripcion=$_POST['descripcion'];
		$precio_venta=$_POST['precio_venta'];
		$precio_compra=$_POST['precio_compra'];
		$color=$_POST['color'];

		if(!empty($id_categoria) && !empty($nombre) && !empty($descripcion) && !empty($precio_venta) && !empty($precio_compra) && !empty($color)){
			
				$consulta_insert=$con->prepare('INSERT INTO producto(id_categoria,nombre,descripcion,precio_venta,precio_compra,color) VALUES(:id_categoria,:nombre,:descripcion,:precio_venta,:precio_compra,:color)');
				$consulta_insert->execute(array(
					':id_categoria' =>$id_categoria,
					':nombre' =>$nombre,
					':descripcion' =>$descripcion,
					':precio_venta' =>$precio_venta,
					':precio_compra' =>$precio_compra,
					':color' =>$color
				));
				header('Location: index.php');
			
		}else{
			echo "<script> alert('Los campos estan vacios');</script>";
		}

	}


?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Nuevo producto</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<div class="contenedor">
		<h2>Agregar un nuevo producto</h2>
		<form action="" method="post">
			<div class="form-group">
				<input type="text" name="id_categoria" placeholder="ID de la categoria" class="input__text">
				<input type="text" name="nombre" placeholder="Nombre" class="input__text">
			</div>
			<div class="form-group">
				<input type="text" name="descripcion" placeholder="Descripcion" class="input__text">
				<input type="text" name="precio_venta" placeholder="Precio de venta" class="input__text">
			</div>
			<div class="form-group">
				<input type="text" name="precio_compra" placeholder="Precio de compra" class="input__text">
				<input type="text" name="color" placeholder="Color" class="input__text">
			</div>
			<div class="btn__group">
				<a href="index.php" class="btn btn__danger">Cancelar</a>
				<input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
			</div>
		</form>
	</div>
</body>
</html>