<?php
session_start();
include("common/head_scripts.php");
include("common/components.php");

require 'utils/connection.php';
$conn = Connect();
if (!isset($_SESSION['login_user2'])) {
  header("location: customerlogin.php");
}
?>

<html>
<?= head("Payment") ?>

<body>
  <?= toTopBtn();
  navbar(); ?>

  <main class="py-5">

    <?php
    $gtotal = 0;
    foreach ($_SESSION["cart"] as $keys => $values) {

      $F_ID = $values["food_id"];
      $foodname = $values["food_name"];
      $quantity = $values["food_quantity"];
      $price =  $values["food_price"];
      $total = ($values["food_quantity"] * $values["food_price"]);
      $R_ID = $values["R_ID"];
      $username = $_SESSION["login_user2"];
      $order_date = date('Y-m-d');

      $gtotal = $gtotal + $total;


      $query = "INSERT INTO ORDERS (F_ID, foodname, price,  quantity, order_date, username, R_ID) 
              VALUES ('" . $F_ID . "','" . $foodname . "','" . $price . "','" . $quantity . "','" . $order_date . "','" . $username . "','" . $R_ID . "')";


      $success = $conn->query($query);

      if (!$success) {
    ?>
        <div class="container">
          <div class="jumbotron">
            <h1>Something went wrong!</h1>
            <p>Try again later.</p>
          </div>
        </div>

    <?php
      }
    }

    ?>
    <div class="container">
      <h3>Choose your payment option</h3>
      <hr>
      <br>
      <h1 class="text-center">Grand Total: &#8369;<?php echo "$gtotal"; ?></h1>
      <h5 class="text-center">including all service charges. (no delivery charges applied)</h5>
      <br>
      <h1 class="text-center">
        <a href="cart.php"><button class="btn btn-warning"><span class="bi-arrow-left-circle-fill"></span> Go back to cart</button></a>
        <a href="onlinepay.php"><button class="btn btn-success"><span class="bi-credit-card-fill"></span> Pay Online</button></a>
        <a href="COD.php"><button class="btn btn-success"><span class="bi-cash"></span> Cash On Delivery</button></a>
      </h1>
    </div>
  </main>
  <?= footer();
  scripts(); ?>

</body>

</html>