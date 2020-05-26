<?php
    class MvcController{

        public function ingresoUsuarioController(){
            if (isset($_POST["txtUser"]) && isset($_POST["txtPassword"])) {
                $datosController=array ("user" => $_POST["txtUser"], "password" => $_POST["txtPassword"]);
                $respuesta = Datos::ingresoUsuarioModel($datosController, "users");
    
                //Validar la respuesta del modelo para ver si es un usuario correcto
                if($respuesta["usuario"]== $_POST["txtUser"] && password_verify($_POST["passwordIngreso"], $respuesta['contrasena'])){
                    session_start();
                    $SESSION["validar"] = true;
                    header("location:index.php?action=usuarios");
                }else{
                    header("location:index.php?action=fallo");
                }
            }
        }




        //VISTA DE USUARIOS
    public function vistaUsuariosController(){
        $respuesta = Datos::vistaUsuarioModel("users");
        //Utilizar un foreach para iterar un array e imprimir la consulta del modelo
        foreach($respuesta as $row => $item){
            echo'
                <tr>
                <td><a href="index.php?action=editar&id='.$item["id"].'"><button>Editar</button></a></td>
                    <td>'.$item["usuario"].'</td>
                    <td>'.$item["password"].'</td>
                    <td>'.$item["email"].'</td>
                    
                    <td><a href="index.php?action=usuarios&idBorrar='.$item["id"].'"><button>Borrar</button></a></td>
                </tr>';
        }
    }

    



    }
?>