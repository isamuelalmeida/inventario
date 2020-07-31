<?php ob_start();
  $page_title = 'Editar fornecedor';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $supplier = find_by_id('suppliers',(int)$_GET['id']);
  if(!$supplier){
    $session->msg("d","Fornecedor não encontrado!");
    redirect('fornecedores.php');
  }
?>

<?php
if(isset($_POST['edit_supplier'])){
  $req_field = array('supplier-name');
  validate_fields($req_field);
  $supplier_name = remove_junk($db->escape($_POST['supplier-name']));
  if(empty($errors)){
        $sql = "UPDATE suppliers SET name='{$supplier_name}'";
       $sql .= " WHERE id='{$supplier['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Fornecedor alterado com sucesso");
       redirect('fornecedores.php',false);
     } else {
       $session->msg("d", "Desculpe, falha ao alterar o fornecedor.");
       redirect('fornecedores.php',false);
     }
  } else {
    $session->msg("d", $errors);
    redirect('fornecedores.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
   <div class="col-md-12">
     <?php echo display_msg($msg); ?>
   </div>
   <div class="col-md-5">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Editando <?php echo remove_junk(ucfirst($supplier['name']));?></span>
        </strong>
       </div>
       <div class="panel-body">
         <form method="post" action="editar_fornecedor.php?id=<?php echo (int)$supplier['id'];?>">
           <div class="form-group">
               <input type="text" class="form-control" name="supplier-name" required value="<?php echo remove_junk(ucfirst($supplier['name']));?>">
           </div>
           <button type="submit" name="edit_supplier" class="btn btn-primary">Atualizar fornecedor</button>
       </form>
       </div>
     </div>
   </div>
</div>



<?php include_once('layouts/footer.php'); ?>
