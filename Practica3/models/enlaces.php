<?php  
	class EnlacesPaginas{		
		public function enlacesPaginasModel($enlacesModel){
			$module = null;
			if($enlacesModel == "ingresar" || $enlacesModel == "usuarios" || $enlacesModel == "inventario" || $enlacesModel == "categorias" || $enlacesModel == "categorias" || $enlacesModel == "tablero" || $enlacesModel == "ventas" || $enlacesModel == "salir"){
				$module = "views/modules/".$enlacesModel.".php";
			}else if($enlacesModel == "tableros"){
				$module = "views/modules/tablero.php";
			}else if($enlacesModel == "index"){
				$module = "views/modules/tablero.php";
			}else if($enlacesModel == "fallo"){
				$module = "views/modules/fallo.php";
			}
			return $module;
		}
	}
?>