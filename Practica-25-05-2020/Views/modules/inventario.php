<?php 
	//Se verifica que exxista una sesión, en caso de que no sea asi se muestra el login.
	if(!isset($_SESION['validar'])){
		header("location:index.php?action=ingresar");
	}

	//Llamada a los controladores para insertar/modificar/eliminar produtos y su stock
	$inventario = new MvcController();
	$inventario -> insertarProductController();
	$inventario -> actualizarProductController();
	$inventario -> actualizar1StockController();
	$inventario -> actualizar2StockController();
	$inventario -> eliminarProductController();

	//Se verifica que el usuario haya pulsado sobre el botón de registrar o editar para mostrarle su respectivo formulario
	if(isset($_GET['registrar'])){
		$inventario->registrarProductController();
	}else if(isset($_GET['idProductEditar'])){
		$inventario->editarProductController();
	}else if(isset($_GET['idProductAdd'])){
		$inventario->addProductController();
	}else if(isset($_GET['idProductDel'])){
		$inventario->delProductController();
	}
?>

<div class="card card-secondary">
	<div class="card-header">
		<h3 class="card-title">Inventario</h3>
	</div>
	<div class="card-body">
		<div class="row mb-4">
			<div class="col-sm-6">
				<a href="index.php?action=inventario&registrar" class="btn btn-info">Agregar Nuevo Producto</a>
			</div>
		</div>
		<div class="dataTables_wrapper dt-bootstrap4">
			<div class="row">
				<div class="col-sm-12">
					<table id="example1" class="table table-bordered table-striped">
						<thead class="table-success">
							<tr>
								<th>¿Editar?</th>
								<th>Eliminar?</th>
								<th>ID</th>
								<th>Código del producto</th>
								<th>Nombre del producto</th>
								<th>Precio</th>
								<th>Stock</th>
								<th>Categoría</th>
								<th>¿Añadir al stock?</th>
								<th>¿Eliminar del stock?</th>
							</tr>	
						</thead>
						<tbody>
							<?php 
								//Se llama  al controlador que muestra todas las categorías que existen
							$inventario->vistaProductsController();
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div> <!--/.container-fluid-->

<?php 
	$historial = new MvcController();
?>

<div class="container-fluid">
	<div class="row mb-3">
		<div class="card card-secondary">
			<div class="card-header">
				<h3 class="card-title">Historial</h3>
			</div>
			<div class="card-body">
				<div id="example2-wrapper" class="dataTables_wrapper dt-botstrap4">
					<div class="row">
						<div class="col-sm-12">
							<table id="example2" class="table table-bordered table-striped">
								<thead class="table-dark">
									<tr>
										<th>Usuario</th>
										<th>Producto</th>
										<th>Nota</th>
										<th>Cantidad</th>
										<th>Referencia</th>
										<th>Fecha de inserción</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$historial->vistaHistorialController();  
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 text-center">
		<ul class="pagination pagination-sm pager" id="historial_page"></ul>
	</div>
</div> <!--/.container-fluid-->