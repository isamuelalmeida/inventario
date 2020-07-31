<?php ob_start();
  $page_title = 'Todos os Equipamentos';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $equipments = join_equipment_table();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Todos os Equipamentos</span>
          </strong>
         <div class="pull-right">
           <a href="adicionar_equipamento.php" class="btn btn-primary">Adicionar Novo</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>                
                <th> Tombo</th>
                <th> Especificações </th>
                <th class="text-center" style="width: 10%;"> Tipo de equipamento </th>
                <th class="text-center" style="width: 10%;"> Fornecedor </th>
                <th class="text-center" style="width: 10%;"> Fabricante </th>
                <th class="text-center" style="width: 10%;"> Situação </th>
                <th class="text-center" style="width: 100px;"> Ações </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($equipments as $equipment):?>
              <tr>
              	<td class="text-center"><?= count_id();?></td>
                <td class="text-center"><?= remove_junk($equipment['tombo']); ?></td>
                <td><?= remove_junk($equipment['specifications']); ?></td>
                <td class="text-center"><?= remove_junk($equipment['type_equip']); ?></td>                
                <td class="text-center"><?= remove_junk($equipment['supplier']); ?></td>                
                <td class="text-center"><?= remove_junk($equipment['manufacturer']); ?></td>                
                <td class="text-center"><?= remove_junk($equipment['situation']); ?></td>                
                <td class="text-center">
                  <div class="btn-group">
                    <a href="editar_equipamento.php?id=<?php echo (int)$equipment['id'];?>" class="btn btn-info btn-xs"  title="Editar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="deletar_equipamento.php?id=<?php echo (int)$equipment['id'];?>" class="btn btn-danger btn-xs"  title="Deletar" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
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
