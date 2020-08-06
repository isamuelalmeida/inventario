<?php ob_start();
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $delete_id = delete_by_id('user_groups',(int)$_GET['id']);
  if($delete_id){
      $session->msg("s","Grupo deletado.");
      redirect('grupos.php');
  } else {
      $session->msg("d","Falha ao excluir o grupo.");
      redirect('grupos.php');
  }
?>
