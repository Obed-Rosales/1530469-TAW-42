<?php
    // se activa el almacenamiento del bufer para poder acceder a los valores guardados en los arreglos asociativos $_GET y $_SESSION sin ningun problema
    ob_start();
    //Llamada al archivo que contiene los controladores y modelos que se necesitan para que el sistema funcione correctamente
    require_once "Models/enlaces.php";
    require_once "Models/crud.php";
    require_once "Controllers/controller.php";
    $mvc = new MvcController();
    //Llamada a la plantilla del sistema
    $mvc->plantilla();
?>