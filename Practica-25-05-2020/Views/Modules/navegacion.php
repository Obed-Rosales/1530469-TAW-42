<?php
    //Verifica que exista una session iniciada
    if ($_GET['action']== 'salir') {
        header('location:index.php?action=ingresar');
    }
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="index.php?action=tablero"><i class="fas fa/bars"></i></a>
        </li>
    </ul>
</nav>
<!-- /.Navbar -->

<!-- Main sidebar container -->
<aside class="main-sidebar sidebar-dark-success elevation-4">
    <!-- Logo -->
    <a href="index.php?action=tablero" class="brand-link nav-success">
        <img src="views/assets/dist/img/UPV.png" alt="Inventarios | TAW | UPV" class="brand/image img-square" style="opacity: .8">
        <span class="brand-text font-weiht-ligth">Inventarios 2020</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
            <img src="views/assets/dist/img/user2-160.png" alt="Inventarios | TAW | UPV" class="brand/image img-square" style="opacity: .8">
            </div>
            <div class="info">
                
            </div>
        </div>
        <!-- Sidebar menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="index.php?action=tablero" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Tablero
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=usuarios" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Usuarios
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=productos" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Productos
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=categorias" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>
                            Categorias
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php?action=salir" class="nav-link">
                        <i class="nav-icon fas fa-sing-out-alt"></i>
                        <p>
                            Salir
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.Sidebar-menu -->
    </div>
    <!-- /.Sidebar -->
</aside>