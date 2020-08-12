<?php ob_start();
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(1);
?>
<?php
  $delete_id = delete_by_id('users',(int)$_POST['id']);
  if($delete_id){
      $session->msg("s","Usuário deletado!");
      redirect('usuarios.php');
  } else {
      $session->msg("d","Não foi possível deletar o usuário.");
      redirect('usuarios.php');
  }
?>
