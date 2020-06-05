<?php 
	//Se verifica que exista una sesión, en caso de que no sea así, se muestra el login
	if(!isset($_SESSION['validar'])){
		header("location:index.php?action=ingresar");
		exit();
	}

	//Llamada a los controladores para insertar/modificar/eliminar categorías
	$categorias = new MvcController();
	$categorias->insertarCategoryController();
	$categorias->actualizarCategoryController();
	$categorias->eliminarCategoryController();

	//Se verifica que el usuario haya pulsado sobre el botón registrar o editar para mostrarle su respectivo formulario
	if (isset($_GET['registrar'])) {
		$categorias->registrarCategoryController();
	} else if(isset($_GET['idCategoryEditar'])){
		$categorias->editarCategoryController();
	}
?>

<div class="container-fluid">
	<div class="row mb-3">
		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title">Categoría</h3>
			</div>
			<div class="card-body">
				<div class="row mb-4">
					<div class="col-sm-6"s>
						<a href="index.php?action=categorias&registrar" class="btn btn-info">Agregar Nueva Categoria</a>
					</div>
				</div>
				<div id="example2-wrapper" class="dataTables_wrapper dt-bootstrap4">
					<div class="row">
						<div class="col-sm-12">
							<table id="example1" class="table table-striped display">
								<thead class="table-primary">
									<tr>
										<th>¿Editar?</th>
										<th>¿Eliminar</th>
										<th>ID</th>
										<th>Nombre</th>
										<th>Descripción</th>
										<th>Fecha de inserción</th>
									</tr>
								</thead>
								<tbody>
									<?php
									//Se llama al controlador que muestra todas las categorías que existen
										$categorias->vistaCategoriasController(); 
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> <!--/.container-fluid-->