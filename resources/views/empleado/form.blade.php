Formulario que tendra los datos en comun con create y edit
<br>
<h1>{{ $modo }} empleado</h1>

@if (count($errors) > 0)

    <div class="alert alert-primary" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif

<div class="form-group">

    <label for="Nombre">Nombre</label>
    <input type="text" class="form-control" name="Nombre"
        value='{{ isset($empleado->Nombre) ? $empleado->Nombre : old('Nombre') }}' id="Nombre"> {{-- Si existe ese valor, imprimelo, de lo contrario, nada. --}}

    <label for="ApellidPaterno">Apellido Paterno</label>
    <input type="text" class="form-control" name="ApellidoPaterno"
        value='{{ isset($empleado->ApellidoPaterno) ? $empleado->ApellidoPaterno : old('ApellidoPaterno') }}' id="ApellidoPaterno">


    <label for="ApellidoMaterno"> Apellido Materno</label>
    <input type="text" class="form-control" name="ApellidoMaterno"
        value='{{ isset($empleado->ApellidoMaterno) ? $empleado->ApellidoMaterno : old('ApellidoMaterno') }}' id="ApellidoMaterno">


    <label for="Correo">Correo</label>
    <input type="text" class="form-control" name="Correo"
        value='{{ isset($empleado->Correo) ? $empleado->Correo : old('Correo') }}' id="Correo">
    <br>

    <label for="Foto"></label>
    @if (isset($empleado->Foto))
        <img class="img-thumbnail img-fluid" src="{{ asset('storage') . '/' . $empleado->Foto }}" width="150px"
            alt="">
    @endif
    <br>
    <input type="file" name="Foto" value='{{ isset($empleado->Foto) ? $empleado->Foto : '' }}' id="Foto">


</div>
<input class="btn btn-success" type="submit" value="{{ $modo }} datos">


<a href="{{ route('empleado.index') }}" class="btn btn-primary">Regresar</a>
