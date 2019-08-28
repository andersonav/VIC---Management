// Call the dataTables jQuery plugin
$(document).ready(function () {
  var table = $('#dataTable').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf']
  });

  table.buttons().container()
    .appendTo('#btnDatatable');
});
