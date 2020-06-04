<?php
    /*-- Clase para crear los controladores que utilizará el usuario mientreas navega en el sitio web--*/
    class MvcController{
        /*-- Método/función que sirve para devolver la estructura base del sistema --*/
        public function plantilla(){
            include "views/template.php";
        }

        /*-- Método/función que sirve para mostrarle al usuario la pantalla correspondiente a la acción que ha seleccionado --*/
        public function enlacesPaginasController(){
            if (isset($_GET['action'])) {
                $enlacesController = $_GET['action'];
            }else {
                $enlacesController = 'index';
            }
            $respuesta = EnlacesPaginas::enlacesPaginasModel($enlacesController);
            include $respuesta;
        }










        //CONTROLADORES PARA LOS USUARIOS
        /*-- Este controller a partir de la función password_verify compara por hash la contraseña ingresada con la que está en la base de datos si es correcta guarda en el arreglo session los datos del usuario y manda al inventario o marcará mensaje de error --*/
        public function ingresoUserController(){
            if (isset($_POST["txtUser"]) && isset($_POST["txtPassword"])) {
                //Guarda en el array los valores de los tect de la vista (usuario y contraseña)
                $datosController = array ("user" => $_POST["txtUser"], "password" => $_POST["txtPassword"]);
                $respuesta = Datos::ingresoUserModel($datosController, "users");
                //Validar la respuesta del modelo para ver si es un usuario correcto
                if($respuesta["usuario"]== $_POST["txtUser"] && password_verify($_POST["passwordIngreso"], $respuesta['contrasena'])){
                    session_start();
                    $SESSION["validar"] = true;
                    $SESSION["nombre_usuario"] = $respuesta["nombre_usuario"];
                    $SESSION["id"] = $respuesta["id"];
                    header("location:index.php?action=tablero");
                }else{
                    header("location:index.php?action=fallo&res=fallo");
                }
            }
        }










    /*-- Controlador para cargar todos los datos de los usuarios, la contraseña no se puede cargar debido a que independientemente de si se muestra o no, está encriptada --*/
    public function vistaUsersController(){
        $respuesta = Datos::vistaUsersModel("users");
        //Utilizar un foreach para iterar un array e imprimir la consulta del modelo
        foreach($respuesta as $row => $item){
            echo'
                <tr>
                    <td>
                        <a href="index.php?action=usuarios&idUserEditar='.$item["id"].'" class="btn btn-warning btn-sm btn-icon" title="Editar" data-toogle="tooltrip"><i class="fa fa-edit></i></a>
                    </td>
                    <td>'.$item["firstname"].'</td>
                    <td>'.$item["lastname"].'</td>
                    <td>'.$item["user_name"].'</td>
                    <td>'.$item["user_email"].'</td>
                    <td>'.$item["date_added"].'</td>
                </tr>
            ';
        }
    }    








    public function registrarUserController(){
        ?>
        <div class="col-md-6 mt-3">
            <div class="card card-primary">
                <div class="card-header">
                    <h4><b>Registro</b> de Usuarios</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="index.php?action=usuarios">
                        <div class="form-group">
                            <label for="nusuariotxt">Nombre: </label>
                            <input class="form-control" type="text" name="nusuariotxt" id="nusuariotxt" placeholder="Ingrese el nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="ausuariotxt">Apellido: </label>
                            <input class="form-control" type="text" name="ausuariotxt" id="ausuariotxt" placeholder="Ingrese el apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="usuariotxt">Usuario: </label>
                            <input class="form-control" type="text" name="usuariotxt" id="usuariotxt" placeholder="Ingrese el usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="ucontratxt">Contraseña: </label>
                            <input class="form-control" type="password" name="ucontratxt" id="ucontratxt" placeholder="Ingrese la contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="uemailtxt">Correo electrónico: </label>
                            <input class="form-control" type="email" name="uemailtxt" id="uemailtxt" placeholder="Ingrese el correo electrónico" required>
                        </div>
                        <button class="btn btn-primary" type="submit">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }





        /*-- Este controlador sirve para insertar el usuario que se acaba de ingresar y notifica si se realizó dicha actividad o si hubo algún error, en el caso de la contraseña, primero que nada se tendrá que encriptar mediante el algoritmo hash y la función password_hash y se guarda para posteriormente realizar la inserción --*/
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
                    echo '
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
                    ';
                }else {
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    ¡Éxito!
                                </h5>
                                Usuario agregado con éxito.
                            </div>
                        </div>
                    ';
                }
            }
        }
        /*-- Este controlador se encarga de mostrar el formulario al usuario para editar sus datos. La contraseña como una cadena de caracteres y se deja en blanco, pero se verifica al momento de hacer una modifica que haya ingresado una contraseña, si no es el caso entonces no se podrá ejecutar la modificación y cada que se quiera hacer una modificación a un determinado usuario, se deberá ingresar también una nueva contraseña --*/
        public function editarUserController() {
            $datosController = $_GET["idUserEditar"];
            //envío de datos al modelo
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
        /*-- Este controlador sirve para actualizar el usuario que se acaba de ingresar y notificar si se realizó dicha actividad o si hubo algún error --*/
        public function actualizarUserController(){
            if(isset($_POST["nusuariotxtEditar"])){
                $_POST["contratxtEditar"]= password_hash($_POST["contratxtEditar"],PASSWORD_DEFAULT);

                $datosController = array("id"=>$_POST["idUserEditar"],"nusuario"=>$_POST["nusuariotxtEditar"],"ausuario"=>$_POST["ausuariotxtEditar"],"usuario"=>$_POST["usuariotxtEditar"],"contra"=>$_POST["contratxtEditar"],"email"=>$_POST["uemailtxtEditar"]);

                //Enviar datos al modelo
                $respuesta = Datos::actualizarUserModel($datosController,"users");
                if ($respuesta == "success") {
                    echo '
                    <div class="col-md-6 mt-3">
                        <div class="alert alert-success alert-dismissible">
                            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5>
                                <i class="icon fas fa-check"></i>
                                ¡Éxito!
                            </h5>
                            Usuario editado con exito.
                        </div>
                    </div>
                    ';
                } else {
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible">
                                <button class="close" type="button" data-dissmis="alert" aria-hidden="true">x</button>
                                <h5>
                                    <i class="icon fas fa-ban"></i>
                                    ¡Error!
                                </h5>
                                Se ha producido un error al momento de edita el usuario, trate de nuevo.
                            </div>
                        </div>
                    ';
                }
            }
        }


        public function eliminarUserController(){
            if(isset($_GET["idBorra"])){
                $datosController = $_GET["idBorrar"];
                $respuesta=Datos::eliminarUserModel($datosController,"usuarios");
                if($respuesta == "success"){
                    header("location:index.php?action=usuarios");
                }
            }
        }
        //CONTROLES PARA EL TABLERO
        /*-- Este controlador sirve para mostrarle al usuario las cajas donde tiene informacion sobre los usuarios, productos y ventas registradas, así como los movimientos que se tienen en el historial (altas/bajas de productos) y las ganancias que se tienen de acuerdo a todas las ventas--*/
        public function contarFilas(){
            $respuesta_users = Datos::contarFilasModel("users");
            /*--
            $respuesta_products = Datos::contarFilasModel("products");
            $respuesta_categories = Datos::contarFilasModel("categories");
            $respuesta_historial = Datos::contarFilasModel("historial");
            $respuesta_ventas = Datos::contarFilasModel("sales");
            $respuesta_totales = Datos::contarFilasModel("sales");
            --*/
            echo '
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>'.$respuesta_users["filas"].'</h3>
                            <p>Total de Usuarios</p>
                        </div>
                        <div class="icon">
                            <i class="far fa-address-card"></i>
                        </div>
                        <a class="small-box-footer" href="index.php?action=usuarios">Más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            ';
        }
    

        /*-- Controlador para cargar todos los datos de los usuarios, la contraseña no se puede cargar debido a que independientemente de si se muestra o no, está encriptada --*/
        public function vistaProductsController(){
            $respuesta = Datos::vistaUsersModel("products");
            //Utilizar un foreach para iterar un array e imprimir la consulta del modelo
            foreach($respuesta as $row => $item){
                echo'
                    <tr>
                        <td>
                            <a href="index.php?action=usuarios&idUserEditar='.$item["id"].'" class="btn btn-warning btn-sm btn-icon" title="Editar" data-toogle="tooltrip"><i class="fa fa-edit></i></a>
                        </td>
                        <td>'.$item["id"].'</td>
                        <td>'.$item["codigo"].'</td>
                        <td>'.$item["producto"].'</td>
                        <td>'.$item["fecha"].'</td>
                        <td>'.$item["precio"].'</td>
                        <td>'.$item["stock"].'</td>
                        <td>'.$item["categoria"].'</td>
                        <td><a href="index.php?action=inventario&idProductAdd='.$item["id"].'" class="btn btn-warning btn-sm btn-icon" title="Agregar" data-toogle="tooltrip"><i class="fa fa-edit></i></a>
                        <td><a href="index.php?action=inventario&idProductDell='.$item["id"].'" class="btn btn-warning btn-sm btn-icon" title="Quitar de Stock" data-toogle="tooltrip"><i class="fa fa-edit></i></a>
                    </tr>
                ';
            }
        }
        //Esta funcion permite llamar 
        public function registrarProductController(){
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4><b>Registro</b> de Productos</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=inventario">
                            <div class="form-group">
                                <label for="codigotxt">Código: </label>
                                <input class="form-control" type="text" name="codigotxt" id="codigotxt" placeholder="Código del producto">
                            </div>
                            <div class="form-group">
                                <label for="nombretxt">Nombre: </label>
                                <input class="form-control" type="text" name="nombretxt" id="nombretxt" placeholder="Nombre del producto">
                            </div>
                            <div class="form-group">
                                <label for="Preciotxt">Precio: </label>
                                <input class="form-control" type="number" name="preciotxt" id="preciotxt" placeholder="Precio del producto">
                            </div>
                            <div class="form-group">
                                <label for="stocktxt">Stock: </label>
                                <input class="form-control" type="number" name="stocktxt" id="stocktxt" min="1" placeholder="Cantidad de stock del producto">
                            </div>
                            <div class="form-group">
                                <label for="referenciatxt">Motivo: </label>
                                <input class="form-control" type="text" name="referenciatxt" id="referenciatxt" placeholder="Referencia del producto" required>
                            </div>
                            <div class="form-group">
                                <label for="categoriatxt">Categoría: </label>
                                <select name="categoria" id="categoria" class="form-control">
                                    <?php
                                        $respuesta_categoria = Datos::obtenerCategoryModel("categories");
                                        foreach($respuesta_categoria as $row => $item){
                                    ?>
                                            <option value="<?php echo $item["id"]; ?>"><?php echo $item["categoria"];?></option>"
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <button class="btn btn-primary" type="submit">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php //Se abre el php
        }
        
        /*-- Esta funcion permite insertar productos llamando al modelo  que se encuentra en  elarchivo crud de modelos confirma con un isset que la caja de texto del codigo este llena y procede a llenar en una variable llamada datos controller este arreglo se manda como parametro aligual que elnombre de la tabla,una vez se obtiene una respuesta de la funcion del modelo de inserccion tenemos que checar
        si la respuesta fue afirmativa hubo un error y mostrara los respectivas alerta,para insertar datos en la tabla de historial se tiene que mandar a un modelollamado ultimoproductmodel este traera el ultimo dato insertado que es el id del producto que se manda en elarray de datoscontroller2 junto al nombre de la tabla asi insertando los datos en la tabla historial 
        public function insertarProductController(){
            if(isset($_POST["codigotxt"])){
                //$datosController = array["codigo"=>$_POST["codigotxt"],"precio"=>$_POST["preciotxt"],"stock"=>$_POST["stocktxt"],"categoria"=>$_POST["categoriatxt"],"codigo"=>$_POST["codigotxt"]];
                if ($respuesta == "success") {
                    $respuesta3 = Datos::ultimoProductModel("products");
                    $datosController2 = array("user"=>$_SESSION["id"],"cantidad"=>$_POST["stocktxt"],"product");
                    echo '<div class="col-md-6 mt-3">
                            <div class
                }
            }
        }--*/


        //Esta funcion permite editar los datos de la tabla productos del producto seleccionado del boton editar
        public function editarProductController(){
            $datosController = $_GET["idProductEditar"];
            $respuesta = Datos::editarProductModel($datosController."products");
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4><b>Editor</b> de Productos</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=inventario">
                            <div class="form-group">
                                <input type="hidden" name="idProductEditar" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="categoriaeditar">Categoria:</label>
                                <select name="categoriaeditar" id="categoriaeditar" class="referenciatxteditar">
                                    <?php
                                        $respuesta_categotia = Datos::obtenerCategoryModel("categories");
                                        foreach($respuesta_categoria as $row => $item){
                                            //Me falta terminar la parte de html
                                    ?>
                                        <option value="php">
                                            
                                        }
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        //Esta funcion permite actualizar los datos en la tabla
        public function actualizarProductController(){
            if (isset($_POST["codigotxteditar"])) {
                $datosController = array("id"=>$_POST["idProductEditar"],"codigo"=>$_POST["codigotxteditar"],"precio"=>$_POST["preciotxteditar"],"stock"=>$_POST["stocktxteditar"],"categoria"=>$_POST["categoriaeditar"],"nombre"=>$_POST["nombretxteditar"]);
                $respuesta = Datos::actualizarProductModel($datosController,"products");
                if($respuesta == "success"){
                    // Queda pendiente este array $datosController2 
                    echo '
                    <div class="col-md-6 mt-3">
                        <div class="">
                    ';
                    //Pendiente los echos
                }else {
                    echo '
                    ';
                }
            }
        }

        //Esta funcion permite agregar productos al stock atravez del boton y un formulario para agregar dicha cantidad al producto se llama al modelo correspondiente
        public function addProductController(){
            $datosController = $_GET["idProductAdd"];
            $respuesta = Datos::editarProductModel($datosController,"products");
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4><b>Agregar</b> stock al producto</h4>
                    </div>
                    <div class="card-body">
                        <form class="form-group" action="index.php?action=inventario">
                            <div class="form-group">
                                <input type="hidden" name="idProductAdd" class="form-control" value="<?php echo $respuesta["id"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="codigotxteditar">Stock: </label>
                                <input class="form-control" name="addstocktxt" id="addstocktxt" type="number" min="1" value="1" required placeholder="Stock de producto">
                            </div>
                            <div class="form-group">
                                <label for="referenciatxtadd">Motivo: </label>
                                <input class="form-control" name="referenciatxtadd" id="referenciatxtadd" type="text" required placeholder="Referencia del producto">
                            </div>
                            <button class="btn btn-primary" type="submit">Realizar cambio</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        //Esta funcion actualiza y llama al model de la tabla producto a su vez insertqa una fila
        public function actualizar1StockController(){
            if (isset($_POST["addstocktxt"])) {
                $datosController = array("id"=>$_POST["idProductAdd"],"stock"=>$_POST["addstocktxt"]);
                $respuesta = Datos::pushProductsModel($datosController,"products");
                if ($respuesta == "success") {
                    //Falta terminar el array y los echos ---------------------------------------------------------------------------
                    $datosController2 = array("user"=>$_SESSION["id"],"cantidad"=>$_POST["addstocktxt"],"product");
                    echo '
                    <div class="col-md-6 mt-3">
                        <div class="alert alert-success alert-dismisabla>
                    '
                }
            }
        }
        
    }
?>
