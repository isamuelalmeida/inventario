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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js" integrity="sha512-vBmx0N/uQOXznm/Nbkp7h0P1RfLSj0HQrFSzV8m7rOGyj30fYAOKHYvCNez+yM8IrfnW0TCodDEjRqf6fodf/Q==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />

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
<hr>
<!-- Charts -->
<div class="row" style="background-color:white">
  <div>
    <div class="col-md-7">
      <canvas id="pieChart" width="500" height="200"></canvas>
    </div>
    <div class="col-md-5">
      <canvas id="barChart" width="300" height="200"></canvas>
    </div>
  </div>
</div>
<!-- /Charts -->
<hr>
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
           <th>Tombo</th>
           <th>Especificações</th>
         </tr>
       </thead>
       <tbody>
         <?php foreach ($recent_equipments as  $r_e): ?>
         <tr>
           <td><?= remove_junk(first_character($r_e['tombo'])); ?></td>
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
           <th>Tombo</th>
           <th>Tipo de equipamento</th>
           <th>Usuário Responsável</th>
         </tr>
       </thead>
       <tbody>
         <?php foreach ($recent_loans as  $recent_loan): ?>
         <tr>
           <td><?= remove_junk(first_character($recent_loan['tombo'])); ?></td>
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

<script>
  var ctx = document.getElementById('pieChart');
  var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: ['PC', 'Notebook', 'AIO', 'AP', 'Switch', 'Estabilizador'],
          datasets: [{
              label: 'Equipamentos',
              data: [12, 19, 3, 5, 2, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1,
          }]
      },
  });


  // bar chart

  var ctx = document.getElementById('barChart');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Suafin', 'Seatran', 'Asplae', 'ASCOM', 'RH', 'Financeiro'],
        datasets: [{
            label: 'Empréstimos por Setor',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

<?php include_once('layouts/footer.php'); ?>
