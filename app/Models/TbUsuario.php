<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class TbUsuario extends Authenticatable 
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    protected $table = 'tb_usuario';
    
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'dt_inclusao';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'dt_atualizacao';

    /**
     * The name of the "deleted at" column.
     *
     * @var string
     */
    const DELETED_AT = 'dt_exclusao';

    public function papeis()
    {
        return $this->hasMany('App/Models\TaModelPapeis', 'usuario_id');
    }

    public function permissoes()
    {
        return $this->hasMany('App/Models\TaModelPermissoes', 'permissao_id');
    }

}