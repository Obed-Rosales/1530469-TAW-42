<?php
    // Clase para establecer la conexion a la BD mediante PDO
    class Conexion{
        // Método/función que sirve para conectarse a la base de datos y realizar las consultas
        public function conectar(){
            $enlase = new PDO ("mysql:host=localhost;dbname=simple_stock","obed","obed");
            return $enlase;
        }
        
    }

?>