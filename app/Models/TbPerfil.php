<?php

namespace App\Models;

use Spatie\Permission\Guard;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Exceptions\GuardDoesNotMatch;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Traits\RefreshesPermissionCache;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TbPerfil extends Model implements RoleContract
{
    use HasPermissions;
    use RefreshesPermissionCache;

    protected $table = 'tb_perfil';
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'co_seq_perfil';
    
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

    public $guarded = ['co_seq_perfil'];

    public function __construct(array $attributes = [])
    {
        $attributes['ds_nome_guard'] = $attributes['ds_nome_guard'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);

        $this->setTable(config('permission.table_names.roles'));
    }

    public static function create(array $attributes = [])
    {
        $attributes['ds_nome_guard'] = $attributes['ds_nome_guard'] ?? Guard::getDefaultName(static::class);

        if (static::where('ds_nome', $attributes['ds_nome'])->where('ds_nome_guard', $attributes['ds_nome_guard'])->first()) {
            throw RoleAlreadyExists::create($attributes['ds_nome'], $attributes['ds_nome_guard']);
        }

        if (isNotLumen() && app()::VERSION < '5.4') {
            return parent::create($attributes);
        }

        return static::query()->create($attributes);
    }

    /**
     * A role may be given various permissions.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions')
        );
    }

    /**
     * A role belongs to some users of the model associated with its guard.
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            getModelForGuard($this->attributes['ds_nome_guard']),
            'model',
            config('permission.table_names.model_has_roles'),
            'co_perfil',
            'co_usuario'
        );
    }

    /**
     * Find a role by its name and guard name.
     *
     * @param string $name
     * @param string|null $guardName
     *
     * @return \Spatie\Permission\Contracts\Role|\Spatie\Permission\Models\Role
     *
     * @throws \Spatie\Permission\Exceptions\RoleDoesNotExist
     */
    public static function findByName(string $name, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('ds_nome', $name)->where('ds_nome_guard', $guardName)->first();

        if (! $role) {
            throw RoleDoesNotExist::named($name);
        }

        return $role;
    }

    public static function findById(int $id, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('co_seq_perfil', $id)->where('ds_nome_guard', $guardName)->first();

        if (! $role) {
            throw RoleDoesNotExist::withId($id);
        }

        return $role;
    }

    /**
     * Find or create role by its name (and optionally guardName).
     *
     * @param string $name
     * @param string|null $guardName
     *
     * @return \Spatie\Permission\Contracts\Role
     */
    public static function findOrCreate(string $name, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('ds_nome', $name)->where('ds_nome_guard', $guardName)->first();

        if (! $role) {
            return static::create(['ds_nome' => $name, 'ds_nome_guard' => $guardName]);
        }

        return $role;
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param string|Permission $permission
     *
     * @return bool
     *
     * @throws \Spatie\Permission\Exceptions\GuardDoesNotMatch
     */
    public function hasPermissionTo($permission): bool
    {
        if (is_string($permission)) {
            $permission = app(Permission::class)->findByName($permission, $this->getDefaultGuardName());
        }

        if (is_int($permission)) {
            $permission = app(Permission::class)->findById($permission, $this->getDefaultGuardName());
        }

        if (! $this->getGuardNames()->contains($permission->ds_nome_guard)) {
            throw GuardDoesNotMatch::create($permission->ds_nome_guard, $this->getGuardNames());
        }

        return $this->permissions->contains('id', $permission->co_seq_permissao);
    }

}