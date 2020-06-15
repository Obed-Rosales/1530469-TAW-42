<?php  
    //Verifica que exista una sesión iniciada
    if($_GET['action'] == 'salir'){
        header('location:index.php?action=ingresar');
    }
?>

<!--Navbar-->
<nav class="main-header navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="index.php?action=tablero"> <i class="fas fa-bars"></i></a>
        </li>
    </ul>
</nav>

<!--/.navbar-->
<!--Main sidebar container-->
<aside class="main-sidebar sidebar-dark-success elevation-4">
    <!--brand logo-->
    <a href="index.php?action=tablero" class="vews/assets/dist/img/UPV.png rand-link nav-success">
        <img src="views/assets/dist/img/UPV.jpg" alt="Practica 3|TAW|UPV" class="img-circle elevation-2" stype="opacity: .8">
        <!--<span class="brand-text font-weight-light">Inventarios</span>-->
    </a>

    <!--Slidebar-->
    <div class="sidebar">
        <!--Sidebar user panel (optional)-->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="views/assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="index.php?action=tablero" class="d-block">
                    <?php 
                        //Muestra el nombre del usuario actual
                        if (isset($_SESSION['nombre_usuario'])){
                            echo $_SESSION['nombre_usuario'];
                        }
                    ?>
                </a>
            </div>
        </div>

        <!--Sidebar menu-->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.php?action=tablero" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Tablero</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=usuarios" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=inventario" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Productos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=categoria" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Categorias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=ventas" class="nav-link">
                        <i class="nav-icon fas fa-cash-register"></i>
                        <p>
                            Ventas
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=salir" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Salir</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>