<?php
	include_once 'conexion.php';

	if(isset($_GET['id'])){
		$id=(int) $_GET['id'];

		$buscar_id=$con->prepare('SELECT * FROM producto WHERE id=:id LIMIT 1');
		$buscar_id->execute(array(
			':id'=>$id
		));
		$resultado=$buscar_id->fetch();
	}else{
		header('Location: index.php');
	}


	if(isset($_POST['guardar'])){
		$id_categoria=$_POST['id_categoria'];
		$nombre=$_POST['nombre'];
		$descripcion=$_POST['descripcion'];
		$precio_venta=$_POST['precio_venta'];
		$precio_compra=$_POST['precio_compra'];
		$id=(int) $_GET['id'];

		if(!empty($nombre) && !empty($id_categoria) && !empty($descripcion) && !empty($precio_venta) && !empty($precio_compra) ){
			if(!filter_var($correo,FILTER_VALIDATE_EMAIL)){
				//echo "<script> alert('Correo no valido');</script>";
			}else{
				$consulta_update=$con->prepare(' UPDATE producto SET  
					nombre=:nombre,
					id_categoria=:id_categoria,
					descripcion=:descripcion,
					precio_venta=:precio_venta,
					precio_compra=:precio_compra
					WHERE id=:id;'
				);
				$consulta_update->execute(array(
					':nombre' =>$nombre,
					':id_categoria' =>$id_categoria,
					':descripcion' =>$descripcion,
					':precio_venta' =>$precio_venta,
					':precio_compra' =>$precio_compra,
					':id' =>$id
				));
				header('Location: index.php');
			}
		}else{
			echo "<script> alert('Alguno de los campos están vacios');</script>";
		}
	}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Editar producto</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<div class="contenedor">
		<h2>Actualización de datos</h2>
		<form action="" method="post">
			<div class="form-group">
				<input type="text" name="nombre" value="<?php if($resultado1) echo $resultado1['nombre']; ?>" class="input__text">
				<input type="text" name="descripcion" value="<?php if($resultado1) echo $resultado['descripcion']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<input type="text" name="telefono" value="<?php if($resultado) echo $resultado['telefono']; ?>" class="input__text">
				<input type="text" name="ciudad" value="<?php if($resultado) echo $resultado['ciudad']; ?>" class="input__text">
			</div>
			<div class="form-group">
				<input type="text" name="correo" value="<?php if($resultado) echo $resultado['correo']; ?>" class="input__text">
			</div>
			<div class="btn__group">
				<a href="index.php" class="btn btn__danger">Cancelar</a>
				<input type="submit" name="guardar" value="Guardar" class="btn btn__primary">
			</div>
		</form>
	</div>
</body>
</html>