<?php
    class Conexion{
        public function conectar(){
            $link = new PDO ("mysql:host=localhost;dbname=BaseDatos","root","root");
            return $link;
        }
        
    }

?>