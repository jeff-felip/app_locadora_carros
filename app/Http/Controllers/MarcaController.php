<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  response()->json($this->marca->all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->marca->rules(), $this->marca->feedback());

        $marca = $this->marca->create($request->all());
        return response()->json($marca, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if( $this->marca->find($id) === null){
           return response()->json(["Erro" => "marca não encontrada!"], 404);
        }
        return response()->json($this->marca->find($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(["Erro" => "Impossivel atualizar! Marca não encontrada."], 404);
        }

        //atualização de parte dos campos
        if($request->method() === "PATCH"){

            $regrasDinamicas = array();
            //guarda apenas as regras relacionadas aos campos passados
            foreach ($marca->rules() as $key => $value) {
                if(array_key_exists($key, $request->all())){
                    $regrasDinamicas[$key] = $value;
                }
            }
            //valida usando apenas as regras guardadas
            $request->validate($regrasDinamicas, $marca->feedback());
        }else{
            $request->validate($marca->rules(), $marca->feedback());
        }

        $marca->update($request->all());
        return response()->json($marca, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->marca->find($id) === null){
            return response()->json(["Erro" => "Impossivel deletar! Marca não encontrada."], 404);
        }
        return response()->json($this->marca->find($id)->delete(), 200);

    }
}
