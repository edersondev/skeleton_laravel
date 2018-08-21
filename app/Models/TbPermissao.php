<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbPermissao extends Model 
{

    protected $table = 'tb_permissao';
    public $timestamps = false;

    public function papeis()
    {
        return $this->belongsToMany('App/Models\TaPapelPermissao', 'papel_id');
    }

    public function modelPermissoes()
    {
        return $this->belongsToMany('App/Models\TaModelPermissoes', 'permissao_id');
    }

}