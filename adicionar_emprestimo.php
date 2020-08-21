<?php ob_start();
$page_title = 'Adicionar Empréstimo';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php

  if(isset($_POST['add_loan'])){
    $req_fields = array('e_id','sector','responsible_user','loan_date');
    validate_fields($req_fields);
        if(empty($errors)){
          $e_id      = $db->escape((int) $_POST['e_id']);
          $e_r_u     = $db->escape($_POST['responsible_user']);
          $e_sector  = $db->escape((int) $_POST['sector']);
          $e_l_date      = $db->escape($_POST['loan_date']);
          $e_user_create = (int) $_SESSION['user_id'];
          $e_date_create = make_date();

          $sql  = "INSERT INTO loans (";
          $sql .= " equipment_id,responsible_user,sector_id,loan_date,created_by,created_at";
          $sql .= ") VALUES (";
          $sql .= "'{$e_id}','{$e_r_u}','{$e_sector}','{$e_l_date}','{$e_user_create}','{$e_date_create}'";
          $sql .= ")";

                if($db->query($sql)){
                  //update_product_qty($s_qty,$p_id);
                  $session->msg('s',"Empréstimo adicionado com sucesso!");
                  redirect('adicionar_emprestimo.php', false);
                } else {
                  $session->msg('d','Desculpe, falha ao adicionar o empréstimo.');
                  redirect('adicionar_emprestimo.php', false);
                }
        } else {
           $session->msg("d", $errors);
           redirect('adicionar_emprestimo.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <input type="text" id="sug_input" class="form-control" name="tombo"  placeholder="Informe o tombo do equipamento">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Buscar equipamento</button>
            </span>            
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Equipamento a ser emprestado</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="adicionar_emprestimo.php">
         <table class="table table-bordered">
           <thead>
            <th> Tombo </th>
            <th> Tipo de Equipamento</th>
            <th> Usuário Responsável </th>
            <th> Setor </th>
            <th> Data do empréstimo </th>
            <th> Ação</th>
           </thead>
             <tbody  id="equipment_info"> </tbody>
         </table>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
