<?php

namespace App\Repositories;
use illuminate\Database\Eloquent\Model;

class ModeloRepository{

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function selectAtributosRegistrosRelacionados($atributos_marca){
        $this->model = $this->model->with($atributos_marca);
    }

    public function filtros($filtros){
        $filtro = explode(';', $filtros);
            foreach ($filtro as $key => $condicoes) {
                $c = explode(':', $condicoes);
                $this->model = $this->model->where($c[0], $c[1], $c[2]);
            }
    }

    public function selectAtributos($atributos){
        $this->model = $this->model->selectRaw($atributos);
    }

    public function getRegistros(){
        return $this->model->get();
    }



}
