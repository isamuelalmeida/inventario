<?php ob_start();
  $page_title = 'Dashboard';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
 $c_equipment     = count_by_id('equipments');
 $c_loan       = count_by_id('loans');
 $c_sector          = count_by_id('sectors');
 $c_user          = count_by_id('users');
 $recent_equipments    = find_recent_equipment_added('5');
 $recent_loans    = find_recent_loan_added('5');

?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-6">
     <?= display_msg($msg); ?>
   </div>
</div>
  <div class="row">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-green">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?= $c_user['total']; ?> </h2>
          <p class="text-muted">Usuários</p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-th-large"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?= $c_equipment['total']; ?> </h2>
          <p class="text-muted">Equipamentos</p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-blue">
          <i class="glyphicon glyphicon-random"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?= $c_loan['total']; ?> </h2>
          <p class="text-muted">Empréstimos</p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-yellow">
          <i class="glyphicon glyphicon-object-align-vertical"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> <?= $c_sector['total']; ?></h2>
          <p class="text-muted">Setores</p>
        </div>
       </div>
    </div>
</div>
  <div class="row">
   <div class="col-md-12">
      <div class="panel">
        <div class="jumbotron text-center">
           <h1>Sistema de Inventário</h1>
        </div>
      </div>
   </div>
  </div>
  <div class="row">   
   <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Equipamentos adicionados recentemente</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
       <thead>
         <tr>
           <th class="text-center" style="width: 50px;">#</th>
           <th>Tombo</th>
           <th>Especificações</th>
         </tr>
       </thead>
       <tbody>
         <?php foreach ($recent_equipments as  $r_e): ?>
         <tr>
           <td class="text-center"><?= count_id();?></td>
           <td>
            <a href="#">
             <?= remove_junk(first_character($r_e['tombo'])); ?>
           </a>
           </td>
           <td><?= remove_junk(ucfirst($r_e['specifications'])); ?></td>
        </tr>

       <?php endforeach; ?>
       </tbody>
     </table>
    </div>
   </div>
  </div>
  <div class="col-md-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Empréstimos adicionados recentemente</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
       <thead>
         <tr>
           <th class="text-center" style="width: 50px;">#</th>
           <th>Tombo</th>
           <th>Tipo de equipamento</th>
           <th>Usuário Responsável</th>
         </tr>
       </thead>
       <tbody>
         <?php foreach ($recent_loans as  $recent_loan): ?>
         <tr>
           <td class="text-center"><?= count_id();?></td>
           <td>
            <a href="#">
             <?= remove_junk(first_character($recent_loan['tombo'])); ?>
           </a>
           </td>
           <td><?= remove_junk(ucfirst($recent_loan['type_equip'])); ?></td>
           <td><?= remove_junk(first_character($recent_loan['responsible_user'])); ?></td>
        </tr>

       <?php endforeach; ?>
       </tbody>
     </table>
    </div>
   </div>
  </div>
 </div>

  <div class="row">

  </div>



<?php include_once('layouts/footer.php'); ?>
