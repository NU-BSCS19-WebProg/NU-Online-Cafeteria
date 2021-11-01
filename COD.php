<?php
session_start();
include("common/website_info.php");
include("common/head_scripts.php");
include("common/components.php");

require 'utils/connection.php';
$conn = Connect();
if (!isset($_SESSION['login_user2'])) {
  header("location: customerlogin.php");
}

unset($_SESSION["cart"]);
?>

<html>
<?= head("COD") ?>

<body>
  <?= toTopBtn();
  navbar(); ?>

  <main class="py-5">
    <div class="container">
      <div class="card text-white bg-success mb-3 w-50 mx-auto">
        <div class="card-header">Success</div>
        <div class="card-body">
          <h5 class="card-title"><span class="glyphicon glyphicon-ok-circle"></span> Order Placed Successfully.</h5>
          <p class="card-text">Thank you for Ordering at <?=$website_name?>! The ordering process is now complete.</p>
          <?php
          $num1 = rand(100000, 999999);
          $num2 = rand(100000, 999999);
          $num3 = rand(100000, 999999);
          $number = $num1 . $num2 . $num3;
          ?>
          <p class="card-text"><strong>Your Order Number:</strong> <span class="text-info"><?php echo "$number"; ?></span> </p>
        </div>
      </div>
    </div>
  </main>

  <?= footer();
  scripts(); ?>

</body>

</html>