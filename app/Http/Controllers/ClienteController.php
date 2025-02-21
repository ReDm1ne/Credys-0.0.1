<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        if ($user->hasRole('admin')) {
            $clientes = Cliente::with('user')->get();
        } else {
            $clientes = Cliente::where('sucursal_id', $user->sucursal_id)
                                ->where('user_id', $user->id)
                                ->get();
        }
    
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(StoreClienteRequest $request)
    {
        $user = auth()->user();
        $validatedData = $request->validated();
        
        $cliente = new Cliente($validatedData);
        $cliente->user_id = $user->id;
        $cliente->sucursal_id = $user->sucursal_id;

        if ($request->hasFile('identificacion')) {
            $path = $request->file('identificacion')->store('identificaciones', 'public');
            $cliente->identificacion = basename($path);
        }

        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function show($id)
    {
        $cliente = Cliente::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->where('sucursal_id', auth()->user()->sucursal_id)
                          ->firstOrFail();
        return view('clientes.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Cliente::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->where('sucursal_id', auth()->user()->sucursal_id)
                          ->firstOrFail();
        return view('clientes.edit', compact('cliente'));
    }

    public function update(UpdateClienteRequest $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $validatedData = $request->validated();

        $cliente->fill($validatedData);

        if ($request->hasFile('identificacion')) {
            if ($cliente->identificacion) {
                Storage::disk('public')->delete('identificaciones/' . $cliente->identificacion);
            }
            $path = $request->file('identificacion')->store('identificaciones', 'public');
            $cliente->identificacion = basename($path);
        }

        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $cliente = Cliente::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->where('sucursal_id', auth()->user()->sucursal_id)
                          ->firstOrFail();
    
        if ($cliente->identificacion) {
            Storage::disk('public')->delete('identificaciones/' . $cliente->identificacion);
        }
    
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
    }
}