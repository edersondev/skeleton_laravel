@push('js')
<script>
  $(function(){
    var defaultDatatable = $.extend( true, $.fn.dataTable.defaults, {
      processing: true,
      serverSide: true,
      ajax: $.fn.dataTable.pipeline( {
        url: "{!! $slot !!}",
        pages: 3,
        method: 'post',
        data: function ( d ) {
          return $.extend( {}, d, {
            "_token": '{!! csrf_token() !!}'
          });
        }
      } ),
      dom:
        "<'row'<'col-sm-6'l><'col-sm-6'>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-6'i><'col-sm-6'p>>",
      order: [[ 1, "desc" ]]
    } );

    defaultDatatable.columnDefs = [
      {
        targets:[0],
        searchable: false,
        orderable: false,
        class:'text-center',
        width:'4%',
        render:function(data,type,full,meta){
          var element = $('<span>',{'class':'selected-row','title':'Selecionar registro'});
          element.append($('<i>',{'class':'far fa-square'}));
          return element.get(0).outerHTML;
        }
      }
    ];

    $('table.table').on( 'click', 'tr td span.selected-row', function () {
      $(this).closest('tr').toggleClass('selected');
      var iconClass = ( $(this).closest('tr').hasClass('selected') ? 'far fa-check-square' : 'far fa-square' );
      $(this).children('i').attr('class',iconClass);
    });

  });
</script>
@endpush