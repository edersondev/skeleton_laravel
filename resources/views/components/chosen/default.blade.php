@push('js')
  <script>
    $(function(){
      $.fn.oldChosen = $.fn.chosen
      $.fn.chosen = function(options) {
        var select = $(this)
          , is_creating_chosen = !!options

        if (is_creating_chosen && select.css('position') === 'absolute') {
          // if we are creating a chosen and the select already has the appropriate styles added
          // we remove those (so that the select hasn't got a crazy width), then create the chosen
          // then we re-add them later
          select.removeAttr('style')
        }

        var ret = select.oldChosen(options)

        if (is_creating_chosen) {
          // https://github.com/harvesthq/chosen/issues/515#issuecomment-33214050
          // only do this if we are initializing chosen (no params, or object params) not calling a method
          select.attr('style','display:visible; position:absolute; clip:rect(0,0,0,0);height:38px');
          select.attr('tabindex', -1);
        }
        return ret
      }

      $('.select-chosen').chosen({
        disable_search_threshold: 10,
        no_results_text: 'Nenhum resultado encontrado',
        placeholder_text_single: 'Selecione uma opção',
        placeholder_text_multiple: 'Selecione as opções',
        allow_single_deselect: true,
        width: '100%'
      });
    });
  </script>
@endpush