<?php
session_start();
require('utils/session_u.php');
require_once 'utils/cart_count.php';
include("common/head_scripts.php");
include("common/components.php");
include_once("common/website_info.php");

if (!isset($_SESSION['login_user2'])) {
  header("location: customerlogin.php");
}

$response = "";
$error = "";

$query = "SELECT SUM(price * quantity) FROM order_items WHERE O_ID = " . getUserOrderID();
$result = $conn->query($query);
if ($result)
  $gtotal = mysqli_fetch_row($result)[0];
else
  echo 'something went wrong';

if (isset($_POST["checkout"])) {
  if (is_numeric($_POST["phone"])) {
    $o_id =  getUserOrderID(); //save before it gets lost
    $query = "UPDATE orders SET paid = 1, total_price = $gtotal, date_placed = CURRENT_TIMESTAMP WHERE O_ID = $o_id";
    mysqli_query($conn, $query);
    $response = "success";
  } else {
    $error = "Enter a valid number."; 
  }
}

?>

<html>
<?= head("Payment") ?>

<body>
  <?= toTopBtn();
  navbar("cart"); ?>

  <!-- ======= Success Modal ======= -->
  <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-success">Success</h5>
        </div>
        <div class="modal-body">
          <h5><span class="bi-ok-circle"></span> Order Placed Successfully.</h5>
          <p class="card-text">Thank you for Ordering at <?= $website_name ?>! The ordering process is now complete.</p>
          <strong>Your Order Number: <span class="text-success"><?php echo $o_id ?></span></strong>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success"><a href="index.php">Okay</a></button>
        </div>
      </div>
    </div>
  </div>
  <!-- End success modal -->

  <main>
    <div class="container">
      <h3>Choose your payment option</h3>
      <hr>
      <div class="row pt-3">
        <div class="col-lg-5 shadow p-5 rounded">
          <form action="" method="POST" class="payment">
            <input type="radio" class="btn-check" name="payment" id="gcash" autocomplete="off" required>
            <label class="radio btn btn-outline-primary border me-2" for="gcash"><img src="images/gcash.png" alt="logo" class="rounded me-2"> Gcash E-Wallet</label>

            <input type="radio" class="btn-check" name="payment" id="paymaya" autocomplete="off" required>
            <label class="radio btn btn-outline-primary border" for="paymaya"><img src="images/paymaya.png" alt="logo" class="rounded me-2"> Paymaya E-Wallet</label>

            <label for="exampleFormControlInput1" class="form-label mt-4">Enter e-wallet number:</label>
            <input type="tel" class="form-control" name="phone" id="phone" required>

            <label class="text-danger"><span> <?php echo $error; ?> </span></label> <br>

            <input type="submit" name="checkout" class="btn btn-success mt-4" value="PAY AND PLACE ORDER NOW">
          </form>
        </div>
        <div class="col-lg-7 px-5">
          <h5><strong>Order Summary</strong></h5>
          <table class="table">
            <thead>
              <tr>
                <td><strong>#</strong></td>
                <td>Item</td>
                <td>Restaurant</td>
                <td>Quantity</td>
                <td>Total</td>
              </tr>
            </thead>
            <tbody>
              <?php
              $query = "SELECT a.quantity, a.foodname, a.price, b.name  FROM order_items a, restaurants b WHERE a.R_ID = b.R_ID AND a.O_ID = " . getUserOrderID();
              $result = $conn->query($query);
              if ($result && mysqli_num_rows($result) > 0) {
                $item_num = 1;
                while ($row = mysqli_fetch_assoc($result)) { ?>
                  <tr>
                    <td><strong><?php echo $item_num ?></strong></td>
                    <td><?php echo $row['foodname'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['quantity'] ?></td>
                    <td>Php <?php echo $row['price'] * $row['quantity'] ?></td>
                  </tr>
              <?php
                  $item_num++;
                }
              } ?>
            </tbody>
          </table>
          <h1 class="pt-3">Order Total: &#8369;<?php echo "$gtotal"; ?></h1>
          <a href="cart.php" class="btn btn-warning"><span class="bi-arrow-left-circle-fill"></span> Go back to cart</a>
        </div>
      </div>
    </div>
  </main>
  <?= footer();
  scripts(); ?>

  <script>
    var response = "<?php echo $response ?>";
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    if (response == "success") {
      successModal.show();
    }
  </script>

</body>

</html>