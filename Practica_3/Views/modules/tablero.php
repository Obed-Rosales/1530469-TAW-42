<?php
    //Se verifica que exista una sesion, en caso de que no sea asi, se muestra el login
    if (!isset($_SESSION['validar'])) {
        header('location:index.php?actio=ingresar');
        exit();
    }
    //Se llama al controlador que muestra las tarjetas con la información que se obtiene del sistema (# de ventas, #de usuarios, # de productos, # de categorías, # de movimientos en el stock, total de ganancias)
    $tablero = new MvcController();
    $tablero->contarFilas();
?>