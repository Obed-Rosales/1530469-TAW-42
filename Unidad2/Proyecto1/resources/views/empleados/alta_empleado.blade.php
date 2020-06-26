@extends('layout.patron');
@section ('titulo', 'Agregar de empleado');
@section ('contenido')
    <div class="righ_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3> Agregar empleado</h3>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>  
            <div class="x_panel">
                <div class="x_title">
                    <h2>Datos de empleados</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <form action="{{ url('/empleados')}}" enctype="multipart/form-data" method="POST" data-parsley-validate class="form-horizontal form-label-left">
                    {{csrf_field()}}
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nombre"> Nombre(s) <spam class="required">*</spam>
                        </label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" id="nombre" name="nombre" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="apellidos"> Apellido(s) <spam class="required">*</spam>
                        </label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" id="apellidos" name="apellidos" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="cedula"> Cédula <spam class="required">*</spam>
                        </label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" id="cedula" name="cedula" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="email"> Correo electrónico <spam class="required">*</spam>
                        </label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" id="email" name="email" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="lugar_nacimiento"> Lugar de nacimiento <spam class="required">*</spam>
                        </label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" id="lugar_nacimiento" name="lugar_nacimiento" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="lugar_nacimiento"> Lugar de nacimiento <spam class="required">*</spam>
                        </label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" id="lugar_nacimiento" name="lugar_nacimiento" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" >Sexo</label>
                            <div class="col-md-6 col-sm-6 ">
                                <div id="sexo" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-secondary" data-toggle-class="btn-primary" for="sexo" data-toggle-passive-class="btn-default">
                                        <input type="radio" value="0" name="sexo" id="masculino" class=""> &nbsp; Masculino &nbsp;
                                    </label>
                                    <label class="btn btn-primary" data-toggle-class="btn-primary" for="sexo" data-toggle-passive-class="btn-default">
                                        <input type="radio" value="0" name="sexo" id="femenino"  class=""> Femenino
                                    </label>
                                    <label class="btn btn-primary" data-toggle-class="btn-primary" for="sexo" data-toggle-passive-class="btn-default">
                                        <input type="radio" value="0" name="sexo" id="no-definido"  class=""> No definido
                                    </label>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" >Estado civil</label>
                            <div class="col-md-6 col-sm-6 ">
                                <div id="estado_civil" class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-secondary" data-toggle-class="btn-primary" for="estado_civil" data-toggle-passive-class="btn-default">
                                        <input type="radio" value="0" name="estado_civil" id="soltero" class=""> &nbsp; Soltero &nbsp;
                                    </label>
                                    <label class="btn btn-primary" data-toggle-class="btn-primary" for="estado_civil" data-toggle-passive-class="btn-default">
                                        <input type="radio" value="0" name="estado_civil" id="casado"  class=""> Casado
                                    </label>
                                    <label class="btn btn-primary" data-toggle-class="btn-primary" for="estado_civil" data-toggle-passive-class="btn-default">
                                        <input type="radio" value="0" name="estado_civil" id="no-definido"  class=""> No definido
                                    </label>
                                </div>
                            </div>
                        </label>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="telefono"> Teléfono <spam class="required">*</spam>
                        </label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" id="telefono" name="telefono" required="required" class="form-control">
                        </div>
                    </div>
                    <div class="In_solid"></div>
                    <div class="Item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-3">
                            <button class="btn btn-primary" type="button">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection