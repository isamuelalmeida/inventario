<?php ob_start();
$page_title = 'Relatórios';
require_once('includes/load.php');
  // Checkin What level user has permission to view this page
page_require_level(2);

$all_types_equip = find_all('types_equips');
$all_supplier = find_all('suppliers');
$all_manufacturer = find_all('manufacturers');
$all_situation = find_all('situations');
$all_sector = find_all('sectors');

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
      <div class="panel-heading clearfix text-center">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Gerar Relatório</span>
        </strong>
      </div>
      <div class="panel-body">
        <form class="clearfix" method="post" action="processar_relatorio.php" target="_blank">
          <div class="form-group">
            <div class="row">
              <div class="col-md-2">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="number" class="form-control" name="equipment-tombo" placeholder="Tombo">
                </div>
              </div>
              <div class="col-md-4">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="equipment-specifications" placeholder="Especificações do Equipamento">
                </div>
              </div>
              <div class="col-md-3">
                <select class="form-control" name="equipment-loan">
                  <option value="1">Todos Equipamentos</option>
                  <option value="2">Somente emprestados</option>
                  <option value="3">Somente não emprestados</option>
                </select>
              </div>
              <div class="col-md-3">
                <select class="form-control" name="equipment-sector">
                  <option value="">Setor</option>
                  <?php  foreach ($all_sector as $sector): ?>
                  <option value="<?= (int)$sector['id'] ?>">
                      <?= $sector['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-md-3">
                <select class="form-control" name="equipment-type_equip">
                  <option value="">Tipo de Equipamento</option>
                  <?php  foreach ($all_types_equip as $t_equip): ?>
                    <option value="<?= (int)$t_equip['id'] ?>">
                      <?= $t_equip['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-3">
                 <select class="form-control" name="equipment-supplier">
                  <option value="">Fornecedor</option>
                  <?php  foreach ($all_supplier as $sup): ?>
                    <option value="<?= (int)$sup['id'] ?>">
                      <?= $sup['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <select class="form-control" name="equipment-manufacturer">
                    <option value="">Fabricante</option>
                    <?php  foreach ($all_manufacturer as $man): ?>
                      <option value="<?= (int)$man['id'] ?>">
                        <?= $man['name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                   <select class="form-control" name="equipment-situation">
                    <option value="">Situação</option>
                    <?php  foreach ($all_situation as $sit): ?>
                      <option value="<?= (int)$sit['id'] ?>">
                        <?= $sit['name'] ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
               <button type="submit" name="submit" class="btn btn-primary">Gerar Relatório</button>
             </div>
           </form>
         </div>

       </div>
     </div>

   </div>
   <?php include_once('layouts/footer.php'); ?>
