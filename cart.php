<?php
session_start();
include('utils/session_u.php');
include("common/head_scripts.php");
include("common/components.php");

// require 'utils/connection.php';
// $conn = Connect();
if (!isset($_SESSION['login_user2'])) {
  header("location: customerlogin.php");
}
$response = "";
?>

<html>
<?= head("Cart"); ?>

<body>
  <?=
  toTopBtn();
  navbar("cart");
  ?>

  <?php
  if (isset($_POST['add'])) {
    $O_ID = getUserOrderID();
    $F_ID = $_GET['id'];
    $food_name = $_POST['hidden_name'];
    $food_price = $_POST['hidden_price'];
    $R_ID = $_POST["hidden_RID"];
    $food_quantity = $_POST['quantity'];

    //check if this item has already been added to cart
    $query = "SELECT * FROM order_items WHERE O_ID = $O_ID AND F_ID = $F_ID";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
      $row =  mysqli_fetch_assoc($result);
      $OI_ID = $row['order_item_ID'];
      $old_quantity = $row['quantity'];
      $new_quantity = $food_quantity + $old_quantity;
      $query = "UPDATE order_items SET quantity = $new_quantity WHERE order_item_ID = $OI_ID";
      mysqli_query($conn, $query);
      header("Location: cart.php");
      die;
    }

    $OI_total_price = $food_price * $food_quantity;
    $username = $login_session;

    $query = "INSERT INTO order_items (O_ID, F_ID, foodname, quantity, username, R_ID) VALUES ($O_ID, $F_ID, '$food_name', $food_quantity, '$username', $R_ID)";
    mysqli_query($conn, $query);
    //$response = "success";
    header("Location: cart.php");
    die;
  }

  if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
      $query = "DELETE FROM order_items WHERE order_item_ID = " . $_GET['id'];
      mysqli_query($conn, $query);
      $response = "deleted";
    }
  }

  if (isset($_GET["action"])) {
    if ($_GET["action"] == "empty") {
      $query = "DELETE FROM order_items WHERE O_ID = " . getUserOrderID();
      mysqli_query($conn, $query);
      $response = "emptied";
    }
  }

  ?>

  <!-- ======= Success Modal ======= -->
  <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-success">Success</h5>
        </div>
        <div class="modal-body">
          <p><?php echo $food_name ?> has been added.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"><a href="cart.php">Okay</a></button>
        </div>
      </div>
    </div>
  </div>
  <!-- End success modal -->

  <!-- ======= Deleted Modal ======= -->
  <div class="modal fade" id="deletedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Deleted</h5>
        </div>
        <div class="modal-body">
          <p>Item has been deleted.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"><a href="cart.php">Okay</a></button>
        </div>
      </div>
    </div>
  </div>
  <!-- End deleted modal -->


  <!-- ======= Emptied Modal ======= -->
  <div class="modal fade" id="emptiedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Cart is emptied</h5>
        </div>
        <div class="modal-body">
          <p>All contents of car has been deleted.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"><a href="cart.php">Okay</a></button>
        </div>
      </div>
    </div>
  </div>
  <!-- End emptied modal -->

  <main>
    <?php
    if (getCartCount() !== 0) {
      $O_ID = getUserOrderID();
      $query = "SELECT a.id, a.quantity, b.item_name, b.price FROM order_items a, food_items b WHERE a.O_ID = $O_ID AND a.item_id = b.id";
      $result = mysqli_query($conn, $query);
    ?>
      <div class="container">
        <div class="row">
          <div class="col-lg-9">
            <h1>Your Shopping Cart</h1>

            <table class="table table-striped">
              <thead class="thead-dark">
                <tr>
                  <th width="40%">Food Name</th>
                  <th width="10%">Quantity</th>
                  <th width="20%">Item Price</th>
                  <th width="15%">Item(s) Total Price</th>
                  <th width="5%">Delete</th>
                </tr>
              </thead>
              <?php
              $total = 0;
              $query = "SELECT a.order_item_ID, a.quantity, b.F_ID, b.name, a.price FROM order_items a, food b WHERE a.F_ID = b.F_ID AND O_ID = " . getUserOrderID();
              $result = $conn->query($query);
              if ($result && mysqli_num_rows($result) > 0) {
                while ($values = mysqli_fetch_assoc($result)) {
              ?>
                  <tr>
                    <td><?php echo $values["name"]; ?></td>
                    <td><?php echo $values["quantity"] ?></td>
                    <td>&#8369; <?php echo $values["price"]; ?></td>
                    <td>&#8369; <?php echo number_format($values["quantity"] * $values["price"], 2); ?></td>
                    <td><a href="cart.php?action=delete&id=<?php echo $values["order_item_ID"]; ?>"><span class="text-danger">Remove</span></a></td>
                  </tr>
              <?php
                  $total = $total + ($values["quantity"] * $values["price"]);
                }
              }
              ?>
              <tr>
                <td colspan="3" align="right">Total</td>
                <td align="right">&#8369; <?php echo number_format($total, 2); ?></td>
                <td></td>
              </tr>
            </table>
            <?php
            echo '<a href="cart.php?action=empty"><button class="btn btn-danger"><span class="bi-trash"></span> Empty Cart</button></a>&nbsp;<a href="foodlist.php?id=' . setDayIDURL() . '"><button class="btn btn-warning">Continue Shopping</button></a>&nbsp;<a href="payment.php"><button class="btn btn-success pull-right"><span class="glyphicon glyphicon-share-alt"></span> Check Out</button></a>';
            ?>

          <?php
        }
        if (getCartCount() < 1) {
          ?>
            <div class="container">
              <h1>Your Shopping Cart</h1>
              <p>The cart is empty. Go back and <a href="foodlist.php?id=<?php echo setDayIDURL() ?>">order now.</a></p>
            </div>
          <?php
        }
          ?>
          </div>
        </div>
      </div>
  </main>
  <?=
  footer();
  scripts();
  ?>

  <script>
    var response = "<?php echo $response ?>";
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    var deleteModal = new bootstrap.Modal(document.getElementById('deletedModal'));
    var emptiedModal = new bootstrap.Modal(document.getElementById('emptiedModal'));
    if (response == "success") {
      successModal.show();
    } else if (response === "deleted") {
      deleteModal.show();
    } else if (response === "emptied") {
      emptiedModal.show();
    }
  </script>
</body>

</html>