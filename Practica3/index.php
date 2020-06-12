<?php 
	//El index. En el mostraremos las salidas de las vistas al usuario y también a través de él, enviaremos las ediciones con las distintas acciones que e usuario envie al controlador. 
	ob_start();
	require_once "models/enlaces.php"; //Manda a llamar al archivo que está dentro de la carpeta del controlador el cual son los enlaces que nos permitirá las navegaciones
	require_once "models/crud.php"; //Manda a llamar al archivo que está dentro de la carpeta del controlador
	//require_once "models/crudProd.php";
	require_once "controllers/controller.php"; //Manda a llamar al archivo que está dentro de la carpeta del controlador

	//Para poder ver el templeate, se hace la perición mediante el controlador.
	//Primeramente creamos un objeto para poder visualizarlo
	$mvc = new MvcController(); //Crea una instancia de la clase MvcController.
	//Mostrar la función o método "página" disponible en controllers /controller.php
	$mvc -> plantilla(); //Manda a llamar a la función de la clase ControladorPrincipal, esta devuelve la vista principal
?>