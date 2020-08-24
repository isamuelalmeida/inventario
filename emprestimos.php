<?php ob_start();
  $page_title = 'Todos os Empréstimos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
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
                <th> Especificações </th>
                <th class="text-center" style="width: 10%;"> Tipo de Equipamento </th>
                <th class="text-center" style="width: 10%;"> Setor </th>
                <th class="text-center" style="width: 10%;"> Usuário Responsável </th>
                <th class="text-center" style="width: 10%;"> Data do empréstimo </th>
                <th class="text-center" style="width: 100px;"> Ações </th>
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
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
