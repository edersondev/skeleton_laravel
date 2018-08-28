<!-- Modal -->
<div class="modal fade" id="{{ isset($modal_id) ? $modal_id : 'exampleModal' }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">{{ ( isset($title) ? $title : 'Excluir registro' ) }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ isset($body) ? $body : 'Tem certeza de que deseja excluir este registro?' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fa fa-times"></i> Cancelar
        </button>
        <button type="button" class="btn btn-primary confirm-submit" data-form="">
          <i class="fas fa-check"></i> Sim
        </button>
      </div>
    </div>
  </div>
</div>