<?php  
    class EnlacesPaginas{
        /*-- Método/funcion para sellecionar la vista correcta dependiendo de la oppción --*/
        public function enlacesPaginasModel($enlacesModel){
            if ($enlacesModel == "ingresar" || $enlacesModel == "usuarios") {
                $module = "Views/modules/".$enlacesModel.".php";
            }else if ($enlacesModel == "index") {
                $module = "Views/modules/tablero.php";
            }else {
                $module = "Views/modules/tablero.php";
            }
            return $module;
        }
    }
?>

