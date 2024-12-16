<?php
session_start();
include_once 'includes/connect.php';
include_once 'includes/classes/classes.php';

$object = new login($connect);

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  $object->collectInputs();

  if (!$object->authorizeFromAdmin()) {
    $object->authorizeFromStudent();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link
    rel="apple-touch-icon"
    sizes="76x76"
    href="./assets/img/apple-icon.png" />
  <link rel="icon" type="image/png" href="./assets/img/favicon.png" />
  <title>Clearance System</title>
  <!--     Fonts and icons     -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
    rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script
    src="https://kit.fontawesome.com/42d5adcbca.js"
    crossorigin="anonymous"></script>
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link
    id="pagestyle"
    href="./assets/css/soft-ui-dashboard.css?v=1.0.3"
    rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <section class="min-vh-100 mb-8">
    <div
      class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
      style="
          background-image: url('./assets/img/curved-images/curved14.jpg');
        ">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Clearance System</h1>
            <p class="text-white">Enter your Credentials to get started!</p>
            <small class="text-danger text-center"><?php echo $object->login_err; ?></small>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-body">
              <form role="form text-left" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" autocomplete="on">
                <div class="mb-3">
                  <input
                    type="text" name="email_matric_no"
                    class="form-control"
                    placeholder="Email or Matric No"
                    aria-label="Matric No" />
                </div>
                <div class="mb-3">
                  <input
                    type="password" name="password"
                    class="form-control"
                    placeholder="Password"
                    aria-label="Password"
                    aria-describedby="password-addon" />
                </div>
                <div class="text-center">
                  <button
                    type="submit"
                    class="btn bg-gradient-dark w-100 my-4 mb-2">
                    Sign in
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf("Win") > -1;
    if (win && document.querySelector("#sidenav-scrollbar")) {
      var options = {
        damping: "0.5",
      };
      Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
</body>

</html>