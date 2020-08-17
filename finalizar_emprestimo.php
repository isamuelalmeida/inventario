<?php ob_start();
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
?>
<?php
  $d_loan = find_by_id('loans',(int)$_POST['id']);
  if(!$d_loan){
    $session->msg("d","Empréstimo não encontado!");
    redirect('emprestimos.php');
  }
?>
<?php
  $delete_id = delete_by_id('loans',(int)$d_loan['id']);
  if($delete_id){
      $e_id      = $db->escape((int) $d_loan['equipment_id']);
      $e_r_u     = $db->escape($d_loan['responsible_user']);
      $e_sector  = $db->escape((int) $d_loan['sector_id']);
      $e_l_date      = $db->escape($d_loan['loan_date']);
      $e_user_create = (int) $_SESSION['user_id'];
      $e_date_create = make_date();
          
      $sql  = "INSERT INTO loan_historys (";
      $sql .= " equipment_id,responsible_user,sector_id,loan_date,created_by,created_at";
      $sql .= ") VALUES (";
      $sql .= "'{$e_id}','{$e_r_u}','{$e_sector}','{$e_l_date}','{$e_user_create}','{$e_date_create}'";
      $sql .= ")";

      if(!$db->query($sql)){
        $session->msg('d','Desculpe, falha ao adicionar o empréstimo ao histórico.');
        redirect('adicionar_emprestimo.php', false);
      }          

      $session->msg("s","Empréstimo finalizado.");
      redirect('emprestimos.php');
  } else {
      $session->msg("d","Falha ao finalizar o empréstimo.");
      redirect('emprestimos.php');
  }
?>
