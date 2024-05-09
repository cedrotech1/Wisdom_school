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
              <h5 class="card-title">add trainnes form</h5>
              <form class="row g-3" method='post' action="trainnees.php">
            
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" placeholder="candidate first name" name='fname'>
                    <label for="floatingName">first name</label>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="floatingName" placeholder="candidate last name" name='lname'>
                    <label for="floatingName">last name</label>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-floating">
                  <select class="form-select" id="floatingSelect" name='gender' aria-label="State">
                   <option value="male">male</option>
                   <option value="female">female</option>
      
                  </select>
                    <label for="floatingName">gender</label>
                  </div>
                </div>

                <div class="form-floating mb-3">
                  <select class="form-select" id="floatingSelect" name='tid' aria-label="State">
                    <?php
                    include ("connection.php");

                    $result = mysqli_query($connection, "select * from trade");
                    while ($row = mysqli_fetch_array($result)) {
                      ?>
                      <option value="<?php echo $row['0']; ?>"><?php echo $row['1']; ?></option>
                    
                      <?php

                    }
                    ?>

                  </select>
                  <label for="floatingSelect">trade</label>
                </div>

               

          
        

       

                <div class="text-center">
                  <button type="submit" class="btn btn-primary" name='submit'>Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End floating Labels Form -->


            </div>
          </div>

        </div>

        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">list of trainees</h5>
              <table class='table'>

              <tr>
                  <td>id</td><td>first name</td><td>last name</td><td>gender</td><td>trade</td>
                </tr>
                <?php
                include ("connection.php");

                $result = mysqli_query($connection, "SELECT trainees.Trainee_Id,trainees.FirstNames,trainees.LastName,trainees.Gender,trade.Trade_Name 
                FROM trainees,trade WHERE trainees.Trade_Id=trade.Trade_Id");
                while ($row = mysqli_fetch_array($result)) {
                  ?>
                  <tr>
                    <td><?php echo $row['0']; ?></td>
                    <td><?php echo $row['1']; ?></td>
                    <td><?php echo $row['2']; ?></td>
                    <td><?php echo $row['3']; ?></td>
                    <td><?php echo $row['4']; ?></td>
                    <td>
                    <a href="delete.php?id=<?php echo $row['0']; ?>">
                      <button class='btn btn-danger'>delete</button>
                      </a>
                    </td>    </tr>
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

include("connection.php");
if (isset($_POST["submit"])) {
  // Get form data

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $gender = $_POST['gender'];
  $tid = $_POST['tid'];


  // Perform the SQL query
  $result = mysqli_query($connection,"
  INSERT INTO `trainees`(`Trainee_Id`, `FirstNames`, `LastName`, `Gender`, `Trade_Id`) 
  VALUES (null,'$fname','$lname','$gender','$tid')
  ");
  if ($result) {
      echo "<script>window.location.href='trainnees.php'</script>";
      echo"done";
  } else {
      echo "Error: " . mysqli_error($connection);
  }
}
