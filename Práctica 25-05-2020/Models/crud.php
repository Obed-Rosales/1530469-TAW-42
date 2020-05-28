<?php
    //Llamada a la conexion
    include "conexion.php"
    //Clase que servira para realizar las consultas a la BD
    class Datos extends Conexion{




        //MODELOS PARA LOS USUARIOS
        //Modelo para el inicio de sesion de los usuarios
        public function ingresoUsuarioModel($datosModel, $tabla){
            //Prepara las sentencias de PDO para ejecutar el Qery de validacion de usuario
            $stmt = Conexion::conectar()->prepare("SELECT user_id AS ");
        }


        //Este modelo sirve para mostrar toda la informacion de los usuarios que existen
        public function vistaUsersModel($tabla){
            //Prepara la sentencia PDO
            $stmt = Conexion::conectar()->prepare("SELECT user_id AS 'id', firstname, lastname, user_name, user_password, user_email, date_added FROM $tabla");
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
            if($stmt->execute()){
                return "success";
            }else {
                return "error";
            }
            $stmt->close();
        }

        //Este modelo sirve para cargar la informacion del usuario para su posterior modificacion
        public function editarUserModel($datosModel,$tabla){

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
    }
?>