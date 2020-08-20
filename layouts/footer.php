     </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="assets/js/functions.js"></script>
  </body>
</html>
<script>
  $(document).ready( function () {
    if($('.table').length)
    $('.table').DataTable({
      "bJQueryUI": true,
      "sPaginationType": "full_numbers",
      "pageLength": 10,
      "lengthMenu": [ [12, 24, 36, -1], [12, 24, 36, "All"] ],
      "oLanguage": {
          "sLengthMenu": "",
          //"sLengthMenu": "Mostrar _MENU_ registros por página",
          "sZeroRecords": "Nenhum registro encontrado",
          "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
          "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
          "sInfoFiltered": "(filtrado de _MAX_ registros)",
          "sSearch": "Pesquisar",
          "oPaginate": {
              "sFirst": "Início",
              "sPrevious": "Anterior",
              "sNext": "Próximo",
              "sLast": "Último"
          }
      },
      "aaSorting": [[0, 'asc']],
      "aoColumnDefs": [
          {"orderable": false}

      ]
    });
  } );
  </script>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
