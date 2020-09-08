<?php
require_once('includes/load.php');

$page_title = 'Todos os Empréstimos';
// Checkin What level user has permission to view this page
page_require_level(2);

$loans = find_all_loan();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?= display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Todos os Empréstimos</span>
        </strong>
        <div class="pull-right">
          <a href="adicionar_emprestimo.php" class="btn btn-primary">Adicionar empréstimo</a>
        </div>
      </div>
      <div class="panel-body">
        <table class="table table-bordered datatable-active">
          <thead>
            <tr>
              <th class="text-center" style="width: 50px;">#</th>                
              <th> Tombo</th>
              <th class="none"> Especificações </th>
              <th class="text-center"> Tipo de Equipamento </th>
              <th class="text-center"> Setor </th>
              <th class="text-center"> Usuário Responsável </th>
              <th class="text-center"> Data do empréstimo </th>
              <th class="text-center none"> Criado por </th>
              <th class="text-center none"> Criado em </th>
              <th class="text-center none"> Atualizado por </th>
              <th class="text-center none"> Atualizado em </th>
              <th class="text-center"> Ações </th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($loans as $loan):?>
              <tr>
                <td class="text-center"><?= count_id();?></td>
                <td class="text-center"><?= remove_junk($loan['tombo']); ?></td>
                <td><?= remove_junk($loan['specifications']); ?></td>
                <td class="text-center"><?= remove_junk($loan['type_equip']); ?></td>                
                <td class="text-center"><?= remove_junk($loan['sector']); ?></td>                
                <td class="text-center"><?= remove_junk($loan['responsible_user']); ?></td>                
                <td class="text-center"><?= strftime('%d/%m/%Y', strtotime($loan['loan_date'])); ?></td>
                <td><?= remove_junk($loan['created_user']); ?></td>       
                <td class="text-center"><?= strftime('%d/%m/%Y %H:%M', strtotime($loan['created_at'])); ?></td>                
                <td><?= remove_junk($loan['updated_user']); ?></td>
                <td class="text-center"><?php if(!empty($loan['updated_at'])) echo strftime('%d/%m/%Y %H:%M', strtotime($loan['updated_at'])); ?></td>                
                <td class="text-center">
                  <div class="btn-group">
                    <a href="editar_emprestimo.php?id=<?= (int)$loan['id'];?>" class="btn btn-xs btn-warning"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <button title="Finalizar empréstimo" type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#launchModal-<?= (int)$loan['id'];?>">
                      <span class="glyphicon glyphicon-share-alt"></span>
                    </button>                    

                    <?php $action="finalizar_emprestimo.php"; $id=(int)$loan['id']; include('layouts/modal-confirmacao.php'); ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
