<!-- Modal -->
@php
  
  switch( isset($size) ? $size : null ){
    case 'large':
      $modalSize = ' modal-lg';
    break;
    case 'small':
      $modalSize = ' modal-sm';
    break;
    default:
      $modalSize = '';
    break;
  }
@endphp
<div class="modal fade" id="{{ isset($modal_id) ? $modal_id : 'exampleModal' }}" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog{{ $modalSize }}" role="document">
    <div class="modal-content">
      <div class="modal-header">
        @if(isset($title))
          <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
        @endif
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ $slot }}
      </div>
      
      <div class="modal-footer">
        @if(isset($modal_footer))
          {{ $modal_footer }}
        @else
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            <i class="fa fa-times"></i> Fechar
          </button>
        @endif
      </div>
      
    </div>
  </div>
</div>