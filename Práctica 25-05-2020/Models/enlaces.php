<?php  
    class EnlacesPaginas{
        /*-- Método/funcion para sellecionar la vista correcta dependiendo de la oppción --*/
        public function enlacesPaginasModel($enlacesModel){
            if ($enlacesModel == "ingresar" || $enlacesModel == "usuarios") {
                $module = "views/modules/".$enlacesModel.".php";
            }else if ($enlacesModel == "index") {
                $module = "views/modules/tablero.php";
            }else {
                $module = "views/modules/tablero.php";
            }
            return $module;
        }
    }
?>

