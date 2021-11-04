<?php
session_start();
require("utils/session_u.php");
include("common/website_info.php");
include("common/head_scripts.php");
include("common/components.php");

if (!isset($_SESSION['login_user2'])) {
  header("location: customerlogin.php");
}

if (isset($_POST)) {
  $total_price = $_POST['hidden_total'];
  $o_id = $_POST['hidden_oid'];

  $query = "UPDATE orders SET paid = 1, total_price = $total_price WHERE O_ID = $o_id";
  mysqli_query($conn, $query);
}


?>

<html>
<?= head("COD") ?>

<body>
  <?= toTopBtn();
  navbar("cart"); ?>

  <main>
    <div class="container">
      <div class="card text-white bg-success mb-3 w-50 mx-auto">
        <div class="card-header">Success</div>
        <div class="card-body">
          <h5 class="card-title"><span class="bi-ok-circle"></span> Order Placed Successfully.</h5>
          <p class="card-text">Thank you for Ordering at <?= $website_name ?>! The ordering process is now complete.</p>
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