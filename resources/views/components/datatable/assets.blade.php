@push('css')
	<link rel="stylesheet" href="{{ URL::asset('components/datatables/css/dataTables.bootstrap4.min.css') }}">
@endpush

@push('js')
	<script src="{{ URL::asset('components/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('components/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ URL::asset('js/datatables-plugins/cache/pipelining.js') }}"></script>
	<script src="{{ URL::asset('components/jquery-dateFormat/jquery-dateformat.min.js') }}"></script>
@endpush

@push('js')
<script>
  $(function(){
		$.extend( true, $.fn.dataTable.defaults, {
			language: {
        url: "{!! URL::asset('js/datatables-plugins/i18n/Portuguese-Brasil.json') !!}"
      }
		});
	});
</script>
@endpush