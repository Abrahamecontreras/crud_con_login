<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Consulta toda la info a partir del Modelo, toma 5 registros y los almacena en la var empleados
        $datos['empleados'] = Empleado::paginate(3);
        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $campos = [
            'Nombre'          => 'required|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo'          => 'required|email',
            'Foto'            => 'required|max:10000|mimes:jpeg,jpg,jfif,png'
        ];
        $mensaje = [
            'required' => 'El :attribute es requerido',
            'Foto.required' => 'La foto es requerida'

        ];

        $this->validate($request, $campos, $mensaje);

        //$datosEmpleado = request()->all();
        $datosEmpleado = request()->except('_token'); //Recupera todo menos el token

        if ($request->hasFile('Foto')) { //Si hay un archivo en el campo Foto
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public'); //Toma ese campo y lo almacena en la carpeta public/uploads
        }

        Empleado::insert($datosEmpleado); //Toma el modelo e inserta en la DB
        //return response()->json($datosEmpleado);
        return redirect()
            ->route('empleado.index')
            ->with('success', 'Empleado agregado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos = [
            'Nombre'          => 'required|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo'          => 'required|email',
        ];
        $mensaje = [
            'required' => 'El :attribute es requerido'
        ];

        if ($request->hasFile('Foto')) {
            $campos = ['Foto' => 'required|max:10000|mimes:jpeg,jpg,png'];
            $mensaje = ['Foto.required' => 'La foto es requerida'];
        }

        $this->validate($request, $campos, $mensaje);
            
        $datosEmpleado = request()->except('_token', '_method'); //recepcion de datos

        if ($request->hasFile('Foto')) { //Si hay un archivo en el campo Foto
            $empleado = Empleado::findOrFail($id); //Busca de nuevo la info con el id

            Storage::delete('public/' . $empleado->Foto); // a partir del stringde la foto, concatena para obtener ruta y elimina

            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public'); //Toma la nueva foto y la almacena en la carpeta public/uploads
        }

        Empleado::where('id', '=', $id)->update($datosEmpleado); //Busca reg con el id que llega para luego hacer la update
        $empleado = Empleado::findOrFail($id); //Busca de nuevo la info con el id
        //return view('empleado.edit', compact('empleado')); //retorna nuevamente al formulario pero con los datos editados

        return redirect()
        ->route('empleado.index')
        ->with('success', 'Empleado modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id); //Busca de nuevo la info con el id
        if (Storage::delete('public/' . $empleado->Foto)) {
            Empleado::destroy($id);
        }


        return redirect()
            ->route('empleado.index')
            ->with('success', 'Empleado eliminado');
    }
}
