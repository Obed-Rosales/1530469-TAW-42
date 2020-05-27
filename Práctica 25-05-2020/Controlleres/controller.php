<?php
    class MvcController{

        public function ingresoUsuarioController(){
            if (isset($_POST["txtUser"]) && isset($_POST["txtPassword"])) {
                $datosController=array ("user" => $_POST["txtUser"], "password" => $_POST["txtPassword"]);
                $respuesta = Datos::ingresoUsuarioModel($datosController, "users");
    
                //Validar la respuesta del modelo para ver si es un usuario correcto
                if($respuesta["usuario"]== $_POST["txtUser"] && password_verify($_POST["passwordIngreso"], $respuesta['contrasena'])){
                    session_start();
                    $SESSION["validar"] = true;
                    header("location:index.php?action=usuarios");
                }else{
                    header("location:index.php?action=fallo");
                }
            }
        }




        //VISTA DE USUARIOS
    public function vistaUsuariosController(){
        $respuesta = Datos::vistaUsuarioModel("users");
        //Utilizar un foreach para iterar un array e imprimir la consulta del modelo
        foreach($respuesta as $row => $item){
            echo'
                <tr>
                <td><a href="index.php?action=usuarios&idUserEditar='.$item["id"].'" class="btn btn-warning btn-sm btn-icon" title="editar" data-toogle="tooltrip"><button>Editar</button></a></td>
                    <td>'.$item["usuario"].'</td>
                    <td>'.$item["password"].'</td>
                    <td>'.$item["email"].'</td>
                    
                    <td><a href="index.php?action=usuarios&idBorrar='.$item["id"].'"><button>Borrar</button></a></td>
                </tr>';
        }
    }


    public function registrarUserController(){
        ?>
        <div class="col-md-6 mt-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h4><b>Registro</b> de Usuarios</h4>
                </div>
            </div>
        </div>




        <div class="form-group">
                                <label for="ucontratxt">Contraseña: </label>
                                <input class="form-control" type="password" name="ucontratxt" id="ucontratxt" placeholder="Ingrese la contraseña" required>
                            </div>
                            <div class="form-group">
                                <label for="uemailtxt">Correo Electrónico: </label>
                                <input class="form-control" type="email" name="uemailtxt" id="uemailtxt" placeholder="Ingrese el correo electrónico" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }


        public function insertarUserController(){
            if(isset($_POST["nusuariotxt"])){
                //Encripta la contrasena
                $_POST["ucontratxt"]=password_hash($_POST["ucontratxt"],PASSWORD_DEFAULT);
                
                //Almacena en un array los valores de los text del metodo "registroUserControler"
                $datosController = array("nusuario"=>$_POST["nusuatiotxt"],"ausuario"=>$_POST["ausuariotxt"],"usuario"=>$_POST["usuariotxt"],"contra"=>$_POST["ucontratxt"],"email"=>$_POST["uemailtxt"]);

                //Se envias los datos al modelo
                $respuesta = Datos::insertarUserModel($datosController,"users");

                //Respuesta del modelo
                if($respuesta == "succes"){

                }
            }
        }

        public function editarUserController(){
            $datosController = $_GET["idUserEditar"];
            //Envio de datos al modelo
            $respuesta = Datos::editarUserModel($datosController,"users");
            ?>
            <div class="form-group">
                                <label for="ucontratxt">Contraseña: </label>
                                <input class="form-control" type="password" name="ucontratxt" id="ucontratxt" placeholder="Ingrese la contraseña" required>
                            </div>
                            <div class="form-group">
                                <label for="uemailtxt">Correo Electrónico: </label>
                                <input class="form-control" type="email" name="uemailtxt" id="uemailtxt" placeholder="Ingrese el correo electrónico" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }

                        </div>


 <div class="col-md-6 mt-3">
                            <div class="alert alert-success alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    ¡Éxito!
                                </h5>
                                Usuario agregado con éxito.
                            </div>
                        </div>

public function editarUserController() {
            $datosController = $_GET["idUserEditar"];
            //envío de datos al mododelo
            $respuesta = Datos::editarUserModel($datosController,"users");
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4><b>Editor</b> de Usuarios</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=usuarios">
                            <div class="form-group">
                                <input type="hidden" name="idUserEditar" class="form-control" value="<?php echo $respuesta["id"]; ?>" required>
                            </div>

 <div class="form-group">
                                <label for="nusuariotxtEditar">Nombre: </label>
                                <input class="form-control" type="text" name="nusuariotxtEditar" id="nusuariotxtEditar" placeholder="Ingrese el nuevo nombre" value="<?php echo $respuesta["nusuario"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="ausuariotxtEditar">Apellido: </label>
                                <input class="form-control" type="text" name="ausuariotxtEditar" id="ausuariotxtEditar" placeholder="Ingrese el nuevo apellido" value="<?php echo $respuesta["ausuario"]; ?>" required>
                            </div>

 <div class="form-group">
                                <label for="usuariotxtEditar">Usuario: </label>
                                <input class="form-control" type="text" name="usuariotxtEditar" id="usuariotxtEditar" placeholder="Ingrese el nuevo usuario" value="<?php echo $respuesta["usuario"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="contratxtEditar">Contraseña: </label>
                                <input class="form-control" type="password" name="contratxtEditar" id="contratxtEditar" placeholder="Ingrese la nueva contraseña" required>
                            </div>

<div class="form-group">
                                <label for="uemailtxtEditar">Correo Electrónico: </label>
                                <input class="form-control" type="email" name="uemailtxtEditar" id="uemailtxtEditar" placeholder="Ingrese el nuevo correo electrónico" value="<?php echo $respuesta["email"]; ?>" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Editar</button>
                        </form>
                    </div>

</div>
            </div>
            <?php
        }
        }




    }

    



    }
?>