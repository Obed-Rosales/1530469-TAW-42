<?php
    //Se verifica que exista una sesion, en caso de que no sea asi, se muestra el login
    if (!isset($_SESSION['validar'])) {
        header('location:index.php?actio=ingresar');
        exit();
    }
    //Se llama al controlador
    $tablero = new MvcController();
    $tablero->contarFilas();
?>