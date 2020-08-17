<?php
ob_start();
$page_title = 'Adicionar Equipamento';
require_once('includes/load.php');
  // Checkin What level user has permission to view this page
page_require_level(2);
$all_types_equip = find_all('types_equips');
$all_supplier = find_all('suppliers');
$all_manufacturer = find_all('manufacturers');
$all_situation = find_all('situations');
?>
<?php
if(isset($_POST['add_equipment'])){
 $req_fields = array('equipment-tombo','equipment-specifications','equipment-type_equip','equipment-manufacturer','equipment-situation');
 validate_fields($req_fields);   
 if(empty($errors)){
  $equip_tombo  = remove_junk($db->escape($_POST['equipment-tombo']));
  $equip_specifications  = remove_junk($db->escape($_POST['equipment-specifications']));
  $equip_type_equip   = remove_junk($db->escape($_POST['equipment-type_equip']));
  $equip_supplier   = remove_junk($db->escape($_POST['equipment-supplier']));
  $equip_manufacturer   = remove_junk($db->escape($_POST['equipment-manufacturer']));
  $equip_situation  = remove_junk($db->escape($_POST['equipment-situation']));     
  $equip_created_by    = (int) $_SESSION['user_id'];
  $equip_created_at    = make_date();

  if(validate_tombo($equip_tombo)){
    $session->msg('d',"Desculpe, já existe um equipamento com o tombo $equip_tombo");
    redirect('equipamentos.php', false);
  }

  $query  = "INSERT INTO equipments (";
  $query .=" tombo,specifications,types_equip_id,supplier_id,manufacturer_id,situation_id,created_by,created_at";
  $query .=") VALUES (";
  $query .=" '{$equip_tombo}', '{$equip_specifications}', '{$equip_type_equip}', '{$equip_supplier}', '{$equip_manufacturer}', '{$equip_situation}', '{$equip_created_by}','{$equip_created_at}'";
  $query .=")";

  if($db->query($query)){
   $session->msg('s',"Equipamento adicionado com sucesso! ");
   redirect('adicionar_equipamento.php', false);
 } else {
   $session->msg('d','Desculpe, falha ao cadastrar o equipamento.');
   redirect('equipamentos.php', false);
 }

} else{
 $session->msg("d", $errors);
 redirect('adicionar_equipamento.php',false);
}

}

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?= display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Adicionar Novo Equipamento</span>
        </strong>
      </div>
      <div class="panel-body">
       <div class="col-md-12">
        <form method="post" action="adicionar_equipamento.php" class="clearfix">
          <div class="form-group">
            <div class="row">
              <div class="col-md-3">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                 </span>
                 <input type="text" class="form-control" name="equipment-tombo" placeholder="Número Tombo" required>
               </div>
             </div>
             <div class="col-md-9">
              <div class="input-group">
                <span class="input-group-addon">
                 <i class="glyphicon glyphicon-th-large"></i>
               </span>
               <input type="text" class="form-control" name="equipment-specifications" placeholder="Especificações do Equipamento" required>
             </div>
           </div>
         </div>
       </div>

       <div class="form-group">
        <div class="row">
          <div class="col-md-5">
            <select class="form-control" name="equipment-type_equip" required>
              <option value="">Selecione o Tipo de Equipamento</option>
              <?php  foreach ($all_types_equip as $t_equip): ?>
                <option value="<?= (int)$t_equip['id'] ?>">
                  <?= $t_equip['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-5">
             <select class="form-control" name="equipment-supplier" required>
              <option value="">Selecione o Fornecedor</option>
              <?php  foreach ($all_supplier as $sup): ?>
                <option value="<?= (int)$sup['id'] ?>">
                  <?= $sup['name'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-md-5">
              <select class="form-control" name="equipment-manufacturer" required>
                <option value="">Selecione o Fabricante</option>
                <?php  foreach ($all_manufacturer as $man): ?>
                  <option value="<?= (int)$man['id'] ?>">
                    <?= $man['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-5">
               <select class="form-control" name="equipment-situation" required>
                <option value="">Selecione a Situação</option>
                <?php  foreach ($all_situation as $sit): ?>
                  <option value="<?= (int)$sit['id'] ?>">
                    <?= $sit['name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>             

          <button type="submit" name="add_equipment" class="btn btn-primary">Adicionar equipamento</button>
          <a href="equipamentos.php" class="btn btn-danger">Cancelar</a>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<?php include_once('layouts/footer.php'); ?>
