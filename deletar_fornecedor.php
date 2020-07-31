<?php ob_start();
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  $supplier = find_by_id('suppliers',(int)$_GET['id']);
  if(!$supplier){
    $session->msg("d","Fornecedor não encontrado!");
    redirect('fornecedores.php');
  }
?>
<?php
  $delete_id = delete_by_id('suppliers',(int)$supplier['id']);
  if($delete_id){
      $session->msg("s","Fornecedor excluído.");
      redirect('fornecedores.php');
  } else {
      $session->msg("d","Falha ao excluir o fornecedor.");
      redirect('fornecedores.php');
  }
?>
