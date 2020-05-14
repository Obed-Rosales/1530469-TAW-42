<?php
    require_once "conexion.php";
    

    // Heredar la clase conexion.php para poder accesar y utilizar la conexion a la base de datos, se extiende cuando se requiere manipupal una funcion o método, en este caso manipularemos la función "conectar" de models/conexion.php
    class Datos extends Conexion{

        //REGISTRO DE USUARIOS
        public function registroUsuariosModel ($datosModel, $tabla){
            //Prepare() Prepara la sentencia de SQL para que sea ejecutada por el método postStatement. La sentencia de SQL se puede contener desde 0 para ejecutar más parámetros.

            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario, password, email) VALUES (:usuario,:password,:email)");

            //binParam() vincula una variable de PHP a un parametro de sustitución con nombre correspondiente a la sentencia SQL que fue usada para preparar la sentencia

            $stmt->bindParam(":usuario", $datosModel["usuario"], PDO::PARAM_STR);
            $stmt->bindParam(":password", $datosModel["password"], PDO::PARAM_STR);
            $stmt->bindParam(":email", $datosModel["email"], PDO::PARAM_STR);

            //regresa una respuesta satisfactoria o no

            if ($stmt->execute()) {
                return "success";
            }else {
                return "error";
            }

            $stmt->close();

        }

        //Modelo ingresoUsuarioModel
        public function ingresoUsuarioModel($datosModel,$tabla){
            $stmt = Conexion::conectar()->prepare("SELECT usuario, password FROM $tabla WHERE usuario= :usuario");
            $stmt->bindParam(":usuario",$datosModel["usuario"],PDO::PARAM_STR);
            $stmt->execute();
            //tetch() obtiene una fila de un conjunto de resultados asociado al objetivo $stmt
            return $stmt->fetch();

            $stmt->close();
        }

        //Vista de usuarios
        public function vistaUsuarioModel(){

        }

        //Modelo editarUsuarioModel
        public function editarUsuarioModel(){

        }

        //Modelo actualizarUsuarioModel
        public function actualizarUsuarioModel(){

        }

        //Modelo borrarUsuarioModel
        public function borrarUsuarioModel(){

        }

    }
?>