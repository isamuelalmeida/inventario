<?php ob_start();
$page_title = 'Relatório de Equipamentos';
$results = '';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
  if(isset($_POST['submit'])){    

    if(empty($errors)):
      $equip_tombo  = remove_junk($db->escape($_POST['equipment-tombo']));
      $equip_specifications  = remove_junk($db->escape($_POST['equipment-specifications']));
      $equip_responsible_user  = remove_junk($db->escape($_POST['equipment-responsible_user']));
      $equip_loan  = remove_junk($db->escape($_POST['equipment-loan']));      
      $equip_type_equip   = remove_junk($db->escape($_POST['equipment-type_equip']));
      $equip_sector  = remove_junk($db->escape($_POST['equipment-sector']));
      $equip_supplier   = remove_junk($db->escape($_POST['equipment-supplier']));
      $equip_manufacturer   = remove_junk($db->escape($_POST['equipment-manufacturer']));
      $equip_situation  = remove_junk($db->escape($_POST['equipment-situation']));

      $all_equips = issue_reports($equip_tombo, $equip_specifications, $equip_responsible_user, $equip_loan, $equip_type_equip, $equip_sector, $equip_supplier, $equip_manufacturer, $equip_situation);

    else:
      $session->msg("d", $errors);
      redirect('relatorios.php', false);
    endif;

  } else {
    $session->msg("d", "Desculpe, não foi possível gerar o relatório!");
    redirect('relatorios.php', false);
  }
?>
<!doctype html>
<html lang="pt-br">
 <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <title>Relatório de Equipamentos</title>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
   <style>
   @media print {
     html,body{       
     }.page-break {
       page-break-before:always;
       width: auto;
       margin: auto;
      }
    }
    .page-break{
      width: 980px;
      margin: 0 auto;
    }
     .head{
       margin: 40px 0;
       text-align: center;
     }.head h1,.head strong{
       padding: 10px 20px;
       display: block;
     }.head h1{
       margin: 0;
       border-bottom: 1px solid #212121;
     }.table>thead:first-child>tr:first-child>th{
       border-top: 1px solid #000;
      }
      table thead tr th {
       text-align: center;
       border: 1px solid #ededed;
     }table tbody tr td{
       vertical-align: middle;
     }.head,table.table thead tr th,table tbody tr td,table tfoot tr td{
       border: 1px solid #212121;
     }

     .font-12 {
      font-size: 12px !important;
     }.font-15 {
      font-size: 15px !important;
     }
   </style>
</head>
<body>
  <?php if($all_equips): ?>
    <div class="page-break">
       <div class="head pull-">
           <h2>Relatório de Equipamentos da STC</h2>
           <strong>Relatório gerado às <?= strftime('%H:%M em %d/%m/%Y', strtotime(make_date())) ?></strong>
       </div>
      <table class="table table-border table-striped table-condensed">
        <thead>
          <tr class="font-15 warning">
              <th>#</th>             
              <th>Tombo</th>
              <th>Tipo de Equipamento</th>
              <th>Especificações</th>
              <th>Usuário Responsável</th>              
              <th>Setor</th>
              <th>Fabricante</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($all_equips as $result): ?>
           <tr class="font-12">
              <td class=""><?= count_id(); ?></td>              
              <td><?= remove_junk($result['tombo']);?></td>
              <td><?= remove_junk($result['types_equip']);?></td>              
              <td><?= remove_junk($result['specifications']);?></td>              
              <td><?php if(empty($result['responsible_user'])): echo "SUINFOR"; else: echo remove_junk($result['responsible_user']); endif;?></td>
              <td><?php if(empty($result['sector'])): echo "SUINFOR"; else: echo remove_junk($result['sector']); endif;?></td>
              <td><?= remove_junk($result['manufacturer']);?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>        
      </table>
    </div>
  <?php
    else:
        $session->msg("d", "Desculpe, nenhum equipamento encontrado!");
        redirect('relatorios.php', false);
     endif;
  ?>
</body>
</html>
<?php if(isset($db)) { $db->db_disconnect(); } ?>
