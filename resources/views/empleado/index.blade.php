@extends('layouts.app')

@section('content')
    <div class="container">
    
            @if (Session::has('mensaje'))
            <div class="alert alert-success" role="alert">
           {{ Session::get('mensaje') }}
    </div>

        @endif


        <a href="{{ route('empleado.create') }}" class="btn btn-success">Nuevo empleado</a>
        <br>
        <br>
        <table class="table table-light">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($empleados as $empleado)
                    {{-- Viene del controlador, metodo index --}}
                    <tr>
                        <td>
                            {{ $empleado->id }}
                        </td>
                        <td>
                            <img class="img-thumbnail img-fluid" src="{{ asset('storage') . '/' . $empleado->Foto }}"
                                width="100px" alt="">
                        </td>

                        <td>{{ $empleado->Nombre }}</td>
                        <td>{{ $empleado->ApellidoPaterno }}</td>
                        <td>{{ $empleado->ApellidoMaterno }}</td>
                        <td>{{ $empleado->Correo }}</td>
                        <td>

                            <a href="{{ url('/empleado', $empleado->id . '/edit') }}" class="btn btn-warning">
                                Editar

                            </a>

                            <form action="{{ url('/empleado', $empleado->id) }}" class="d-inline" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="submit" class="btn btn-danger"
                                    onclick="return confirm('Eliminar este registro?')" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if (session('success'))
                    <p>{{ session('success') }}</p>
                @endif
            </tbody>
        </table>
        {!! $empleados->links() !!}
    </div>
@endsection
