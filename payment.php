<?php
session_start();
require('utils/session_u.php');
include("common/head_scripts.php");
include("common/components.php");

// require 'utils/connection.php';
// $conn = Connect();
if (!isset($_SESSION['login_user2'])) {
  header("location: customerlogin.php");
}

$query = "SELECT SUM(price * quantity) FROM order_items WHERE O_ID = " . $_GET['o_id'];
$result = $conn->query($query);
if ($result)
  $gtotal = mysqli_fetch_row($result)[0];
else
  echo 'something went wrong';

?>

<html>
<?= head("Payment") ?>

<body>
  <?= toTopBtn();
  navbar("cart"); ?>

  <main>
    <div class="container">
      <h3>Choose your payment option</h3>
      <hr>
      <h1 class="text-center">Grand Total: &#8369;<?php echo "$gtotal"; ?></h1>
      <h5 class="text-center">All service charges included.</h5>
      <br>
      <div class="text-center">
        <a href="cart.php" class="btn btn-warning"><span class="bi-arrow-left-circle-fill"></span> Go back to cart</a>
        <form action="onlinepay.php" method="POST">
          <input type="hidden" name="hidden_total" value="<?php echo $gtotal ?>">
          <input type="hidden" name="hidden_oid" value="<?php echo $_GET['o_id']?>">
          <input type="submit" class="btn btn-success" value="Pay Online">
        </form>
        <!-- <a href="COD.php"><button class="btn btn-success"><span class="bi-cash"></span> Pay at the Counter</button></a> -->
      </div>
    </div>
  </main>
  <?= footer();
  scripts(); ?>

</body>

</html>