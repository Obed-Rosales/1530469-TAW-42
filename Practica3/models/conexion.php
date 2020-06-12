<?php 	
	class Conexion{ //Crea la clase para realizar la conexión con la base de datos	
		function conectar(){ //Crea la función que permite conectar con la base de datos
			//$link = new PDO ("mysql:host=localhost;dbname=inventario","cecii", "CeciiVictoria98p"); //Crea un objeto de conexión el cual almacena el host, el nombre de la bd, el usuario y contraseña.
			$link = new PDO ("mysql:host=localhost;dbname=inventario","obed", "obed");
			return $link; //Regresa el objeto creado para la conexión.
		} //Termina la función conectar.
	} //Termina la clase Conexión.
?>