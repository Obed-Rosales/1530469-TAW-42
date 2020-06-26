<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empleado;
use DB;

class empleadosController extends Controller
{
    public function index(){
        //Obtener todos los empleados de la tabla de la bd
        $empleados=Empleado::all();
        //Mostrar vista de la consulta de empleados
        return view('empleados.admin_empleados',compact('empleados'));
    }

    //Controlador para crear nuevo empleado
    public function create(){
        //Mostrar el formulario para crear empleado
        return view('empleados.alta_empleado',compact('empleados'));
    }

    //Controldor para almacenar empleados
    public function store(Request $request){
        //Retirar los datos del request
        $datosEmpleado=request()->except('empleado');

        //Insertar en la tabla empleado los datos para la creacion de un nuevo registro
        $id=DB::table('empleados')->insertGetId($datosEmpleado);
        Alert::success('Datos guardados con exito');
        return redirect('empleados');
    }

    //Controlador para editar Empleados
    public function edit($id){
        //Editar empleados y mandar a la vista la informacion
        $empleados=Empleado::findOrFail($id);

        //Mostrar la vista
        return view('empleados.editar_empleado',compact('empleado'));
    }

    //Controlador para eliminar empleado
    public function destroy($id){
        Alert::success('Datos eliminados de la base de datos');
        return redirect ('empleados');
    }
    

}
