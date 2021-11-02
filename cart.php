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
<?= head("Cart"); ?>

<body>
  <?=
  toTopBtn();
  navbar();
  ?>
  <main>
    <?php
    if (!empty($_SESSION["cart"])) {
    ?>
      <div class="container">
        <div class="jumbotron">
          <h1>Your Shopping Cart</h1>
        </div>

      </div>
      <div class="table-responsive" style="padding-left: 100px; padding-right: 100px;">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th width="40%">Food Name</th>
              <th width="10%">Quantity</th>
              <th width="20%">Price Details</th>
              <th width="15%">Order Total</th>
              <th width="5%">Action</th>
            </tr>
          </thead>


          <?php

          $total = 0;
          foreach ($_SESSION["cart"] as $keys => $values) {
          ?>
            <tr>
              <td><?php echo $values["food_name"]; ?></td>
              <td><?php echo $values["food_quantity"] ?></td>
              <td>&#8369; <?php echo $values["food_price"]; ?></td>
              <td>&#8369; <?php echo number_format($values["food_quantity"] * $values["food_price"], 2); ?></td>
              <td><a href="cart.php?action=delete&id=<?php echo $values["food_id"]; ?>"><span class="text-danger">Remove</span></a></td>
            </tr>
          <?php
            $total = $total + ($values["food_quantity"] * $values["food_price"]);
          }
          ?>
          <tr>
            <td colspan="3" align="right">Total</td>
            <td align="right">&#8369; <?php echo number_format($total, 2); ?></td>
            <td></td>
          </tr>
        </table>
        <?php
        echo '<a href="cart.php?action=empty"><button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Empty Cart</button></a>&nbsp;<a href="foodlist.php"><button class="btn btn-warning">Continue Shopping</button></a>&nbsp;<a href="payment.php"><button class="btn btn-success pull-right"><span class="glyphicon glyphicon-share-alt"></span> Check Out</button></a>';
        ?>
      </div>
      <br><br><br><br><br><br><br>
    <?php
    }
    if (empty($_SESSION["cart"])) {
    ?>
      <div class="container">
        <div class="jumbotron">
          <h1>Your Shopping Cart</h1>
          <p>The cart is empty. Go back and <a href="foodlist.php">order now.</a></p>

        </div>

      </div>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <?php
    }
    ?>


    <?php


    if (isset($_POST["add"])) {
      if (isset($_SESSION["cart"])) {
        $item_array_id = array_column($_SESSION["cart"], "food_id");
        if (!in_array($_GET["id"], $item_array_id)) {
          $count = count($_SESSION["cart"]);

          $item_array = array(
            'food_id' => $_GET["id"],
            'food_name' => $_POST["hidden_name"],
            'food_price' => $_POST["hidden_price"],
            'R_ID' => $_POST["hidden_RID"],
            'food_quantity' => $_POST["quantity"]
          );
          $_SESSION["cart"][$count] = $item_array;
          echo '<script>window.location="cart.php"</script>';
        } else {
          echo '<script>alert("Products already added to cart")</script>';
          echo '<script>window.location="cart.php"</script>';
        }
      } else {
        $item_array = array(
          'food_id' => $_GET["id"],
          'food_name' => $_POST["hidden_name"],
          'food_price' => $_POST["hidden_price"],
          'R_ID' => $_POST["hidden_RID"],
          'food_quantity' => $_POST["quantity"]
        );
        $_SESSION["cart"][0] = $item_array;
      }
    }
    if (isset($_GET["action"])) {
      if ($_GET["action"] == "delete") {
        foreach ($_SESSION["cart"] as $keys => $values) {
          if ($values["food_id"] == $_GET["id"]) {
            unset($_SESSION["cart"][$keys]);
            echo '<script>alert("Food has been removed")</script>';
            echo '<script>window.location="cart.php"</script>';
          }
        }
      }
    }

    if (isset($_GET["action"])) {
      if ($_GET["action"] == "empty") {
        foreach ($_SESSION["cart"] as $keys => $values) {

          unset($_SESSION["cart"]);
          echo '<script>alert("Cart is made empty!")</script>';
          echo '<script>window.location="cart.php"</script>';
        }
      }
    }
    ?>
  </main>
  <?=
  footer();
  scripts();
  ?>
</body>

</html>