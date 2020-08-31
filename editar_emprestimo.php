<?php ob_start();
$page_title = 'Editar Empréstimo';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(2);

$all_sector = find_all('sectors');

$loan = find_by_id('loans',(int)$_GET['id']);
if(!$loan){
  $session->msg("d","Empréstimo não encontrado.");
  redirect('emprestimos.php');
}

$equipment = find_by_id('equipments',$loan['equipment_id']);

if(isset($_POST['update_loan'])){
  $req_fields = array('tombo','sector','responsible_user','loan_date');
  validate_fields($req_fields);
  if(empty($errors)){
    $e_r_u     = $db->escape($_POST['responsible_user']);
    $e_sector  = $db->escape((int) $_POST['sector']);
    $e_l_date      = $db->escape($_POST['loan_date']);
    $e_user_update = (int) $_SESSION['user_id'];
    $e_date_update = make_date();

    $sql  = "UPDATE loans SET";
    $sql .= " responsible_user='{$e_r_u}',sector_id={$e_sector},loan_date='{$e_l_date}',updated_by={$e_user_update}, updated_at='{$e_date_update}'";
    $sql .= " WHERE id ='{$loan['id']}'";
    $result = $db->query($sql);
    if( $result && $db->affected_rows() === 1){
      $session->msg('s',"Empréstimo alterado com sucesso!");
      redirect('emprestimos.php?id='.$loan['id'], false);
    } else {
      $session->msg('d','Desculpe, falha ao alterar o equipamento.');
      redirect('emprestimos.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('editar_emprestimo.php?id='.(int)$loan['id'],false);
  }
}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todos os Empréstimos</span>
        </strong>
        <div class="pull-right">
          <a href="emprestimos.php" class="btn btn-primary">Listar empréstimos</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <th> Tombo </th>
            <th> Especificações </th>
            <th> Usuário Responsável </th>
            <th> Setor </th>
            <th> Data do empréstimo </th>
            <th> Ação</th>
          </thead>
          <tbody  id="equipment_info">
            <tr>
              <form method="post" action="editar_emprestimo.php?id=<?= (int)$loan['id']; ?>">
                <td id="e_tombo">
                  <input type="text" class="form-control" id="sug_input" name="tombo" value="<?= remove_junk($equipment['tombo']); ?>" readonly>
                  <div id="result" class="list-group"></div>
                </td>
                <td>
                  <input type="text" class="form-control" name="specifications" value="<?= remove_junk($equipment['specifications']); ?>" required>
                </td>
                <td>
                  <input type="text" class="form-control" name="responsible_user" value="<?= remove_junk($loan['responsible_user']); ?>" required>
                </td>
                <td>
                  <select class="form-control" name="sector" required>
                    <option value="">Selecione o Setor</option>
                    <?php  foreach ($all_sector as $sec): if($sec['id'] == $loan['sector_id']): ?>
                    <option selected value="<?= (int)$sec['id'] ?>"><?= $sec['name'] ?></option>
                    <?php else: ?>
                    <option value="<?= (int)$sec['id'] ?>"><?= $sec['name'] ?></option>
                    <?php endif; endforeach; ?>
                  </select>
                </td>    
                <td>
                  <input type="date" class="form-control" name="loan_date" value="<?= remove_junk($loan['loan_date']); ?>" required>
                </td>
                <td>
                  <button type="submit" name="update_loan" class="btn btn-primary">Atualizar Empréstimo</button>
                </td>
              </form>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
