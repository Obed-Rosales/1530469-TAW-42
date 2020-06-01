<?php
    //Llamada a la conexion
    include "conexion.php";
    //Clase que servira para realizar las consultas a la BD
    class Datos extends Conexion{




        //MODELOS PARA LOS USUARIOS
        //Modelo para el inicio de sesion de los usuarios
        public function ingresoUserModel($datosModel, $tabla){
            //Prepara las sentencias de PDO para ejecutar el Qery de validacion de usuario
            $stmt = Conexion::conectar()->prepare("SELECT CONCAT(firstname,' ',lastname) AS 'nombre_usuario, user_name AS  ");
            $stmt->bindParam(":usuario",$datosModel["user"],PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
        }


        //Este modelo sirve para mostrar toda la informacion de los usuarios que existen
        public function vistaUsersModel($tabla){
            //Prepara la sentencia PDO
            $stmt = Conexion::conectar()->prepare("SELECT user_id AS 'id', firstname, lastname, user_name, user_password, user_email, date_added FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
        }

        //Este modelosirve para insertar un nuevo usuario a la BD
        public function insertarUserModel($datosModel, $tabla){
            // Prepara los PDO
            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (firstname, lastname, user_name, user_password, user_email) VALUES (:nusuario,:ausuario,:usuario,:contra,:email)");
            $stmt->bindParam(":nusuario",$datosModel["nusuario"],PDO::PARAM_STR);
            $stmt->bindParam(":ausuario",$datosModel["ausuario"],PDO::PARAM_STR);
            $stmt->bindParam(":usuario",$datosModel["usuario"],PDO::PARAM_STR);
            $stmt->bindParam(":contra",$datosModel["contra"],PDO::PARAM_STR);
            $stmt->bindParam(":email",$datosModel["email"],PDO::PARAM_STR);
            //$stmt->bindParam(":id",$datosModel["id"],PDO::PARAM_STR);
            if($stmt->execute()){
                return "success";
            }else {
                return "error";
            }
            $stmt->close();
        }

        //Este modelo sirve para cargar la informacion del usuario para su posterior modificacion
        public function editarUserModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("SELECT user_id AS 'id', firstname AS 'nusuario', lastname AS 'ausuario', user_name AS 'usuario', user_password AS 'contra', user_email AS 'email' FROM $tabla WHERE user_id=:id");
            $stmt->bindParam(":id",$datosModel,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
        }


        // Sentencia de PDO para ejecutar la actualizaci[on del usuario
        public function actualizarUserModel($datosModel, $tabla){
            //Sentencia de PDO para ejecutar la actualizacion del usuario
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET firstname = :nusuario, lastname = :usuario, user_name = :usuario, user_password = :contra, user_email = :email WHERE user_id = :id");
            $stmt -> bindParam(":nusuario",$datosModel["nusuario"],PDO::PARAM_STR);
            $stmt -> bindParam(":ausuario",$datosModel["ausuario"],PDO::PARAM_STR);
            $stmt -> bindParam(":usuario",$datosModel["usuario"],PDO::PARAM_STR);
            $stmt -> bindParam(":contra",$datosModel["contra"],PDO::PARAM_STR);
            $stmt -> bindParam(":email",$datosModel["email"],PDO::PARAM_STR);
            $stmt -> bindParam(":id",$datosModel["id"],PDO::PARAM_STR);
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
            $stmt->close();
        }

        //Este modelo sirve para eliminar a un usuario de la base de datos
        public function eliminarUserModel($datosModel, $tabla){
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE user_id = :id");
            $stmt->bindParam(":id",$datosModel,PDO::PARAM_INT);
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
            $stmt->close();
        }





        //Este modelo permite eliminar los datos a travez del arreglo anterior que trae el id en el cual en la siguiente sentencia solo elimina a partir del id recibido
        public function eliminarProductsModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_product = :id");
            $stmt->bindParam(":id",$datosModel,PDO::PARAM_INT);
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
            $stmt->close();
        }
        //Este modelo permite recolectar el ultimo id del registro que permite usar para insertar en la tabla de historial los datos necesarios siendo el id del producto uno de ellos
        public function ultimoProductsModel($tabla){
            $stmt = Conexion::conectar()->prepare("SELECT id_product AS 'id' FROM $tabla ORDER BY id_product DESC LIMIT 1");
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
        }
        //MODELOS PARA EL HISTORIAL
        //Recibe la tabla por el parametro y en los select recolectamos los datos que necesita la tabla historial de la vista a partir del PDO
        public function vistaHistorialModel($tabla){
            //......................





        }




        //Este modelo se utiliza para modificar una categoria
        public function actualizarCategoryModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET name_category = :nombre_categoria, description_category = :descripcion_categoria WHERE id_category = :id");
            $stmt->bindParam(":nombre_categoria",$datosModel["nombre_categoria"],PDO::PARAM_STR);
            $stmt->bindParam(":descripcion_categoria",$datosModel["descripcion_categoria"],PDO::PARAM_STR);
            $stmt->bindParam(":id",$datosModel["id"],PDO::PARAM_INT);
            if($stmt->execute()){
                return "success";
            }else{
                return "error";
            }
            $stmt->close();
        }
        //Este modelo se utiliza para eliminar una categoria
        public function eliminarCategoryModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_category = :id");
            $stmt->bindParam(":id",$datosModel,PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
            $stmt->close();
        }
        //MODELOS PARA SELECTS
        //Este modelo permite crear un select y mostrarlo a partir de un select en php dando las categorias y nombres en el formulario
        public function obtenerCategoryModel($tabla){
            $stmt = Conexion::conectar()->prepare("SELECT id_category AS 'id', name_category AS 'categoria' FROM $tabla");
            $stmt->execute();
            return $stmt->fetchAll();
        }
        //MODELO PARA VENTAS
        //Este modelo permite mostrar las ventas realizadas, los detalles de la venta y el insertar una nueva tabla a partir del PDO
        public function vistaVentanasModel($tabla){
            //... ---------------------------------------------------------------------------------------------------
        }






        //Este modelo sirve para insertar un la BD una nueva venta verificando que no exista otra con el mismo folio y guardando el total a pagar de la misma
        public function insertarVentasModel($datosModel,$ta
        ){
            $stmt = Conexion::conectar()->prepare("INSERT INTO (folio,amount) VALUES(:folio,total)");
            $stmt->bindParam(":price",$datosModel["price"],PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
            $stmt->close();
        }
        //Este modelo sirve para asociar los productos a una venta determinada, este modelo solo se usa para las ventas realizadas durante el dia
        public function insertarDetallesVentasModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("INSERT INTO (id_sales,id_product,quantity,price_count) VALUES(:idv,:idp,:cant,:price *:cant)");
            $stmt->bindParam(":idv",$datosModel["idv"],PDO::PARAM_INT);
            $stmt->bindParam(":idp",$datosModel["idp"],PDO::PARAM_INT);
            $stmt->bindParam(":cant",$datosModel["cant"],PDO::PARAM_INT);
            $stmt->bindParam(":price",$datosModel["price"],PDO::PARAM_INT);
            //... ------------------------------------------------------------------------------------------------------------------
            $stmt->close();
        }
        //Este modelo sirve para eliminar toda la venta de la BD
        public function eliminarVentasModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_sales = :id");
            $stmt->bindParam(":id",$datosModel,PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
            $stmt->close();
        }
        //Este modelo sirve para obtener un producto del detalle de la venta y poder...
        public function traerdetallesmodel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("SELECT id_product, quantity FROM $tabla WHERE id_salesp = :id");
            $stmt->bindParam(":id",$datosModel,PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
        }
        //Este modelo se utiliza para traer todos y cada uno de los productos que se tienen en la base de datos con stock superior a 1
        public function traerProductosVentasModel($tabla){
            $stmt = Conexion::conectar()->prepare("SELECT p.id_product AS 'idp', p.code_producto AS 'codigo', p.name_product AS 'producto', p.price_product AS 'precio', p.stock AS 'stock', c.name_category AS 'categoria' FROM $tabla p INNER JOIN categories c ON p.id_category = c.id_category WHERE p.stock > 1 ORDER BY c.id_category");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
        }
        //Este modelo se utiliza para modificar la ganancia de la venta, se utiliza cada qeu se agrega un producto
        public function updateGananciaVentasModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET amount = :total Where id_sales = :id");
            $stmt->bindParam(":total",$datosModel["Total"],PDO::PARAM_INT);
            $stmt->bindParam(":id",$datosModel[":id"],PDO::PARAM_INT);
            if ($stmt->execute()) {
                return "success";
            } else {
                return "error";
            }
            $stmt->close();
        }
        //Este modelo sirve para obtener el stock que se tiene de un determinado producto para saber si debe o no estar disponible para una venta
        public function obtenerStockModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("SELECT stock, price_products AS 'precio' FROM $tabla WHERE id_product = :id");
            $stmt->bindParam(":id",$datosModel["idp"],PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
        }
        //Este modelo sirve para conocer la ganancia total que se tiene de todas las ventas
        public function obtenerGananciasModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("SELECT SUM(price_count) AS 'total' FROM $tabla Where id_sales = :id");
            $stmt->bindParam(":id",$datosModel["id"],PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
        }
        //MODELO PARA EL TABLERO
        /*-- Este modelo permite conocer el numero de filas en determinada tabla, se utiliza para mostrar informacion en el tablero --*/
        public function contarFilasModel($tabla){
            $stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS 'filas' FROM $tabla");
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
        }
        /*-- Este modelo permiteconocer que tanto ha ganado la tienda de acuerdo a todas las ventas que se tienen en la base de datos --*/
        public function sumarGananciaModel($tabla){
            $stmt = Conexion::conectar()->prepare("SELECT SUM(amount) AS 'total' FROM $tabla");
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
        }
        /*-- Este modelo permite conocer cuantos productos existen en la base de datoscon stock superior a 1--*/
        public function obtenerProductsModel($tabla){
            $stmt = Conexion::conectar()->prepare("SELECT id_product AS 'id',name_producto AS cantidad");
        }
    }
?>