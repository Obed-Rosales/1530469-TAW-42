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
        si la respuesta fue afirmativa hubo un error y mostrara los respectivas alerta,para insertar datos en la tabla de historial se tiene que mandar a un modelollamado ultimoproductmodel este traera el ultimo dato insertado que es el id del producto que se manda en elarray de datoscontroller2 junto al nombre de la tabla asi insertando los datos en la tabla historial --*/
        public function insertarProductController(){
            if(isset($_POST["codigotxt"])){
                $datosController = array("codigo"=>$_POST["codigotxt"],"precio"=>$_POST["preciotxt"],"stock"=>$_POST["stocktxt"],"categoria"=>$_POST["categoriatxt"],"nombre"=>$_POST["nombretxt"]);
                $respuesta = Datos::insertarProductModel($datosController,"products");
                if ($respuesta == "success") {
                    $respuesta3 = Datos::ultimoProductsModel("products");
                    $datosController2 = array("user"=>$_SESSION["id"],"cantidad"=>$_POST["stocktxt"],"producto"=>$respuesta3["id"],"note"=>$_SESSION["nombre_usuario"]."agrego/compro","reference"=>$_POST["referenciatxt"]);
                    $respuesta2 = Datos::insertarHistorialModel($datosController2, "historial");
                    echo '
                        <div class="col-md-6 mt-3">
        					<div clas="alert alert-success alert-dismissible"
        						<button class="close" type="button" data-dismiss"alert" aria-hidden"true">xZ/button>
        							<h5>
        								<i class="icon fas fa-check"></i>
        								¡Exito!
        							</h5>
        							Producto agregado con exito-
        					</div>
        				</div>';
        		}else{
                    echo '
                        <div class="col-md-6 mt-3">
                            <div clas="alert alert-success alert-dismissible"
                                <button class="close" type="button" data-dismiss"alert" aria-hidden"true">x</button>
                                    <h5>
                                        <i class="icon fas fa-ban"></i>
                                        ¡Error!
                                    </h5>
                                    Se ha producido un error al momento de agregar el producto, trate de nuevo-
                            </div>
                        </div>
                    ';
                }
            }
        }


        //Esta funcion permite editar los datos de la tabla productos del producto seleccionado del boton editar
        public function editarProductController(){
            $datosController = $_GET["idProductEditar"];
            $respuesta = Datos::editarProductModel($datosController,"products");
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4><b>Editor</b> de Productos</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="index.php?action=inventario">
        					<div class="form-group">
        						<input type="hidden" name="idProductEditar" class="form-control" value="<?php echo $respuesta["id"]; ?>"  required>
        					</div>
        					<div class="form-group">
        						<label for="codigotxtEditar">Código: </label>
        						<input type="text" name="codigotxteditar" class="form-control" value="<?php echo $respuesta["codigo"]; ?>"  required placeholder="Código de producto">
        					</div>
        					<div class="form-group">
        						<label for="nombretxtEditar">Nombre: </label>
        						<input type="text" name="nombretxteditar" class="form-control" value="<?php echo $respuesta["nombre"]; ?>"  required placeholder="Nombre de producto">
        					</div>
        					<div class="form-group">
        						<label for="preciotxtEditar">Precio: </label>
        						<input type="number" name="preciotxteditar" class="form-control" value="<?php echo $respuesta["precio"]; ?>"  required placeholder="Precio de producto">
        					</div>
        					<div class="form-group">
        						<label for="stocktxtEditar">Stock: </label>
        						<input type="text" name="stocktxteditar" class="form-control" value="<?php echo $respuesta["stock"]; ?>"  required placeholder="Cantidad de stock del producto">
        					</div>
        					<div class="form-group">
        						<label for="codigotxtEditar">Motivo: </label>
        						<input type="text" name="referenciatxteditar" class="form-control" id="referenciatxteditar" required placeholder="Referencia del producto">
        					</div>
        					<div class="form-group">
        						<label for="categoriatxtEditar">Categoría: </label>
        						<select name="categoriadditar" id="categoriaeditar" class="form-control">
        							<?php
        								$respuesta_categoria = Datos::obtenerCategoryModel("categoria");
        								foreach ($respuesta_categoria as $row => $item) {
    								?>
    								<option value="<?php echo $item["categoria"]; ?>"></option>
        							<?php
        								 } 
        							?>
        						</select>
        					</div>
        					<button class="btn btn-primary" type="submit">Editar</button>
        				</form>
                    </div>
                </div>
            </div>
            <?php
        }
        //Esta función permite actualizar los datos en la tabla productos a partir del método form anterior mandandola atravéz del modelo del crud atravez del arreglo y con la variable respuesta mandamos dichos datos porque se llama al modelo actualizarProductoModel si en el modelo se realizó correctamente entonces mandará una alerta de correcto y pasará a llenar dichos datos en el modelo de insertar historial model en caso contrario no se hará nada y mostrará el mensaje de error.
        public function actualizarProductController(){
            if (isset($_POST["codigotxteditar"])) {
                $datosController = array("id"=>$_POST["idProductEditar"],"codigo"=>$_POST["codigotxteditar"],"precio"=>$_POST["preciotxteditar"],"stock"=>$_POST["stocktxteditar"],"categoria"=>$_POST["categoriaeditar"],"nombre"=>$_POST["nombretxteditar"]);
                $respuesta = Datos::actualizarProductModel($datosController,"products");
                if($respuesta == "success"){
        			$datosController2 = array("user"=>$_SESSION["id"], "cantidad"=>$_POST["stocktxteditar"], "producto"=>$_POST["idProductEditar"], "note"=>$_POST["nombre_usuario"], "agrego/compro", "reference"=>$_POST["referenciatxteditar"]);
        			$resuesta2 = Datos::insertarHistorialModel($datosController2, "historial");
                    echo '
                        <div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Exito!
        							</h5>
        							Producto actualizado con exito.
        					</div>
                        </div>
                    ';
        		}else{
                    echo '
                        <div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Error!
        							</h5>
        							Se ha producido un error al momento de actualizar el producto, trate de nuevo.
        					</div>
                        </div>
                    ';
        		}
            }
        }

        //Esta funcion permite eliminar datos apartir del id seleccionado en la tabla atravez del botón funcionando desde el modelo y realizará la acción en la tabla una vez se borre mostrará un mensaje de error o de correcto dependiendo el caso.
        public function eliminarProductController(){
        	if(isset($_GET["idBorrar"])){
        		$datosController = $_GET["idBorrar"];
        		$respuesta = Datos::eliminarProductsModel($datosController, "products");
        		if($respuesta == "success"){
                    echo '
                        <div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Exito!
        							</h5>
        							Producto eliminado con exito.
        					</div>
                        </div>
                    ';
        		}else{
                    echo '
                        <div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Error!
        							</h5>
        							Se ha producido un error al momento de eliminar el producto, trate de nuevo.
        					</div>
                        </div>
                    ';
        		}
        	}
        }
        //Esta funcion permite agregar productos al stock atravez del boton y un formulario para agregar dicha cantidad al producto se llama al modelo correspondiente para así pasar al controlador que actualizar dicho modelo.
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
        //Esta funcion actualiza y llama al model de la tabla producto a su vez inserta una nueva fila a la tabla historial, si el update sale correcto y agrega los productos del stock entonces insertara la actualizzciion en la tabla historial, si todo sale bien mostrara un mensaje de error o de correcto dependiendo la respuesta
        public function actualizar1StockController(){
            if (isset($_POST["addstocktxt"])) {
                $datosController = array("id"=>$_POST["idProductAdd"],"stock"=>$_POST["addstocktxt"]);
                $respuesta = Datos::pushProductsModel($datosController,"products");
                if ($respuesta == "success") {
                    $datosController2 = array("user"=>$_SESSION["id"],"cantidad"=>$_POST["addstocktxt"],"producto"=>$_POST["idProductAdd"],"note"=>$_SESSION["nombre_usuario"]."agrego/compro","reference"=>$_POST["referenciatxtadd"]);
                    $respuesta2 = Datos::insertarHistorialModel($datosController2,"historial");
                    echo '
                        <div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Exito!
        							</h5>
        							Stock actualizado con exito.
        					</div>
                        </div>
                    ';
        		}else{
                    echo '
                        <div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Error!
        							</h5>
        							Se ha producido un error al momento de actualizar el stock de producto, trate de nuevo.
        					</div>
                        </div>
                    ';
        		}
            }
        }
        //Esta funcion actualiza y llama al modelo de la tabla producto
        public function actualizar2StockController(){
            if (isset($_POST["delstocktxt"])) {
                $datosController = array("id"=>$_POST["idProductDel"],"stock"=>$_POST["delstocktxt"]);
                $respuesta = Datos::pullProductsModel($datosController,"products");
                if ($respuesta == "success") {
                    $datosController2 = array("user"=>$_SESSION["id"],"cantidad"=>$_POST["delstocktxt"],"product"=>$_POST["idProductDel"],"note"=>$_SESSION["nombre_usuario"]."quito","reference"=>$_POST["referenciatxtdel"]);
                    $respuesta2 = Datos::insertarHistorialModel($datosController2,"historial");
                echo '
                    <div class="col-md-6 mt-3">
                        <div class="alert alert-success alert-dismissible>
                            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5>
                                <i class="icon fas fa-check"></i>
                                ¡Éxito!
                            </h5>
                            Stock modificado con éxito.
                        </div>
                    </div>
                ';
                } else {
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible>
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    ¡Error!
                                </h5>
                                Error al modificar el stock
                            </div>
                        </div>
                    ';
                }
            }
        }
        //Esta funcion  permite quitar productos al stock atravez del boton y un formulario para agregar dicha cantidad al producto se llama al modelo correspondiente para asi pasar al controlador que actualiza dicho modelo
        public function delProductController(){
            $datosController = $_GET["idProductDel"];
            $respuesta = Datos::editarProductsModel($datosController,"products");
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-danger">
                    <div class="card-header">
                        <h4><b>Eliminar</b> stock al producto</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=inventario">
                            <div class="form-group">
                                <input type="hidden" name="idProductDel" class="form-control" value="<?php echo $respuesta["id"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="codigotxtEditar">Stock: </label>
                                <input class="form-control" name="delstocktxt" id="delstocktxt" type="number" min="1" max="<?php echo $respuesta["stock"]; ?>" value="<?php echo $respuesta["stock"]; ?>" required placeholder="Stock de producto">
                            </div>
                            <div class="form-group">
                                <label for="referenciatxtdel">Motivo: </label>
                                <input class="form-control" name="referenciatxtdel" id="referenciatxtdel" type="text" required placeholder="Referencia del producto">
                            </div>
                            <button class="btn btn-primary" type="submit">Realizar cambio</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }




        //CONTROLADORES PAR EL HISTORIAL//
        //Este controlador funciona para mostrar los datos de la tabla historial al usuario
        public function vistaHistorialController(){
            $respuesta = Datos::vistaHistorialModel("historial");
            foreach ($respuesta as $row => $item) {
                echo '
                    <tr>
                        <td>'.$item["usuario"].'</td>
                        <td>'.$item["producto"].'</td>
                        <td>'.$item["nota"].'</td>
                        <td>'.$item["cantidad"].'</td>
                        <td>'.$item["referencia"].'</td>
                        <td>'.$item["fecha"].'</td>
                    </tr>
                ';
            }
        }



        //CONTROLADORES PARA CATEGORÍAS//
        // Este controlador permite mostrar cada uno de los requisitos que se tienen almacenados en la base de datos mediante el uso de un modelo que realiza la consulta y en esta función solo se recopila la informacion obtenida de ahí y mostrada de manera correcta mediante el uso de un ciclo foreach
        public function vistaCategoriasController(){
            $respuesta = Datos::vistaCategoriesModel("categories");
            foreach ($respuesta as $row => $item) {
                echo '
                    <tr>
                        <td>
                            <a href="index.php?action=categorias&CategoryEditar='.$item["idc"].'" class="btn btn-warning btn-sm btn-icon" title="Editar" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
                        </td>
                        <td>
                            <a href="index.php?action=categorias&idBorrar='.$item["idc"].'" class="btn btn-danger btn-sm btn-icon" title="Eliminar" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>'.$item["idc"].'</td>
                        <td>'.$item["ncategoria"].'</td>
                        <td>'.$item["dcategoria"].'</td>
                        <td>'.$item["fcategoria"].'</td>
                    </tr>
                ';
            }
        }
        //Este controlador permite mostrar un formulario para que el usuario pueda agregar una categoria a la base de datos
        public function registrarCategoryController(){
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4><b>Registro</b> de categorias</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=categorias">
                            <div class="form-group">
                                <label for="ncategoriatxt">Nombre de la categoria: </label>
                                <input class="form-control" type="text" name="ncategoriatxt" id="ncategoriatxt" placeholder="Ingrese el nombre de la categoria">
                            </div>
                            <div class="form-group">
                                <label for="dcategoriatxt">Descripcion de la categoria: </label>
                                <input class="form-control" type="text" name="dcategoriatxt" id="dcategoriatxt" placeholder="Ingrese la descripcion de la categoria">
                            </div>
                            <button class="btn btn-primary" type="submit">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        //Este controlador sirve para insertar la categoria que acaba de ingresar el usuario y notificar si se realizó dicha actividad o si hubo algun error
        public function insertarCategoryController(){
            if(isset($_POST["ncategoriatxt"]) && isset($_POST["dcategoriatxt"])){
                $datosController = array("nombre_categoria"=>$_POST["ncategoriatxt"],"descripcion_categoria"=>$_POST["dcategoriatxt"]);
                $respuesta = Datos::insertarCategoryModel($datosController,"categories");
                if ($respuesta == "success") {
                    $datosController2 = array("user"=>$_SESSION["id"],"cantidad"=>$_POST["delstocktxt"],"product"=>$_POST["idProductDel"],"note"=>$_SESSION["nombre_usuario"]."quito","reference"=>$_POST["referenciatxtdel"]);
                    $respuesta2 = Datos::insertarHistorialModel($datosController2,"historial");
                echo '
                    <div class="col-md-6 mt-3">
                        <div class="alert alert-success alert-dismissible>
                            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5>
                                <i class="icon fas fa-check"></i>
                                ¡Éxito!
                            </h5>
                            Stock modificado con éxito.
                        </div>
                    </div>
                ';
                } else {
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible>
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    ¡Error!
                                </h5>
                                Error al modificar el stock
                            </div>
                        </div>
                    ';
                }
            }

        }

        //Aun no se ha visto
        public function actualizarCategoryController(){
            if (isset($_POST["ncategoriatxteditar"]) && isset($_POST["dcategoriatxteditar"])) {
                $datosController = array("id"=>$_POST["idCategoryEditar"],"nombre_categoria"=>$_POST["ncategoriatxteditar"],"descripcion_categoria"=>$_POST["dcategoriatxteditar"]);
// Pendiente de revisar/////////////////////////////////////////////////////////
                $respuesta = Datos::actualizarCategoryModel($datosController,"categories");
                if ($respuesta == "success") {
                    $datosController2 = array("user"=>$_SESSION["id"],"cantidad"=>$_POST["delstocktxt"],"product"=>$_POST["idProductDel"],"note"=>$_SESSION["nombre_usuario"]."quito","reference"=>$_POST["referenciatxtdel"]);
                    $respuesta2 = Datos::insertarHistorialModel($datosController2,"historial");
                echo '
                    <div class="col-md-6 mt-3">
                        <div class="alert alert-success alert-dismissible>
                            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5>
                                <i class="icon fas fa-check"></i>
                                ¡Éxito!
                            </h5>
                            Stock modificado con éxito.
                        </div>
                    </div>
                ';
                } else {
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible>
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    ¡Error!
                                </h5>
                                Error al modificar el stock
                            </div>
                        </div>
                    ';
                }
            }
        }

        //Aun no se ha visto
        public function editarCategoryController(){
            $datosController = $_GET["idCategoryEditar"];
            $respuesta = Datos::editarCategoryModel($datosController,"categories");
            ?>
            <div class="col-md-6 mt-3">
                <div class="card card-warning">
                    <div class="card-header">
                        <h4><b>Editor</b> de categorías</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="index.php?action=categorias">
                            <div class="form-group">
                                <input type="hidden" name="idCategoryEditar" class="form-control" value="<?php echo $respuesta["id"]; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="ncategoriatxt">Nombre de la categoría: </label>
                                <input type="text" name="ncategoriatxteditar" id="ncategoriatxteditar" class="form-control" value="<?php echo $respuesta["nombre_categoria"]; ?>" placeholder="Ingrese el nombre de la categoría" required>
                            </div>
                            <div class="form-group">
                                <label for="dcategoriatxt">Descripción de la categoría: </label>
                                <input type="text" name="dcategoriatxteditar" id="dcategoriatxteditar" class="form-control" value="<?php echo $respuesta["descripcion_categoria"]; ?>" placeholder="Ingresela descripción de la categoría" required>
                            </div>
                            <button class="btn btn-primary" type="submit">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }

        //Aun no se ha visto
        public function eliminarCategoryController(){
            if(isset($_GET["idBorrar"])){
                $datosController = $_GET["idBorrar"];
                $respuesta = Datos::eliminarCategoryModel($datosController,"categories");
                if ($respuesta == "success") {
                echo '
                    <div class="col-md-6 mt-3">
                        <div class="alert alert-success alert-dismissible>
                            <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                            <h5>
                                <i class="icon fas fa-check"></i>
                                ¡Éxito!
                            </h5>
                            Stock modificado con éxito.
                        </div>
                    </div>
                ';
                } else {
                    echo '
                        <div class="col-md-6 mt-3">
                            <div class="alert alert-danger alert-dismissible>
                                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                                <h5>
                                    <i class="icon fas fa-check"></i>
                                    ¡Error!
                                </h5>
                                Error al modificar el stock
                            </div>
                        </div>
                    ';
                }
            }
        }
    }
?>
