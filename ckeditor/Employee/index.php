<?php
session_start();
include "./../include/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

   $email = $_POST["email"];
   $password = $_POST["password"];

   $query = "SELECT id, password FROM employee WHERE email = '$email'";
   $result = mysqli_query($conn, $query);

   if ($result && mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
      $storedPassword = $row["password"];

      if ($password === $storedPassword) {
         $_SESSION["user_id"] = $row["id"];
         $status = "1";
         $date = date("d-m-y");
         $lognow = date('H:i:s');

         $existingAttendanceQuery = "SELECT id FROM attendance WHERE employee_id = '$email' AND date = '$date'";
         $existingAttendanceResult = mysqli_query($conn, $existingAttendanceQuery);

         if (mysqli_num_rows($existingAttendanceResult) === 0) {
            $query = "INSERT INTO attendance (employee_id, date, time_in, status) 
                        VALUES ('$email', '$date', NOW(), '$status')";
            $result = mysqli_query($conn, $query);
            if ($result) {
               header("Location: dashboard.php");
               exit;
            } else {
               $_SESSION['error'] = 'Error: Unable to insert attendance data.';
               header('Location: index.php');
               exit;
            }
         } else {
            header('Location: dashboard.php');
            exit;
         }
      } else {
         $_SESSION['error'] = 'Incorrect email and password, Try again';
         header('Location: index.php');
         exit;
      }
   } else {
      $_SESSION['error'] = 'Incorrect email and password, Try again';
      header('Location: index.php');
      exit;
   }
}
?>

<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>MINE | Jiffy</title>
   <!-- Favicon -->
   <link rel="shortcut icon" href="./../assets/images/favicon.ico" />
   <link rel="stylesheet" href="./../assets/css/backend-plugin.min.css">
   <link rel="stylesheet" href="./../assets/css/style.css">
   <link rel="stylesheet" href="./../assets/css/custom.css">
   <link rel="stylesheet" href="./../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
   <link rel="stylesheet" href="./../assets/vendor/remixicon/fonts/remixicon.css">
   <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
   <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
   <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
</head>

<body class=" ">
   <!-- loader Start -->
   <div id="loading">
      <div id="loading-center">
      </div>
   </div>
   <!-- loader END -->

   <div class="wrapper">
      <section class="login-content">
         <div class="container">
            <div class="row align-items-center justify-content-center height-self-center">
               <div class="col-lg-8">
                  <div class="card auth-card">
                     <div class="card-body p-0">
                        <div class="d-flex align-items-center auth-content">
                           <div class="col-lg-6 bg-primary content-left">
                              <div class="p-3">
                                 <img src="./../assets/images/Jiffy-logo.png" alt="Image description" class="img-fluid mb-3">
                                 <h2 class="mb-2 text-white text-center">Sign In</h2>
                                 <p class="text-center">Login to stay connected.</p>

                                 <?php
                                 if (isset($_SESSION['error'])) {
                                    echo "<div class='alert text-white bg-warning' role='alert'>
                                                         <div class='iq-alert-text'>" . $_SESSION['error'] . "</div>
                                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                            <i class='ri-close-line'></i>
                                                         </button>
                                                   </div>";
                                    unset($_SESSION['error']);
                                 }
                                 ?>

                                 <form method="POST">
                                    <div class="row">
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="email" placeholder=" " name="email">
                                             <label>Email</label>
                                          </div>
                                       </div>
                                       <div class="col-lg-12">
                                          <div class="floating-label form-group">
                                             <input class="floating-input form-control" type="password" placeholder=" " name="password">
                                             <label>Password</label>
                                          </div>
                                       </div>
                                    </div>

                                    <button type="submit" class="custom-btn btn-3 text-center">Sign In</button>

                                 </form>
                              </div>
                           </div>

                           <div class="col-lg-6 content-right">
                              <img src="./../assets/images/login/01.png" class="img-fluid image-right" alt="">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>

   <!-- Backend Bundle JavaScript -->
   <script src="./../assets/js/backend-bundle.min.js"></script>
   <!-- Table Treeview JavaScript -->
   <script src="./../assets/js/table-treeview.js"></script>
   <!-- Chart Custom JavaScript -->
   <script src="./../assets/js/customizer.js"></script>
   <!-- Chart Custom JavaScript -->
   <script async src="./../assets/js/chart-custom.js"></script>
   <!-- Chart Custom JavaScript -->
   <script async src="./../assets/js/slider.js"></script>
   <!-- app JavaScript -->
   <script src="./../assets/js/app.js"></script>
   <script src="./../assets/vendor/moment.min.js"></script>
   <script>
      const error = "<?php echo isset($_SESSION['error']) ? $_SESSION['error'] : ''; ?>";
      if (error) {
         alert(error);
      }
   </script>
</body>

</html>