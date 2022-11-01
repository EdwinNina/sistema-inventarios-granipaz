<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\SubCategoria;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return view('pages.categorias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = $request->validate([ 'nombre' => 'required' ]);

        try {
            $categoria = Categoria::create([
                'nombre' => $validation['nombre'],
                'descripcion' => $request['descripcion']
            ]);
            $a_subcategorias = [];

            if(isset($request['sub_categorias'])){
                foreach ($request['sub_categorias'] as $value) {
                    $a_subcategorias[] = [
                        'nombre' => $value['nombre'],
                        'descripcion' => $value['descripcion'],
                        'categoria_id' => $categoria->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
                SubCategoria::insert($a_subcategorias);
            }
            return redirect()->route('categorias.index')
                ->with(['estado' => 'exito', 'mensajeExito' => 'Categoria creada correctamente']);
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->route('categorias.index')->with(['estado' => 'error', 'mensajeError' => $ex]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        return view('pages.categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        $validation = $request->validate([ 'nombre' => 'required' ]);

        try {
            Categoria::where('id', $categoria->id)->update([
                'nombre' => $validation['nombre'],
                'descripcion' => $request['descripcion']
            ]);

            if(isset($request['sub_categorias'])){
                foreach ($request['sub_categorias'] as $value) {
                    SubCategoria::where('id', $value['id'])->update([
                        'nombre' => $value['nombre'],
                        'descripcion' => $value['descripcion'],
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
            return redirect()->route('categorias.index')
                ->with(['estado' => 'exito', 'mensajeExito' => 'Categoria actualizada correctamente']);
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->route('categorias.index')->with(['estado' => 'error', 'mensajeError' => $ex]);
        }
    }
}
