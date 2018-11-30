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
        <h5 class="modal-title" id="exampleModalLabel">{{ (isset($title) ? $title : 'Titulo') }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{ $slot }}
      </div>
      <div class="modal-footer">
        {{ $modal_footer }}
      </div>
    </div>
  </div>
</div>