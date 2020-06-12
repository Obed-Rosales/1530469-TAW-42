<div class="login-box container">
	<div class="login-logo">
		<a href="index.php"><b>Sistema de </b> Inventarios</a>
	</div>
	<!--/.login-logo-->
	<div class="card">
		<div class="card-body login-card-body">
			<p class="login-box-nsg">Login</p>
			<form method="POST">
				<div class="input-group mb-3">
					<input type="text" name="txtUser" class="form-control" placeholder="Username">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
				</div>
				<div class="input-group mb-3">
					<input type="text" name="txtPassword" class="form-control" placeholder="Password">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<!--/.cot-->
					<div class="col-12">
						<button class="btn tn-primary btn-block btn-flat" type="submit">Iniciar Sesión</button>
					</div>
					<!--/.cot-->
				</div>
			</form>
		</div>
		<!--/.login-card-body-->
	</div>
</div>

<!--/.Llamada al controlador que verifica el inicio de sesión-->
<?php  

	$ingreso = new MvcController();
	$ingreso -> ingresoUsuarioController();
	//Se verifica si existe alguna falla al iniciar sesión y se le notifica al usuario
	if (isset($_GET["res"])) {
		if ($_GET["res"] == "fallo") {
			echo "Falla al ingresar";
		}
	}

	//Se verifica que se haya cerrado la sesión actual
	if (isset($_GET["salir"])) {
		if ($_GET["salir"] == "1") {
			echo "Ha cerrado sesión exitosamente";
		}
	}
?>