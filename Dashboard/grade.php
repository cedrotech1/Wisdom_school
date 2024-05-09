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
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">add grade form</h5>
              <form class="row g-3" method='post' action="grade.php">
              <div class="form-floating mb-3">
                  <select class="form-select" id="floatingSelect" name='t' aria-label="State">
                    <?php
                    include ("connection.php");

                    $result = mysqli_query($connection, "select * from trainees");
                    while ($row = mysqli_fetch_array($result)) {
                      ?>
                      <option value="<?php echo $row['0']; ?>"><?php echo $row['1']." ". $row['2']; ?></option>
                    
                      <?php

                    }
                    ?>

                  </select>
                  <label for="floatingSelect">select trainees</label>
                </div>
    

                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" placeholder="module name" name='mname'>
                    <label for="floatingName">module name</label>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="floatingName" placeholder="Formative_Assessment" name='Formative_Assessment'>
                    <label for="floatingName">Formative_Assessment</label>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="floatingName" placeholder="Summative_Assessment" name='Summative_Assessment'>
                    <label for="floatingName">Summative_Assessment</label>
                  </div>
                </div>
            </div>
    
            <div class="text-center">
              <button type="submit" class="btn btn-primary" name='submit'>Submit</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
            </form><!-- End floating Labels Form -->


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
      echo "<script>alert('marks recorded successfully')</script>";
    }
  } else {
    echo "<script>alert('invarid marks')</script>";
  }

}


?>