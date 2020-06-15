<?php 
	class MvcController{ //Crea la clase MvcController.
		//LLAMADA A LA PLANTILLA.
		//Muestra una plantilla al usuario.
		public function plantilla(){ //Crea la función página.
			include "views/template.php"; //Incluye la vista del template.
		} //Termina la gunción página.

		
		//ENLACES
		//Controlador Mostrar enlaces
		public function enlacesPaginasController(){ //Crea la función para mandar a llamar los enlaces del sistemas que tienen como propósito mostrar las vistas.
			if(isset( $_GET['action'])){ //Si obtiene un valor que se manda por petición (URL) entra a la condición if.
				$enlaces = $_GET['action']; //Guardamos el valor de la peticion.
			}else{ //En dado caso no obtiene algún valor realiza entonces entra al else.
				$enlaces = "index"; //Guarda el valor "index" el cual quiere decir que mostrará la página principal.
			} //Termina la condición if.
			if ($enlaces == "") {
				$enlaces = "index";
			}
			//$enlaces = "ingresar";
			$respuesta = EnlacesPaginas::enlacesPaginasModel($enlaces); //Pasa un parametro los valores de los enlaces y se comunica con un modelo enlaces páginas model.
			include $respuesta; //Devuelve el enlace que se almacena en la petición.
		} //Termina la función enlacesPaginasController.

		//REGISTRO DE USUARIOS.
		//Controlador Registro de usuarios.
		public function registrarUserController(){ //Crea la función para realizar la acción de registro de usuarios.
			?>

			<div class="col-md-6 mt-3">
				<div class="card card-primary">
					<div class="card-header">
						<h4><b>Registro de usuaro</b></h4>
					</div>
					<div class="card-body">
						<form method="POST" action="index.php?action=usuarios">
							<div class="form-group">
								<label for="nusuariotxt">Nombre:</label>
								<input class="form-control" type="text" name="nusuariotxt" id="nusuariotxt" placeholder="Ingrese el nombre" required="">
							</div>
							<div class="form-group">
								<label for="ausuariotxt">Apellido:</label>
								<input class="form-control" type="text" name="ausuariotxt" placeholder="Ingrese el apellido" required="">
							</div>
							<div class="form-group">
								<label for="usuariotxt">Usuario:</label>
								<input class="form-control" type="text" name="usuariotxt" placeholder="Ingrese el usuario" required="">
							</div>
							<div class="form-group">
								<label for="ucontratxt">Contraseña:</label>
								<input class="form-control" type="password" name="ucontratxt" placeholder="Ingrese la contraseña" required="">
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
		} //Termina la funión registroUsuariosController.

		//INGRESO DE USUARIOS
		//Controlador de Ingreso de usuarios.
		public function ingresoUsuarioController(){ //Crea la función para realizar la acción de ingresar usuario.
			if(isset($_POST["txtUser"]) && isset($_POST["txtPassword"])){ //Si obtiene un valor que se manda por petición (URL) entra a la condición if.
				//Recibe a traves del método POST el name (html) de usuario y password del usuario, se almacenan los datos en una variable de tipo array con sus respectivas propiedades (usuario y password).
				$datosController = array( //Crea una variable de tipo array.
					"user"	 => $_POST["txtUser"], //Obtiene el usuario que se envía desde el formulario de ingresar.
					"password"	 => $_POST["txtPassword"]); //Obtiene el password que se envía desde el formulario de ingresar.
				$respuesta = Datos::ingresoUsuarioModel($datosController, "users"); //Se le dice al modelo models/crud.php (Datos::ingresoUsuarioModel), que en la clase "Datos", la funcion "ingresoUsuarioModel" reciba en sus 2 parametros los valores "$datosController" y el nombre de la tabla a conectarnos la cual es "usuarios".
				if($respuesta["usuario"] == $_POST["txtUser"] && $_POST["txtPassword"] == $respuesta["contrasena"]){ //Validación de la respuesta del modelo para ver si es un usuario correcto.
				//if($respuesta["usuario"] == $_POST["txtUser"] && password_verify($_POST["txtPassword"], $respuesta["contrasena"])){ //Validación de la respuesta del modelo para ver si es un usuario correcto.
					session_start(); //Crea la sesión mediante una petición POST.
					$_SESSION["validar"] 		= true; //Es una variable de sesión se guarda en el navegador y sirve para validar la sesión del usuario.
					$_SESSION["nombre_usuario"] = $respuesta["nombre_usuario"]; //Es una variable de sesión que guarda el nombre del usuario.
					$_SESSION["id"] 			= $respuesta["id"]; //Es una variable de sesión que guarda el id del usuario.
					header("location:index.php?action=tableros"); //Te redirige a la página principal con un dato en la url por el método GET (? = método get).
				}else{ //Si la respuesta es exitosa entonces entra al else.
					header("location:index.php?action=fallo&res=fallo"); //Te redirige a la página principal con un dato en la url por el método GET.
				} //Termina la condición if de la validación.
			} //Termina la condición if del isset.
		} //Termina la función ingresoUsuarioController.   
				
		//VISTA DE USUARIOS
		//Controlador de Vista de usuarios
		public function vistaUsersController(){ //Crea la función para visualizar la información del usuario que se encuentra almacenada en la base de datos.
			$respuesta = Datos::vistaUsersModel("users"); //Se le dice al modelo models//crud.php(Datos::vistaUsuariosModel) que en la clase Datos, la función "vistaUsuariosModel" reciba como parámetro el nombre de la tabla a conectarnos, la cual es "usuarios"
			foreach($respuesta as $row => $item){ //El constructor foreach proporciona un modo sencillo de iterar sobre arrays. foreach funciona sólo sobre arrays y objetos, y emitirá un error al intentar usarlo con una variable de un tipo diferente de datos o una variable no inicializada.
				//Crea la tabla en la cual se visualizará los datos del usuario.
				echo'<tr> 
						<td>
							<a href="index.php?action=usuarios&idUserEditar='.$item["id"].'"class="btn btn-warning btn-sn btn-icon" title="Editar" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
						</td>
						<td>
							<a href="index.php?action=usuarios&idBorrar='.$item["id"].'" class="btn btn-danger btn-sn btn-icon" title="Eliminar" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
						</td>
						<td>'.$item["firstname"].'</td>
						<td>'.$item["lastname"].'</td>
						<td>'.$item["user_name"].'</td>
						<td>'.$item["user_email"].'</td>
						<td>'.$item["date_added"].'</td
					</tr>';
			} //Termina el foreach
		} //Termina la función vistaUsuariosController

		public function insertarUserController(){ //Crea la función para iniciar sesión en el sistema.
			if(isset($_POST["nusuariotxt"])){  //Si obtiene un valor que se manda por petición (URL) entra a la condición if.
				//Encriptar la contraseña.	
				$_POST["ucontratxt"] = password_hash($_POST["ucontratxt"], PASSWORD_DEFAULT);//Guarda el valor obtenido por el metodo post y la encripta.
				$datosController = array( //Crea una variable de tipo arreglo para almacenar los datos del usuario.
										 "nusuario" => $_POST["nusuariotxt"], //Obtiene el nombre que se envía desde el formulario de Registrar.
										 "ausuario" => $_POST["ausuariotxt"], //Obtiene el apellido que se envía desde el formulario de Registrar.
										 "usuario" 	=> $_POST["usuariotxt"], //Obtiene el usuario que se envía desde el formulario de Registrar.
										 "contra" 	=> $_POST["ucontratxt"], //Obtiene la contraseña que se envía desde el formulario de Registrar.
										 "email" 	=> $_POST["uemailtxt"]); //Obtiene el correo electrónico que se envía desde el formulario de Registrar.
				//Se envía los datos al modelo.
				$respuesta = Datos::insertarUserModel($datosController, "users"); //Se le dice al modelo models/crud.php (Datos::registroUsuarioModel), que en la clase "Datos", la funcion "registroUsuarioModel" reciba en sus 2 parametros los valores "$datosController" y el nombre de la tabla a conectarnos la cual es "usuarios".
				//Respuesta del modelo.
				if($respuesta == "success"){ //Si la respuesta es exitosa entra a la condición if en el cual se mostrará un mensaje de Exito.
					echo '<div class="col-md-6 mt-3">
							<div class="alert alert-success alert-dismissible">
									<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
									<h5>
										<i class="icon fas fa-check"></i>
										¡Exito!
									</h5> 
									Usuario agregado con exito.
							</div>
						</div>';
				}else{ //Si no es una respuesta exitosa entra al else en el cual se mostrará un mensaje de Error.
					echo '<div class="col-md-6 mt-3">
							<div class="alert alert-danger alert-dismissible">
								<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
								<h5>
									<i class="icon fas fa-ban"></i>
									¡Error!
								</h5>
								Se ha producido un error al momento de agregar el usuario, trate de nuevo.
								</div>
							</div>';
				} //Termina la condición if.
			} //Termina la condición if del isset.
		} //Termina la función insertarUserController.

		/*-- Este controlador se encarga de mostrar el formulario al usuario para editar sus datos, la contraseña no se carga debido a que como esta encriptada, no es optimo mostrarle al usuario su contraseña como una cadena de caracteres y se deja en blanco, pero se verifica al momento de hacer una modifica que haya ingresado una contraseña, si no es el caso entonces no se podrá ejecutar la modificación y cada que se quiera hacer una modificación a un determinado usuario, se deberá ingresar tambien una nueva contraseña --*/
        public function editarUserController() { //Crea la función para editar información de los usuarios.
            $datosController = $_GET["idUserEditar"]; //Esto lo que hace es crear una variable que almacena el id del usuario el cual se obtiene por el método GET.
            //Envío de datos al mododelo
            $respuesta = Datos::editarUserModel($datosController,"users"); //Se le dice al modelo models/crud.php (Datos::editarUserModel), que en la clase "Datos", la funcion "editarUserModel" reciba en sus 2 parametros los valores "$datosController" y el nombre de la tabla a conectarnos la cual es "users".
            ?>
            <div class="col-md-6 mt-3"> <!--Crea el div mt-3-->
                <div class="card card-warning"> <!--Crea div para card-warning-->
                    <div class="card-header"> <!--Crea el div para card-header-->
                        <h4><b>Editor</b> de Usuarios</h4> <!--Crea una etiqueta que indica la acción que realizará la página-->
                    </div> <!--Termina el div para card-header-->
                    <div class="card-body"> <!--Crea el div para card-body-->
                        <form method="post" action="index.php?action=usuarios"> <!--Crea el formulario en el cual se almacenarán los label y cajas de textos-->
                            <div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran el id del usuario-->
                                <input type="hidden" name="idUserEditar" class="form-control" value="<?php echo $respuesta["id"]; ?>" required>
                            </div> <!--Termina el div para id-->
                            <div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran el nombre del usuario-->
                                <label for="nusuariotxtEditar">Nombre: </label> <!--Crea el label para nombre-->
                                <input class="form-control" type="text" name="nusuariotxtEditar" id="nusuariotxtEditar" placeholder="Ingrese el nuevo nombre" value="<?php echo $respuesta["nusuario"]; ?>" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del usuario se obtiene mediante php)-->
                            </div> <!--Termina el div para nombre-->
							<div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran el apellido del usuario-->
                                <label for="ausuariotxtEditar">Apellido: </label> <!--Crea el label para apellido-->
                                <input class="form-control" type="text" name="ausuariotxtEditar" id="ausuariotxtEditar" placeholder="Ingrese el nuevo apellido" value="<?php echo $respuesta["ausuario"]; ?>" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del usuario se obtiene mediante php)-->
                            </div> <!--Termina el div para apellido-->
                            <div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran el user-->
                                <label for="usuariotxtEditar">Usuario: </label> <!--Crea el label para usuario-->
                                <input class="form-control" type="text" name="usuariotxtEditar" id="usuariotxtEditar" placeholder="Ingrese el nuevo usuario" value="<?php echo $respuesta["usuario"]; ?>" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del usuario se obtiene mediante php)-->
                            </div> <!--Termina el div para usuario-->
							<div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran la contraseña del usuario-->
                                <label for="contratxtEditar">Contraseña: </label> <!--Crea el label para contraseña-->
                                <input class="form-control" type="password" name="contratxtEditar" id="contratxtEditar" placeholder="Ingrese la nueva contraseña" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del usuario se obtiene mediante php)-->
                            </div> <!--Termina el div para contraseña-->
                            <div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran el correo electrónico del usuario-->
                                <label for="uemailtxtEditar">Correo Electrónico: </label> <!--Crea el label para correo electrónico-->
                                <input class="form-control" type="email" name="uemailtxtEditar" id="uemailtxtEditar" placeholder="Ingrese el nuevo correo electrónico" value="<?php echo $respuesta["email"]; ?>" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del usuario se obtiene mediante php)-->
                            </div> <!--Termina el div para correo electrónico-->
                            <button class="btn btn-primary" type="submit">Editar</button> <!--Crea el botón para editar-->
                        </form> <!--Termina el formulario-->
                    </div> <!--Termina el div para card-body-->
                </div> <!--Termina el div para card-warning-->
            </div> <!--Termina el div mt-3-->
            <?php
        }

        //Este controlador sirve para actualizar el usuaio que se acaba de ingresar y notifica si se realizó dicha actividad o si hubo algún error.
        public function actualizarUserController(){ //Crea la función para actualizar información del usuario..
        	if(isset($_POST["nusuariotxtEditar"])){ //Si obtiene un valor que se manda por petición (URL) entra a la condición if.
        		$_POST["contratxtEditar"] = password_hash($_POST["contratxtEditar"], PASSWORD_DEFAULT); //Guarda el valor obtenido por el metodo post y la encripta.
        		$datosController = array(
        								"id" 		=> $_POST["idUserEditar"], //Obtiene el id del usuario que se envía desde el formulario de Editar.
        								"nusuario"  => $_POST["nusuariotxtEditar"], //Obtiene el nombre del usuario que se envía desde el formulario de Editar. 
        								//"ausuario" 	=> $_POST["nusuariotxtEditar"], //Obtiene el dato del usuario que se envía desde el formulario de Editar.
        								"ausuario"	=>$_POST["ausuariotxtEditar"], //Obtiene el apellido del usuario que se envía desde el formulario de Editar.
        								"usuario"	=>$_POST["usuariotxtEditar"], //Obtiene el user del usuario que se envía desde el formulario de Editar.
        								"contra"	=>$_POST["contratxtEditar"], //Obtiene la contraseña del usuario que se envía desde el formulario de Editar.
        								"email"		=>$_POST["uemailtxtEditar"]); //Obtiene el email del usuario que se envía desde el formulario de Editar.

        		$respuesta = Datos::actualizarUserModel($datosController, "users");
	        	
	        		if($respuesta == "success"){ //Si la respuesta es exitosa entra a la condición if en el cual se mostrará un mensaje de Exito.
						echo '<div class="col-md-6 mt-3">
								<div class="alert alert-success alert-dismissible">
									<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
									<h5>
										<i class="icon fas fa-check"></i>
										¡Exito!
									</h5> 
									Usuario editado con exito.
								</div>
							</div>';
					}else{ //Si no es una respuesta exitosa entra al else en el cual se mostrará un mensaje de Error.
						echo '<div class="col-md-6 mt-3">
								<div class="alert alert-danger alert-dismissible">
									<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
									<h5>
										<i class="icon fas fa-ban"></i>
										¡Error!
									</h5>
									Se ha producido un error al momento de editar el usuario, trate de nuevo.
								</div>
							  </div>';
					} //Termina la condición if.
        	} //Termina la condición if del isset.
        } //Termina la función actualizarUserController.

        //Esta funcion permite eliminar datos apartir del id seleccionado en la tabla atravez del botón funcionando desde el modelo y realizará la acción en la tabla una vez se borre mostrará un mensaje de error o de correcto dependiendo el caso.
        public function eliminarUserController(){ //Crea la función para eliminar usuarios ya existentes.
        	if(isset($_GET["idBorrar"])){ //Si obtiene un valor que se manda por petición (URL) entra a la condición if.
        		$datosController = $_GET["idBorrar"]; //Esto lo que hace es crear una variable que almacena el id del usuario el cual se obtiene por el método GET.
        		$respuesta = Datos::eliminarUserModel($datosController, "users");  //Se le dice al modelo models/crud.php (Datos::eliminarrUserModel), que en la clase "Datos", la funcion "eliminarUserModel" reciba en sus 2 parametros los valores "$datosController" y el nombre de la tabla a conectarnos la cual es "users".
        		if($respuesta == "success"){ //Si la respuesta es exitosa entra a la condición if en el cual se mostrará un mensaje de Exito.
        			echo '<div class="col-md-6 mt-3">
							<div class="alert alert-success alert-dismissible">
								<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
								<h5>
									<i class="icon fas fa-check"></i>
									¡Exito!
								</h5> 
								Usuario agregado con exito.
							</div>
						 </div>';
				}else{ //Si no es una respuesta exitosa entra al else en el cual se mostrará un mensaje de Error.
					echo '<div class="col-md-6 mt-3">
							<div class="alert alert-danger alert-dismissible">
								<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
								<h5>
									<i class="icon fas fa-ban"></i>
									¡Error!
								</h5>
								Se ha producido un error al momento de agregar el usuario, trate de nuevo.
							</div>
						 </div>';
				} //Termina la confición if.
        	} //Termina la condición if del isset.
        } //Termina la función eliminarUserController.

    	// CONTROLADORES PARA EL TABLERO //
        /*-- Este controlador sirve para mostrarle al usuario las cajas donde se tiene información sobre los usuarios, productos y ventas registradas, así como los movimientos que se tienen en el historial (altas/bajas de productos) y las ganancias que se tienen de acuerdo a todas las ventas --*/
        public function contarFilas(){ //Crea la función para contabilizar la cantidad de registros que hay en las tablas de la bd.
            $respuesta_users = Datos::contarFilasModel("users"); //Almacenar en la variable la cantidad de registros que contiene la tabla users.
            $respuesta_products = Datos::contarFilasModel("products"); //Almacenar en la variable la cantidad de registros que contiene la tabla products.
            $respuesta_categories = Datos::contarFilasModel("categories"); //Almacenar en la variable la cantidad de registros que contiene la tabla categories.
            $respuesta_historial = Datos::contarFilasModel("historial"); //Almacenar en la variable la cantidad de registros que contiene la tabla historial.

            //Muestra la cantidad de filas que hay en cada una de las tablas.
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

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-teal">
                        <div class="inner">
                            <h3>'.$respuesta_products["filas"].'</h3>
                            <p>Total de Productos</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <a class="small-box-footer" href="index.php?action=inventario">Más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-olive">
                        <div class="inner">
                            <h3>'.$respuesta_categories["filas"].'</h3>
                            <p>Total de Categorías</p>
                        </div>
                        <div class="icon">
                        <i class="fas fa-tag"></i>
                        </div>
                        <a class="small-box-footer" href="index.php?action=categorias">Más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-gray">
                        <div class="inner">
                            <h3>'.$respuesta_historial["filas"].'</h3>
                            <p>Movimientos en el Inventario</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-archive"></i>
                        </div>
                        <a class="small-box-footer" href="index.php?action=inventario">Más <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                 ';
        }//Termina la función de contar Filas

        //Este controlador funciona para mostrar los datos de la tabla productos al usuario.
        public function vistaProductsController(){ //Crea la función para visualizar los productos que están registrados
        	$respuesta = Datos::vistaProductsModel("products"); //Se le dice al modelo models/crud.php (Datos::vistaProductsModel), que en la clase "Datos", la función "vistaProductsModel" recibe en sus 2 parámetros los valores "datosController" y el nombre de la tabla a conectarnos la cual es "products".
        	foreach ($respuesta as $row => $item) { //El constructor foreach proporciona un modo sencillo de iterar sobre arrays. foreach funciona sólo sobre arrays y objetos, y emitirá un error al intentar usarlo con una variable de un tipo diferente de datos o una variable no inicializada.
        		echo '<tr>
        				<td> <a href="index.php?action=inventario&idProductEditar='.$item["id"].'" class="btn btn-warning btn-sn btn-icon" title="Editar" data-toggle="tooltip"> <i class="fa fa-edit"></i></a> 
        				</td>
        				<td>
        					<a href="index.php?action=inventario&idProductoBorrar='.$item["id"].'" class="btn btn-danger btn-sn btn-icon" title="Eliminar" data-toggle="tooltip"><i class="fa fa-trash"></i></a>
        				</td>
        				<td>'.$item["id"].'</td>
        				<td>'.$item["codigo"].'</td>
        				<td>'.$item["producto"].'</td>
        				<td>'.$item["precio"].'</td>
        				<td>'.$item["stock"].'</td>
        				<td>'.$item["categoria"].'</td>

        				<td>
        					<a href="index.php?action=inventario&idProductoAdd='.$item["id"].' "class="btn btn-warning btn-sn btn-icon" title="Agregar Stock" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
        				</td>
        				<td>
        					<a href="index.php?action=inventario&idProductoDel='.$item["id"].'" class="btn btn-warning btn-sn btn-icon" title="Quitar de Stock" data-toggle="tooltip"><i class="fa fa-edit"></i></a>
        				</td>';
        	}
        }

        public function registrarProductController(){
        	//Se cierra el php
        	?>
        	<div class="col-md-6 ml-3"> <!--Crea el div mt-3-->
        		<div class="card card-primary"> <!--Crea div para card-primary-->
        			<div class="card-header"> <!--Crea el div para card-header-->
        				<h4><b>Registro de Productos</b></h4> <!--Crea una etiqueta que indica la acción que realizará la página-->
        			</div> <!--Termina el div para card-header-->
        			<div class="card-body"> <!--Crea el div para card-body-->
        				<form method="POST" action="index.php?action=inventario"> <!--Crea el formulario en el cual se almacenarán los label y cajas de textos-->
        					<div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran el codigo del producto-->
        						<label for="codigotxt">Código:</label> <!--Crea el label para codigo-->
        						<input class="form-control" type="text" name="codigotxt" id="codigotxt" placeholder="Codigo del producto" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del producto se obtiene mediante php)-->
                            </div> <!--Termina el div para codigo-->
        					<div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran el nombre del producto-->
        						<label for="nombretxt">Nombre:</label> <!--Crea el label para nombre-->
        						<input class="form-control" type="text" name="nombretxt" id="nombretxt" placeholder="Nombre del producto" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del producto se obtiene mediante php)-->
        					</div> <!--Termina el div para nombre-->
        					<div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran el precio del producto-->
        						<label for="preciotxt">Precio:</label> <!--Crea el label para precio-->
        						<input class="form-control" type="text" name="preciotxt" id="preciotxt" placeholder="Precio del producto" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del producto se obtiene mediante php)-->
        					</div> <!--Termina el div para precio-->
        					<div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran la cantidad de stock del producto-->
        						<label for="stocktxt">Stock:</label> <!--Crea el label para stock-->
        						<input class="form-control" type="text" name="stocktxt" id="stocktxt" placeholder="Cantidad de stock del producto" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del producto se obtiene mediante php)-->
        					</div> <!--Termina el div para stock-->
        					<div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran la referencia del producto-->
        						<label for="motivotxt">Motivo:</label> <!--Crea el label para motivo-->
        						<input class="form-control" type="text" name="motivotxt" id="motivotxt" placeholder="Referencia del producto" required> <!--Crea la caja de texto en el que se indica el tipo, nombre, id, placeholder (indica lo que se ingresará en la caja de texto) y value el cual contiene el dato del usuario (este dato del producto se obtiene mediante php)-->
        					</div> <!--Termina el div para motivo-->
        					<div class="form-group"> <!--Crea el div para agrupar los elementos creados que indicaran la categoria del producto-->
        						<label for="uemailtxt">Categoria:</label> <!--Crea el label para categoria-->
        						<select name="categoria" id="categoria" class="form-control"> <!--Se crea el select el cual dará opciones para seleccionar alguna categoría-->
        							<option value="0">Seleccione una opción</option>
        							<?php 
        								$respuesta_categoria = Datos::obtenerCategoryModel("categories"); //Almacena en una variable el valor que reciba al conectarse con la tabla "categorias"
        								foreach ($respuesta_categoria as $row => $item) { //El constructor foreach proporciona un modo sencillo de iterar sobre arrays. foreach funciona sólo sobre arrays y objetos, y emitirá un error al intentar usarlo con una variable de un tipo diferente de datos o una variable no inicializada.
        							?>	
        									<option value="<?php echo $item["id"]; ?>"> <?php echo $item["categoria"]; ?> </option> <!--Muestra las opciones de seleccion para alguna categoría mediante PHP-->	 
        							<?php
        								 } 
        							?>
        						</select>
        					</div> <!--Termina el div para categoria-->
       						<button class="btn btn-primary" type="submit">Agregar</button> <!--Crea el botón para agregar-->
        				</form> <!--Termina el formulario-->
        			</div> <!--Termina el div para card-body-->
        		</div> <!--Termina el div para card-primary-->
        	</div> <!--Termina el div mt-3-->
        	<?php
        } //Termina la función registrarProductoController

        /*-- Esta funcion permite insertar productos llamando al modelo  que se encuentra en  el archivo crud de modelos confirma con un isset que la caja de texto del codigo este llena y procede a llenar en una variable llamada datos controller este arreglo se manda como parametro al igual que el nombre de la tabla,una vez se obtiene una respuesta de la funcion del modelo de inserccion tenemos que checar si la respuesta fue afirmativa hubo un error y mostrara los respectivas alerta,para insertar datos en la tabla de historial se tiene que mandar a un modelo llamado ultimoproductmodel este traera el ultimo dato insertado que es el id del producto que se manda en el array de datoscontroller2 junto al nombre de la tabla asi insertando los datos en la tabla historial --*/  /*-- Esta funcion permite insertar productos llamando al modelo  que se encuentra en  el archivo crud de modelos confirma con un isset que la caja de texto del codigo este llena y procede a llenar en una variable llamada datos controller este arreglo se manda como parametro al igual que el nombre de la tabla,una vez se obtiene una respuesta de la funcion del modelo de inserccion 
        tenemos que checar si la respuesta fue afirmativa hubo un error y mostrara los respectivas alerta,para insertar datos en la tabla de historial se tiene que mandar a un modelo llamado ultimoproductmodel este traera el ultimo dato insertado que es el id del producto que se manda en el array de datoscontroller2 junto al nombre de la tabla asi insertando los datos en la tabla historial --*/
        public function insertarProductController(){ //rea la función para ingresar nuevos registros
        	if (isset($_POST["codigotxt"])) { //Si obtiene un valor que se manda por petición (URL) entra a la condición if.
        		$datosController = array( //Crea una variable de tipo arreglo para almacenar los datos del usuario.
        							"codigo"	=>$_POST["codigotxt"], //Obtiene el codigo que se envía desde el formulario de Registrar.
        							"precio"	=>$_POST["preciotxt"], //Obtiene el precio que se envía desde el formulario de Registrar.
        							"stock"		=>$_POST["stocktxt"], //Obtiene el stock que se envía desde el formulario de Registrar.
        							"categoria"	=>$_POST["categoria"], //Obtiene el categoria que se envía desde el formulario de Registrar.
      	  							"nombre"	=>$_POST["nombretxt"]); //Obtiene el nombre que se envía desde el formulario de Registrar.
        							
        		$respuesta = Datos::insertarProductsModel($datosController, "products"); //Se le dice al modelo models/crud.php(Datos::insertarProductsModel) que en la clase Datos, la función "insertarProductsModel" reciba como parámetro el nombre de la tabla a conectarnos, la cual es "products"
        		if ($respuesta == "success") { //Si la respuesta es exitosa entra a la condición if en el cual se mostrará un mensaje de Exito.
        			$respuesta3 = Datos::ultimoProductsModel("products"); //Se le dice al modelo models/crud.php(Datos::insertarProductsModel) que en la clase Datos, la función "insertarProductsModel" reciba como parámetro el nombre de la tabla a conectarnos, la cual es "products"
        			$datosController2 = array(
        									  "user"      =>$_SESSION["id"], 
        									  "cantidad"  =>$_POST["stocktxt"], 
        									  "producto"  =>$respuesta3["id"],
        									  "note"      =>$_SESSION["nombre_usuario"]."agrego/compro",
        									  "reference" =>$_POST["motivotxt"]);

        			$respuesta2 = Datos::insertarHistorialModel($datosController2, "historial");

        			echo '<div class="col-md-6 mt-3">
        					<div class="alert alert-success alert-dismissible">
        							<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        								<h5>
        									<i class="icon fas fa-check"></i>
        									¡Exito!
        								</h5>
        								Producto agregado con exito.
        					</div>
        				</div>';
        		}else{
        			echo '<div class="col-md-6 mt-3">
        					<div class="alert alert-danger alert-dismissible">
        							<button class="close" type="button" data-dismiss="alert" aria-hidden"true">x</button>
        								<h5>
        									<i class="icon fas fa-ban"></i>
        									¡Error!
        								</h5>
        								Se ha producido un error al momento de agregar el producto, trate de nuevo.
        					</div>
        				</div>';
        		}
        	}
        }
        /*-- Esta funcion permite editar los datos de lat abla productos delproducto seleccionado del boton editar abre un formulario llenando la informacion correspondiente y empezando a editardichos campos apartir de los formularios el array de datossolo guarda el get delboton editar que en este caso es el id del producto y se envia elmodelo de edicioon y se pasa por el metodo form al igual que los demas datos --*/
        public function editarProductController(){
        	$datosController = $_GET["idProductEditar"];
        	$respuesta = Datos::editarProductModel($datosController, "products");
        	?>
        	<div class="col-md-6 mt-3">
        		<div class="card card-warning">
        			<div class="card-header">
        				<h4><b>Editor de productos</b></h4>
        			</div>
        			<div class="card-body">
        				<form method="POST" action="index.php?action=inventario">
        					<div class="form-group">
        						<input type="hidden" name="idProductEditar" id="idProductEditar" class="form-control" value="<?php echo $respuesta["id"]; ?>" required>
        					</div>
        					<div class="form-group">
        						<label for="codigotxtEditar">Código: </label>
        						<input class="form-control" type="number" name="codigotxteditar" id="codigotxteditar" value="<?php echo $respuesta["codigo"]; ?>" placeholder="Código de producto" required>
        					</div>
        					<div class="form-group">
        						<label for="nombretxtEditar">Nombre: </label>
        						<input class="form-control" type="text" name="nombretxteditar" id="nombretxteditar" value="<?php echo $respuesta["nombre"]; ?>" placeholder="Nombre de producto" required>
        					</div>
        					<div class="form-group">
        						<label for="preciotxtEditar">Precio: </label>
        						<input class="form-control" type="number" name="preciotxteditar" id="preciotxteditar" min="1" value="<?php echo $respuesta["precio"]; ?>" placeholder="Precio de producto" required>
        					</div>
        					<div class="form-group">
        						<label for="stocktxtEditar">Stock: </label>
        						<input class="form-control" type="number" name="stocktxteditar" id="stocktxteditar" min="1" value="<?php echo $respuesta["stock"]; ?>" placeholder="Cantidad de stock del producto" required>
        					</div>
        					<div class="form-group">
        						<label for="referenciatxtEditar">Motivo: </label>
        						<input class="form-control" type="text" name="referenciatxteditar" id="referenciatxteditar" placeholder="Referencia del producto" required>
        					</div>
        					<div class="form-group">
        						<label for="categoriatxtEditar">Categoría: </label>
        						<select name="categoriaeditar" id="categoriaeditar" class="form-control">
        							<?php
        								$respuesta_categoria = Datos::obtenerCategoryModel("categories");
        								foreach ($respuesta_categoria as $row => $item) {
    								?>
    									<option value="<?php echo $item["id"]; ?>"><?php echo $item["categoria"]; ?></option>
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

        //Esta función permite actualizar los datos en la tabla productos a partir del método form anterior mandando la atravéz del modelo del crud atravez del arreglo y con la variable respuesta mandamos dichos datos porque se llama al modelo actualizarProductoModel si en el modelo se realizó correctamente entonces mandará una alerta decorrecto y pasará a llenar dichos datos en el modelo de insertar historial model en caso contrario no se hará nada y mostrará el mensaje de error.
        public function actualizarProductsController(){
        	if(isset($_POST["codigotxtEditar"])){
        		$datosController = array(
        								"id"		=>$_POST["idProductEditar"], 
        								"codigo"	=>$_POST["codigotxteditar"], 
        								"precio"	=>$_POST["preciotxteditar"], 
        								"stock"		=>$_POST["stocktxteditar"], 
        								"categoria" =>$_POST["categoriaeditar"], 
        								"nombre"	=>$_POST["nombretxteditar"]);
        		$respuesta = Datos::actualizarProductsModel($datosController, "products");
        		if($respuesta == "success"){
        			$datosController2 = array(
        								"user"=>$_SESSION["id"], 
        								"cantidad"=>$_POST["stocktxteditar"], 
        								"producto"=>$_POST["idProductEditar"], 
        								"note"=>$_POST["nombre_usuario"]."agrego/compro", 
        								"reference"=>$_POST["referenciatxteditar"]);
        			$resuesta2 = Datos::ingresarHistorialModel($datosController2, "historial");
        			
        			echo '<div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible">
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Exito!
        							</h5>
        							Producto actualizado con exito.
        					</div>
        				</div>';
        		}else{
        			echo '<div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible">
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Error!
        							</h5>
        							Se ha producido un error al momento de actualizar el producto, trate de nuevo.
        					</div>
        				</div>';
        		}
        	}
        }

        //Esta funcion permite eliminar datos apartir del id seleccionado en la tabla atravez del botón funcionando desde el modelo y realizará la acción en la tabla una vez se borre mostrará un mensaje de error o de correcto dependiendo el caso.
        public function eliminarProductController(){
        	if(isset($_GET["idBorrar"])){
        		$datosController = $_GET["idBorrar"];
        		$respuesta = Datos::eliminarProductsModel($datosController, "products");
        		if($respuesta == "success"){
        			echo '<div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Exito!
        							</h5>
        							Producto eliminado con exito.
        					</div>
        				 </div>';
        		}else{
        			echo '<div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Error!
        							</h5>
        							Se ha producido un error al momento de eliminar el producto, trate de nuevo.
        					</div>
        				 </div>';
        		}
        	}
        }

        //Esta función permite agregar productos al stock atravéz del botón y un formulario para agregar dicha cantidad al producto se llama al modelo correspondiente para así pasar al controlador que actualizar dicho modelo.
        public function addProductController(){
        	$datosController = $_GET["idProductAdd"];
        	$respuesta = Datos::editarProductModel($datosController, "products");
        	?>
        	<div class="col-md-6 mt-3">
        		<div class="card card-warning">
        			<div class="card-header">
        				<h4><b>Agregar</b> stock al producto</h4>
        			</div>
        			<div class="card-body">
        				<form method="POST" action="index.php?action=inventario">
        					<div class="form-group">
        						<input type="hidden" name="idProductAdd" class="form-control" value="<?php echo $respuesta["id"]; ?>" required>
        					</div>
        					<div class="form-group">
        						<label for="codigotxteditar">Stock:</label>
        						<input type="number" name="addstocktxt" class="form-control" id="addstocktxt" min="1" value="1" required>
        					</div>
        					<div class="form-group">
        						<label for="referenciatxtadd">Motivo:</label>
        						<input type="text" name="referenciatxtadd" class="form-control" id="referenciatxtadd"  required placeholder="Referencia del producto">
        					</div>
        					<button class="btn btn-primary" type="submit">Realizar cambio</button>
        				</form>
        			</div>
        		</div>
        	</div>
        	<?php
        }

        //Esta función actualiza y llama al modelo de la tabla producto a su vez inserta una nueva fila a la tabla historial, si el update sale correcto y agrega los productos del stock entoces insertara la actualización en la tabla historial, si todo sale bien mostrara un mensaje de error o de correcto dependiendo de la respuesta.
        public function actualizar1StockController(){
        	if(isset($_POST["addstocktxt"])){
        		$datosController = array("id"=>$_POST["idProductAdd"], "stok"=>$_POST["addstocktxt"]);
        		$respuesta2=Datos::pushProductModel($datosController, "products");
        		if ($respuesta == "success") {
        			$datosController2 = array("user"=>$_SESSION["id"], "cantidad"=>$_POST["addstocktxt"], "producto"=>$_POST["idProductAdd"], "note"=>$_SESSION["nombre_usuario"]."agrego/compro", "referencia"=>$_POST["referenciatxtadd"]);
        			$respuesta2 = Datos::insertarHistorialModel($datosController2, "historial");

        			echo '<div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Exito!
        							</h5>
        							Stock actualizado con exito.
        					</div>
        				</div>';
        		}else{
        			echo '<div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Error!
        							</h5>
        							Se ha producido un error al momento de actualizar el stock de producto, trate de nuevo.
        					</div>
        				</div>';
        		}
        	}
        }

        /*-- Esta funcion actualiza y llama al modelo de latabla producto asu vez inserta una nueva fila a la tabla historial, si el update sale correcto y elimina los productos  del stock entonces insertara la actualizacion en la tabla historial, si todo sale bien mostrara un mensaje de error o de correcto dependiendo de la respuesta --*/
        public function actualizar2StockController(){
        	if(isset($_POST["addstocktxt"])){
        		$datosController = array("id"=>$_POST["idProductDel"], "stok"=>$_POST["addstocktxt"]);
        		$respuesta=Datos::pullProductModel($datosController, "products");
        		if ($respuesta == "success") {
        			$datosController2 = array("user"=>$_SESSION["id"], "cantidad"=>$_POST["addstocktxt"], "producto"=>$_POST["idProductDel"], "note"=>$_SESSION["nombre_usuario"]."quito", "reference"=>$_POST["referenciatxtdel"]);
        			$respuesta2 = Datos::insertarHistorialModel($datosController2, "historial");

        			echo '<div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Exito!
        							</h5>
        							Stock actualizado con exito.
        					</div>
        				</div>';
        		}else{
        			echo '<div class="col-md6 t-3">
        					<div class="alert alert-success alert-dismissible>
        						<button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
        							<h5>
        								<i class="icon fas fa-check">
        								¡Error!
        							</h5>
        							Se ha producido un error al momento de actualizar el stock de producto, trate de nuevo.
        					</div>
        				</div>';
        		}
        	}
        }

        //Esta función permite quita productos al stock atravéz del botón y un formulario para agregar dicha información del prodycto se llama al modelo correspondiente para así pasar al controlador que lo actualiza.
        public function delproductoController(){
        	$datosController = $_GET["idProductDel"];
        	$respuesta = Datos::editarProductsModel($datosController, "products");
        	?>
        	<div class="col-md-6 mt-3">
        		<div class="card-header">
        			<h4><b>Eliminar</b> stock al producto</h4>
        		</div>
        		<div class="card-body">
        			<form method="POST" action="index.php?action=inventario">
        				<div class="form-group">
        					<input type="hidden" name="idProductDel" class="form-control" value="<?php echo $respuesta["id"]; ?>" required>
        				</div>
        				<div class="form-group">
        					<label for="codigotxteditar">Stock:</label>
        					<input type="number" name="delstocktxt" class="form-control" min="1" value="<?php echo $respuesta["stock"]; ?>" required>
        				</div>
        				<div class="form-group">
        					<label for="referenciatxtdel">Motivo:</label>
        					<input type="text" name="referenciatxtdel" class="form-control" required placeholder="Referencia del producto">
        				</div>
        				<button class="btn btn-primary" type="submit">Realizar cambio</button>
        			</form>
        		</div>
        	</div>
        	<?php
        }

        //CONTROLAORES PARA EL HISTORIAL
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
        			</tr>';
        	}
        }

	} //Termina la clase MvcController.
?>