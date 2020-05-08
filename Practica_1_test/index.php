<?php
	include_once 'conexion.php';


	//Para cargar los productos
	$sentencia_select1=$con->prepare('SELECT *FROM producto ORDER BY id DESC');
	$sentencia_select1->execute();
	$resultado1=$sentencia_select1->fetchAll();

	// metodo buscar
	if(isset($_POST['btn_buscar1'])){
		$buscar_text1=$_POST['buscar1'];
		$select_buscar1=$con->prepare('
			SELECT *FROM productos WHERE nombre LIKE :campo OR descripcion LIKE :campo;'
		);

		$select_buscar1->execute(array(
			':campo' =>"%".$buscar_text1."%"
		));

		$resultado1=$select_buscar1->fetchAll();

	}


	//Para cargar los fabricantes
	$sentencia_select2=$con->prepare('SELECT *FROM fabricante ORDER BY id DESC');
	$sentencia_select2->execute();
	$resultado2=$sentencia_select2->fetchAll();

	// metodo buscar
	if(isset($_POST['btn_buscar2'])){
		$buscar_text2=$_POST['buscar2'];
		$select_buscar2=$con->prepare('
			SELECT *FROM fabricante WHERE id LIKE :campo OR nombre LIKE :campo;'
		);

		$select_buscar2->execute(array(
			':campo' =>"%".$buscar_text2."%"
		));

		$resultado2=$select_buscar2->fetchAll();

	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Inicio</title>
	<link rel="stylesheet" href="css/estilo.css">
</head>
<body>
	<div class="contenedor">
		<h2>CRUD de productos</h2>
		<div class="barra__buscador">
			<h1>Productos</h1>
			<form action="" class="formulario" method="post">
				<input type="text" name="buscar1" placeholder="buscar por nombre o descripcion" 
				value="<?php if(isset($buscar_text1)) echo $buscar_text1; ?>" class="input__text">
				<input type="submit" class="btn" name="btn_buscar1" value="Buscar">
				<a href="insertar.php" class="btn btn__nuevo">Nuevo</a>
			</form>
		</div>
		<table>
			
			<tr class="head">
				<td>Id</td>
				<td>Categoría</td>
				<td>Nombre</td>
				<td>Descripción</td>
				<td>Precio de venta</td>
				<td>Precio de compra</td>
				<td colspan="2">Acción</td>
			</tr>
			<?php foreach($resultado1 as $fila):?>
				<tr >
					<td><?php echo $fila['id']; ?></td>
					<td><?php echo $fila['id_categoria']; ?></td>
					<td><?php echo $fila['nombre']; ?></td>
					<td><?php echo $fila['descripcion']; ?></td>
					<td><?php echo $fila['precio_venta']; ?></td>
					<td><?php echo $fila['precio_compra']; ?></td>
					<td><a href="actualizar.php?id=<?php echo $fila['id']; ?>"  class="btn__update" >Editar</a></td>
					<td><a href="eliminar.php?id=<?php echo $fila['id']; ?>" class="btn__delete">Eliminar</a></td>
				</tr>
			<?php endforeach ?>

		</table>


		<div class="barra__buscador">
			<h1>Fabricantes</h1>
			<form action="" class="formulario" method="post">
				<input type="text" name="buscar2" placeholder="buscar por id o nombre" 
				value="<?php if(isset($buscar_text2)) echo $buscar_text2; ?>" class="input__text">
				<input type="submit" class="btn" name="btn_buscar2" value="Buscar">
				<a href="insert.php" class="btn btn__nuevo">Nuevo</a>
			</form>
		</div>

		<table>
			<tr class="head">
				<td>Id</td>
				<td>Nombre</td>
				<td>Dirección</td>
				<td>Correo</td>
				<td>Teléfono</td>
				<td colspan="2">Acción</td>
			</tr>
			<?php foreach($resultado2 as $fila):?>
				<tr >
					<td><?php echo $fila['id']; ?></td>
					<td><?php echo $fila['nombre']; ?></td>
					<td><?php echo $fila['direccion']; ?></td>
					<td><?php echo $fila['correo']; ?></td>
					<td><?php echo $fila['telefono']; ?></td>
					<td><a href="actualizar.php?id=<?php echo $fila['id']; ?>"  class="btn__update" >Editar</a></td>
					<td><a href="eliminar.php?id=<?php echo $fila['id']; ?>" class="btn__delete">Eliminar</a></td>
				</tr>
			<?php endforeach ?>

		</table>
	</div>
</body>
</html>