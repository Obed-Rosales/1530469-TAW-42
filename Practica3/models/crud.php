<?php
	//Llamada a la conexión con la bd
	include "conexion.php";

	class Datos extends Conexion{
		// MODELOS PARA LOS USUARIOS //
        /*-- Modelo para el inicio de sesión de los usuarios --*/
        public function ingresoUsuarioModel($datosModel,$tabla){
            //Preparar las sentencias de PDO para ejecutar el Qery de validación de usuario
            $stmt = Conexion::conectar()->prepare("SELECT CONCAT(firstname,' ',lastname) AS 'nombre_usuario', user_name AS 'usuario', user_password AS 'contrasena',user_id AS 'id' FROM $tabla WHERE user_name = :usuario");
            $stmt->bindParam(":usuario",$datosModel["user"],PDO::PARAM_STR);
            //$stmt->bindParam(":contrasena", $datosModel["password"], PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
        }

         /*-- Este modelo sirve para mostrar toda la información de los usuarios que existen --*/
        public function vistaUsersModel($tabla) {
            // Preparar la sentencia de PDO
            $stmt = Conexion::conectar()->prepare("SELECT user_id AS 'id', firstname, lastname, user_name, user_password, user_email, date_added FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
        }

         /*-- Este modelo sirve para insertar un nuevo usuario a la bd --*/
        public function insertarUserModel($datosModel,$tabla) {
            //preparamos el PDO
            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (firstname,lastname,user_name,user_password,user_email) VALUES (:nusuario,:ausuario,:usuario,:contra,:email)");
            $stmt -> bindParam(":nusuario",$datosModel["nusuario"], PDO::PARAM_STR);
            $stmt -> bindParam(":ausuario",$datosModel["ausuario"], PDO::PARAM_STR);
            $stmt -> bindParam(":usuario", $datosModel["usuario"],  PDO::PARAM_STR);
            $stmt -> bindParam(":contra",  $datosModel["contra"],   PDO::PARAM_STR);
            $stmt -> bindParam(":email",   $datosModel["email"],    PDO::PARAM_STR);
            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
            $stmt->close();
        }

        //Este modelo sirve para cargar la información del usuario para su posterior modificación
        public function editarUserModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT user_id AS 'id', firstname AS 'nusuario', lastname AS 'ausuario', user_name AS 'usuario', user_password AS 'contra', user_email AS 'email' FROM $tabla WHERE user_id=:id");
        	$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
        	$stmt->execute();
        	return $stmt->fetch();
        	$stmt->close();
        }

        //Este modelo sirve para guardar los cambios hechos a un usuarios en particular
        public function actualizarUserModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET firstname =:nusuario, lastname = :ausuario, user_name = :usuario, user_password = :contra, user_email = :email WHERE user_id = :id");
        	$stmt -> bindParam(":nusuario", $datosModel["nusuario"], PDO::PARAM_STR);
        	$stmt -> bindParam(":ausuario", $datosModel["ausuario"], PDO::PARAM_STR);
        	$stmt -> bindParam(":usuario",  $datosModel["usuario"],  PDO::PARAM_STR);
        	$stmt -> bindParam(":contra",   $datosModel["contra"],   PDO::PARAM_STR);
        	$stmt -> bindParam(":email",    $datosModel["email"],    PDO::PARAM_STR);
        	$stmt -> bindParam(":id",       $datosModel["id"],       PDO::PARAM_INT);
        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}
        }

        public function eliminarUserModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE user_id = :id");
        	$stmt -> bindParam(":id", $datosModel, PDO::PARAM_INT);
        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }
        //Este modelo permite conocer el numero de filas en determinaa tabla, se utiliza para mostrar información en el tablero
        public function contarFilasModel($tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS 'filas' FROM $tabla");
        	$stmt -> execute();
        	return $stmt->fetch();
        	$stmt -> close();
        }

        //Este modelo permite conoccer que tanto ha ganado la tienda de acuerdo a todas las venta que se tienen en la base de datos
        public function sumarGananciaModel($tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT SUM(amount) AS 'total' FROM $tabla");
        	$stmt -> execute();
        	return $stmt->fetch();
        	$stmt -> close();
        }

        //Este modelo permite conocer cuantos prodyctos existen en la base de datos con stock superior a 1
        public function obtenerProductsModel($tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT id_product AS 'id', name_product AS 'nproduct' , price_product AS 'nprecio' FROM $tabla WHERE stock >= 1");
        	$stmt -> execute();
        	return $stmt->fetch();
        	$stmt -> close();
        }

        //Este modelo trae los datos que se muestra en la tabla de la vista que se imprimen en el controlador de vista de productos
        public function vistaProductsModel($tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT p.id_product AS 'id', p.code_producto AS 'codigo', p.name_product AS 'producto', p.date_added AS 'fecha', p.price_product AS 'precio', p.stock AS 'stock', c.name_category AS 'categoria' FROM $tabla p INNER JOIN categories c ON p.id_category = c.id_category");
        	$stmt -> execute();
        	return $stmt->fetchAll();
        	$stmt -> close();
        }

        //Este modelo permite insertar en la tabla productos a partir de los datos traidos en el array y la tabla por lo se den los valores y se genera la insercción
        public function insertarProductsModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (code_producto, name_product, price_product, stock, id_category) VALUES (:codigo, :nombre, :precio, :stock, :categoria)");
        	$stmt->bindParam(":codigo", $datosModel["codigo"], PDO::PARAM_STR);
        	$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
        	$stmt->bindParam(":precio", $datosModel["precio"], PDO::PARAM_INT);
        	$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_INT);
            //$stmt->bindParam(":motivo", $datosModel["stock"], PDO::PARAM_STR);
        	$stmt->bindParam(":categoria", $datosModel["categoria"], PDO::PARAM_INT);

        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }

        //Este modelo trae los datos que necesitan editar en el formulario de edición de productos a partir del id del producto enviado por parámetro
        public function editarProductModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT id_product AS 'id', code_producto AS 'codigo', name_product AS 'nombre', price_product AS 'precio', stock FROM $tabla WHERE id_product = :id");
        	$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
        	$stmt->execute();
        	return $stmt->fetchAll();
        	$stmt -> close();
        }

        //Este modelo permite actualizar la tabla producto recibiendo solamete el stock y el id esta sentencia agrega stock
        public function pushProductsModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = stock + :stock WHERE id_product = :id");
        	$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_INT);
        	$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);
        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }

        //Este modelo actualiza la tabla producto recibiendo solamente el stock y el id esta sentencia quita el stock
        public function pullProductsMode($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET stock = stock + :stock WHERE id_product = :id AND stock >= :stock");
        	$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_INT);
        	$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);
        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }

        //Este modelo permite actualizar la tabla producto escribiendo los datos necesarios a partir del arreglo y de la tabla promedio de pdo actualiza dicha tabla mandando una respuesta como las demas dando un success y o error como respuesta para los controladores
        public function actualizarProductsModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET code_producto = :codigo, name_product = :nombre, price_product = :precio, id_category = :categoria, stock = :stock WHERE id_product = :id");
        	$stmt->bindParam(":codigo", $datosModel["codigo"], PDO::PARAM_STR);
        	$stmt->bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
        	$stmt->bindParam(":precio", $datosModel["precio"], PDO::PARAM_INT);
        	$stmt->bindParam(":stock", $datosModel["stock"], PDO::PARAM_INT);
        	$stmt->bindParam(":categoria", $datosModel["categoria"], PDO::PARAM_INT);
        	$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);
        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }

        //Este modelo permite eliminar los datos atravéz del arreglo anterior que trae el id en el cual en la siguiente sentencia solo elimina a partir del id recibido.
        public function eliminarProductsModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_product = :id");
        	$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }

        //Este modelo perite recolectar el último id del registro que permite usar para insertar en la tabla de historial los datos necesarios siendo el id del producto uno de ellos.
        public function ultimoProductsModel($tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT id_product AS 'id' FROM $tabla ORDER BY id_product DESC LIMIT 1");
        	$stmt -> execute();
        	return $stmt->fetch();
        	$stmt -> close();
        }

        //MODELOS PARA EL HISTORIAL
        //Recibe la tabla por parametro y en los select recolectamos los datos que necesita la tabla historial de la vista apartir de PDO.
        public function vistaHistorialModel($tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT CONAT(u.firstname, ':', u.user_name) AS 'usuario', p.name_product AS 'producto', h.date AS 'fecha', h.reference AS 'referencia', h.note AS 'nota', h.quantity AS 'cantidad' FROM $tabla h INNER JOIN products p ON h.id_product = p.id_product INNER JOIN users u ON h.user_id = u.user_id");
        	$stmt -> execute();
        	return $stmt->fetchAll();
        	$stmt -> close();
        }

        //Recibe la tabla por parámetro al igual que los datos necesarios para el INSERT recolectados de los formularios anteriores los datos que necesita la tabla historial de al instertar apartir de PDO

        public function insertarHistorialModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(user_id, quantity, id_producto, note, reference) VALUES (:user, :cantidad, :producto, :note, :reference)");
        	$stmt -> bindParam(":user", $datosModel["user"], PDO::PARAM_INT);
        	$stmt -> bindParam(":cantidad", $datosModel["cantidad"], PDO::PARAM_INT);
        	$stmt -> bindParam(":producto", $datosModel["producto"], PDO::PARAM_INT);
        	$stmt -> bindParam(":note", $datosModel["note"], PDO::PARAM_STR);
        	$stmt -> bindParam(":reference", $datosModel["reference"], PDO::PARAM_STR);
        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }

        //MODELOS PARA CATEGORIAS
        //Estemodelo se utiliza para mostrar la información de cada categoría.
        public function vistaCategoriaModel($tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT id_category AS 'idc', name_category AS 'ncategoria' descripcion_category AS 'dcategoria', date_added AS 'fcategoria' FROM $tabla");
        	$stmt -> execute();
        	return $stmt->fetchAll();
        	$stmt -> close();            
        }

        //Este modelo utiliza para insertar una nueva categoría a la base de datos
        public function insertarCategoryModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (name_category, descripcion_category) VALUES (:ncategoria, :dcategoria)");
        	$stmt -> bindParam(":ncategoria", $datosModel["ncategoria"], PDO::PARAM_STR);
        	$stmt -> bindParam(":dcategoria", $datosModel["dcategoria"], PDO::PARAM_STR);

        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }

        //Este modelo se utiliza para cargar los datos de la categoria para modificarlos más adelante.
        public function editarCategoryModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT id_category AS 'id', name_category AS 'nombre_categoria', descripcion_category AS 'descripcion_categoria' FROM $tabla WHERE id_category = :id");
        	$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
        	$stmt -> execute();
        	return $stmt->fetchAll();
        	$stmt -> close();
        }

        //Este modelo se utiliza para modificar una categoria
        public function actualizarCategoryModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET name_category = :nombre_categoria, descripcion_category = :descripcion_categoria WHERE id_category = :id");
        	$stmt->bindParam(":nombre_categoria", $datosModel["nombre_categoria"], PDO::PARAM_INT);
        	$stmt->bindParam(":descripcion_categoria", $datosModel["descripcion_categoria"], PDO::PARAM_INT);
        	$stmt->bindParam(":id", $datosModel["id"], PDO::PARAM_INT);
        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }

        //Este modelo se utiliza para eliminar una categoría
        public function eliminarCategoryModel($datosModel, $tabla){
        	$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_category = :id");
        	$stmt->bindParam(":id", $datosModel, PDO::PARAM_INT);
        	if($stmt->execute()){
        		return "success";
        	}else{
        		return "error";
        	}

        	$stmt->close();
        }

        //MODELOS PARA LOS SELECTS
        //Este modelo permite crear un select y mostrarlo a partir de un select en php dando las categorías y nombres en el formulario roducto

        public function obtenerCategoryModel($tabla){
        	$stmt = Conexion::conectar()->prepare("SELECT id_category AS 'id', name_category AS 'categoria' FROM $tabla");
        	$stmt->execute();
        	return $stmt->fetchAll();
            $stmt->close();
        }
	}
?>