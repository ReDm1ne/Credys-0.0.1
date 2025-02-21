<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Editar Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button[type="submit"] {
            width: 100%;
            height: 40px;
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <h1>Editar cliente</h1>
    <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="{{ $cliente->nombre }}" required>
        <label for="apellido_paterno">Apellido Paterno:</label>
        <input type="text" id="apellido_paterno" name="apellido_paterno" value="{{ $cliente->apellido_paterno }}" required>
        <label for="apellido_materno">Apellido Materno:</label>
        <input type="text" id="apellido_materno" name="apellido_materno" value="{{ $cliente->apellido_materno }}" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $cliente->email }}" required>
        <label for="telefono_particular">Telefono Particular:</label>
        <input type="text" id="telefono_particular" name="telefono_particular" value="{{ $cliente->telefono_particular }}" required>
        <label for="telefono_celular">Teléfono Celular:</label>
        <input type="text" id="telefono_celular" name="telefono_celular" value="{{ $cliente->telefono_celular }}" required>
        <label for="curp">CURP:</label>
        <input type="text" id="curp" name="curp" value="{{ $cliente->curp }}" required>
        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion" name="direccion" value="{{ $cliente->direccion }}" required>
        <label for="identificacion">Identificacion:</label>
        <input type="file" name="identificacion" accept="image/jpeg, image/png">
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>