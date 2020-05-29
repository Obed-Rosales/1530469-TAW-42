<?php
    // Se verifica que exista una sesion, en caso de que no sea asi, se muestra el logon
    if (!isset($_SESSION['validar'])) {
        header("location:index.php?action=ingresar");
        exit();
    }
    //Llama a los controladores para insertar/modificar/eliminar usuarios
    $usuarios = new MvcController();
    $usuarios->insertarUserController();
    $usuarios->actualizarUserController();
    $usuarios->eliminarUserController();
    //Se verifica que el usuario haya pulsado sobre el boton de registrar o editar para mostrarle su respectivo formulario
    if (isset($_GET['registrar'])) {
        $usuarios->registrarUserController();
    } else if (isset($_GET['idUserEditar'])) {
        $usuarios->editarUserController();
    }
?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Usuarios</h3>
            </div>
            <div class="card-body">
                <div class="row md-4">
                    <div class="col-sm-6">
                        <a href="index.php?action=usuarios&registrar" class="btn btn-info">Agregar nuevo usuario</a>
                    </div>
                </div>
                <div id="example2wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-hover">
                                <thead class="table-info">
                                    <tr>
                                        <th>Editar?</th>
                                        <th>Eliminar?</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Usuario</th>
                                        <th>Correo electronico</th>
                                        <th>Fecha de insercion</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
