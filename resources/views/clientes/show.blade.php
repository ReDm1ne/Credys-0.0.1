<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<h1>Detalles del cliente</h1>

<p>Nombre: {{ $cliente->nombre }}</p>
<p>Apellido Paterno: {{ $cliente->apellido_paterno }}</p>
<p>Apellido Materno: {{ $cliente->apellido_materno }}</p>
<p>Email: {{ $cliente->email }}</p>
<p>Telefono Particular: {{ $cliente->telefono_particular }}</p>
<p>Telefono Celular: {{ $cliente->telefono_celular }}</p>
<p>CURP: {{ $cliente->curp }}</p>
<p>Direccion: {{ $cliente->direccion }}</p>

<a href="{{ route('clientes.index') }}">Volver a la lista de clientes</a>
</html>