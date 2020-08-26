     </div>
    </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="assets/js/functions.js"></script>
  <script type="text/javascript">
  	<?php if(isset($scripts) && !empty($scripts)) echo $scripts; ?>  		
  </script>
  </body>
</html>

<?php if(isset($db)) { $db->db_disconnect(); } ?>
