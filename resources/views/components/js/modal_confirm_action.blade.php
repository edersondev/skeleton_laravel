$('#{{ isset($modal_id) ? $modal_id : 'exampleModal' }}').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget),
      form = button.parent(),
      modal = $(this);
  modal.find('.modal-footer button.confirm-submit').attr('data-form',form.attr('id'));
});

$('.confirm-submit').on('click',function(){
  var form_id = $(this).attr('data-form');
  $("form#" + form_id).submit();
});