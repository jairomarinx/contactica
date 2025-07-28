<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'email'  => ['required', 'string', 'email', 'max:100'],
        ]);

        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->save();

        return response()->json(['Msg'=>'Success', 'usuario' => $usuario],200);

    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email'  => ['required', 'string', 'email', 'max:100'],
        ]);

        $usuario = Usuario::where('id',$id)->first();
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->save();

        return response()->json(['Msg'=>'Success', 'usuario' => $usuario],200);

    }

    public function show(Request $request, $id)
    {
        $usuario = Usuario::where('id',$id)->first();

        return response()->json(['Msg'=>'Success', 'usuario' => $usuario],200);

    }

    public function list(Request $request)
    {
        $usuarios = Usuario::get();

        return response()->json(['Msg' =>'Success', 'usuarios' => $usuarios],200);
    }

    public function delete(Request $request, $id)
    {
        $usuario = Usuario::where('id',$id)->first();

        if ($usuario)
        {
            $usuario->delete();
        }

        return response()->json(['usuario' => $usuario], 200);
    }

    public function dashboard()
    {
        return view('dashboard');
    }











}
