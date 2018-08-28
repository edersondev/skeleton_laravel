
function dataTablesFormDestroy(url_edit,form_name,form_action,modal_id = 'exampleModal')
{
  var csrf_field = $('meta[name="csrf-token"]').attr('content');
  var modalId = `#${modal_id}`;
  return `
    <form name="${form_name}" id="${form_name}" action="${form_action}" method="post">
      <input type="hidden" name="_token" value="${csrf_field}">
      <input type="hidden" name="_method" value="DELETE">
      <a class="btn btn-primary btn-sm" href="${url_edit}" role="button">
        <i class="fas fa-edit"></i> Editar
      </a>
      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="${modalId}">
        <i class="fas fa-trash-alt"></i> Deletar
      </button>
    </form>
  `;
}