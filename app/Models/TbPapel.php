<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbPapel extends Model 
{

    protected $table = 'tb_papel';
    public $timestamps = false;

    public function permissoes()
    {
        return $this->belongsToMany('App/Models\TaPapelPermissao', 'permissao_id');
    }

    public function modelPapeis()
    {
        return $this->belongsToMany('App/Models\TaModelPapeis', 'papel_id');
    }

}