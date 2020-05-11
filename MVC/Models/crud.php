<?php
    require_once "conexion.php";
    

    // Heredar la clase conexion.php para poder accesar y utilizar la conexion a la base de datos, se extiende cuando se requiere manipupal una funcion o método, en este caso manipularemos la función "conectar" de models/conexion.php
    class Datos extends Conexion{

        //REGISTRO DE USUARIOS
        public function registroUsuariosModel ($datosModel, $tabla){
            //Prepare() Prepara la sentencia de SQL para que sea ejecutada por el método postStatement. La sentencia de SQL se puede contener desde 0 para ejecutar más parámetros.

            $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (usuario, password, email) VALUES (:usuario,:password,:email)");

            //binParam() vincula una variable de PHP a un parametro de sustitución con nombre correspondiente a la sentencia SQL que fue usada para preparar la sentencia

            $stmt->bindParam(":usuario", $datosModel["usuario"], POO::PARAM_STR);
            $stmt->bindParam(":password", $datosModel["password"], POO::PARAM_STR);
            $stmt->bindParam(":email", $datosModel["email"], POO::PARAM_STR);

            //regresa una respuesta satisfactoria o no

            if ($stmt->execute()) {
                return "success";
            }else {
                return "error";
            }

            $stmt->close();

        }
    }
?>