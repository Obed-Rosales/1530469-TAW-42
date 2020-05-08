<?php
    class MvcController{
        #Llamada a la plantilla
        public function pagina(){
            include"views/template.php";
        }

        //Enlaces
        public function enlacesPaginasController(){
            if(isset($_GET['action'])){
                $enlases = $_GET['action'];
            }
            else{
                $enlaces = 'index';
            }
            //Es el momento en que el controlador invoca al modelo 
            //llamado enlacesPaginasModel para que muestre el listado de paginas
            $respuesta = Paginas::enlacesPaginasModel($enlaces);
            include $respuesta;
        }
    
    //Registro de usuarios
    public function registroUsuarioController(){
        if (isset($_POST["usuarioRegistro"])) {
            //Recibe a traves del metodo post el name (HTML) de usuario,
            //pasword e Email, se almacenan los datos en una variable o 
            //propiedad de tipo asociativo con sus respectivas propiedades
            //(usuario,password,email).
            $datosController = array("usuario"=>$_POST["usuarioRegistro"],"password"=>$_POST["passwordRegistro"],"email"=>$_POST["emailRegistro"]);
            // se dice al modelo models/crud.php (Datos::registroUsuarioModel),
            //que en modelo Datos el metodo registroUsuariosModel recibe en sus 
            //parametros los valores $datosController y el nombre de la tabla a
            //la cualdebe conectarse (usuarios)
            $respuesta = Datos::registroUsuariosModel($datosController,"usuarios");

            //Se imprime la respuesta en la vista 
            if ($respuesta == "success") {
                header("location:index.php?action=ok");
            }
            else {
                header("location:index.php");
            }
        }
    }
}

?>