<?php 
	//Se verifica que exista una sesión, en caso de que no sea así, se muestra el login
	if(!isset($_SESSION['validar'])){
		header("location:index.php?action=ingresar");
		exit();
	}
	//Se llama al controlador que muestra las tarjetas con la información que se obtiene del sistema [# de ventas, #de usuarios, # de productos, # de categorias, # de movimientos en el stock, total de ganancias]
	$tablero = new MvcController();
	$tablero->contarFilas();
?> 