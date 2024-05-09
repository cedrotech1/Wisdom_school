<?php
session_start();
$_SESSION['user'];
if(!isset($_SESSION['user'])){
  header("Location: ../login.php");

}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">


</head>

<body>
  <?php
  include ("header.php");
  include ("asidemenu.php");

  ?>




  <main id="main" class="main">


    <section class="section">
    

      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">list of marks</h5>
            <table class='table'>
              <tr>
                <td>no</td>
                <td>NAMES</td>
                <td>trade</td>
                <td>module</td>
                <td>Formative_Assessment</td>
                <td>Summative_Assessment</td>
                <td>total</td>
                <td>DECISION</td>
              </tr>

              <?php
              include ("connection.php");
              $i=0;

              $result = mysqli_query($connection, "SELECT trainees.FirstNames,trainees.LastName,trade.Trade_Name,marks.Module_Name,marks.Formative_Assessment,marks.Summative_Assessment,marks.Total_Marks,marks.decision FROM trainees,trade,marks where marks.Trainee_Id=trainees.Trainee_Id and trainees.Trade_Id=trade.Trade_Id");
              while ($row = mysqli_fetch_array($result)) {
                $i++;
                ?>
                <tr>
                  <td><?php echo $i ?></td>
                  <td><?php echo $row['0'] . " " . $row['1'];
                  ; ?></td>

                  <td><?php echo $row['2']; ?></td>
                  <td><?php echo $row['3']; ?></td>
                  <td><?php echo $row['4']; ?></td>
                  <td><?php echo $row['5']; ?></td>
                  <td><?php echo $row['6']; ?></td>
                  <td><?php echo $row['7']; ?></td>

            
                </tr>
                <?php

              }




              ?>

            </table>

          </div>
        </div>

      </div>
      </div>
    </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>

<?php
include ("connection.php");
if (isset($_POST["submit"])) {
  $t = $_POST['t'];
  $tid = $_POST['tid'];
  $Formative_Assessment = intval($_POST['Formative_Assessment']);
  $Summative_Assessment = intval($_POST['Summative_Assessment']);
  $total=$Formative_Assessment+$Summative_Assessment;
  $mname = $_POST['mname'];

  $decision = '';
  if ($Formative_Assessment >50) {
    $decision = 'invalid';
  }
  if ($Summative_Assessment >50) {
    $decision = 'invalid';
  }
  if ($Formative_Assessment < 0) {
    $decision = 'invalid';
  }
  if ($Summative_Assessment < 0) {
    $decision = 'invalid';
  }
  if ($total >= 0 && $total < 70) {
    $decision = 'not yet competent';
  } else {
    $decision = 'competent';

  }
  if ($decision != "invalid") {
    $result = mysqli_query($connection,
     "INSERT INTO `marks`(`Trainee_Id`, `Trade_Id`, `Module_Name`, `Formative_Assessment`, `Summative_Assessment`, `Total_Marks`, `decision`)
     VALUES ($t,'','$mname','$Formative_Assessment','$Summative_Assessment','$total','$decision')");
    if ($result) {
      echo "<script>window.location.href='grade.php'</script>";

    }
  } else {
    echo "<script>alert('invarid marks')</script>";
  }

}


?>