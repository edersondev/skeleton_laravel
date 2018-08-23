{{-- Blade component --}}
<div class="float-right">
  <a class="btn btn-danger" href="{{ $routeCancel }}" role="button">
    <i class="fa fa-times"></i> Cancelar
  </a>
  <button type="submit" class="btn btn-primary">
    <i class="fas fa-save"></i> {{ ( get_route_method($routeName) === 'create' ? 'Salvar' : 'Atualizar' ) }}
  </button>
</div>