<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;

class TbUsuario extends Authenticatable 
{
	use Notifiable;
	use HasRoles;
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tb_usuario';

	/**
	 * The primary key for the model.
	 *
	 * @var string
	 */
	protected $primaryKey = 'co_seq_usuario';
	
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

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'ds_nome', 
		'email', 
		'password',
		'st_ativo',
		'img_profile'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'ds_relembrar_token',
	];

	/**
	 * The column name of the "remember me" token.
	 *
	 * @var string
	 */
	protected $rememberTokenName = 'ds_relembrar_token';

	/**
	 * A model may have multiple roles.
	 */
	public function roles(): MorphToMany
	{
		return $this->morphToMany(
			config('permission.models.role'),
			'model',
			config('permission.table_names.model_has_roles'),
			'model_id',
			'co_perfil'
		);
	}

	public function setPasswordAttribute($password)
	{
		if(!is_null($password)){
			$this->attributes['password'] = Hash::make($password);
		}
	}

	public function setStAtivoAttribute($value)
	{
		$this->attributes['st_ativo'] = ( $value == 1 ? true : false );
	}

	/**
	 * Assign the given role to the model.
	 *
	 * @param array|string|\Spatie\Permission\Contracts\Role ...$roles
	 *
	 * @return $this
	 */
	public function assignRole(...$roles)
	{
		$roles = collect($roles)
			->flatten()
			->map(function ($role) {
				if (empty($role)) {
					return false;
				}

				return $this->getStoredRole($role);
			})
			->filter(function ($role) {
				return $role instanceof Role;
			})
			->each(function ($role) {
				$this->ensureModelSharesGuard($role);
			})
			->map->co_seq_perfil
			->all();
		$this->roles()->sync($roles, false);

		$this->forgetCachedPermissions();

		return $this;
	}

	/**
	 * Determine if the model has (one of) the given role(s).
	 *
	 * @param string|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles
	 *
	 * @return bool
	 */
	public function hasRole($roles): bool
	{
		if (is_string($roles) && false !== strpos($roles, '|')) {
			$roles = $this->convertPipeToArray($roles);
		}

		if (is_string($roles)) {
			return $this->roles->contains('ds_nome', $roles);
		}

		if ($roles instanceof Role) {
			return $this->roles->contains('co_seq_perfil', $roles->co_seq_perfil);
		}

		if (is_array($roles)) {
			foreach ($roles as $role) {
				if ($this->hasRole($role)) {
					return true;
				}
			}

			return false;
		}

		return $roles->intersect($this->roles)->isNotEmpty();
	}

	/**
	 * Determine if the model has the given permission.
	 *
	 * @param string|int|\Spatie\Permission\Contracts\Permission $permission
	 *
	 * @return bool
	 */
	public function hasDirectPermission($permission): bool
	{
		$permissionClass = $this->getPermissionClass();

		if (is_string($permission)) {
			$permission = $permissionClass->findByName($permission, $this->getDefaultGuardName());
			if (! $permission) {
				return false;
			}
		}

		if (is_int($permission)) {
			$permission = $permissionClass->findById($permission, $this->getDefaultGuardName());
			if (! $permission) {
				return false;
			}
		}

		if (! $permission instanceof Permission) {
			return false;
		}

		return $this->permissions->contains('co_seq_permissao', $permission->co_seq_permissao);
	}

	public function papeis()
	{
		return $this->hasMany('App/Models\TaModelPapeis', 'model_id');
	}

	public function permissoes()
	{
		return $this->hasMany('App/Models\TaModelPermissoes', 'co_permissao');
	}

}