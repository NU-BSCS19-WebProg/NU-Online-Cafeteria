<?php
session_start();
require("utils/session_u.php");
include("common/head_scripts.php");
include("common/components.php");

if (!isset($_SESSION['login_user2'])) {
  header("location: customerlogin.php");
}
?>

<html>
<?= head("Online Payment") ?>

<body>
  <?= toTopBtn();
  navbar("cart"); ?>
  <main>
    <div class="container">
      <div class="row">
        <h1 class="text-center">Online Payment</h1>
        <p class="text-center">Enter your payment details below.</p>
      </div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="credit-card-div">
            <div class="panel panel-default">
              <div class="panel-heading">

                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <h5 class="text-muted"> Credit Card Number</h5>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <input type="text" class="form-control" placeholder="0000" required="" />
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <input type="text" class="form-control" placeholder="0000" required="" />
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <input type="text" class="form-control" placeholder="0000" required="" />
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <input type="text" class="form-control" placeholder="0000" required="" />
                  </div>
                </div>
                <br>
                <div class="row ">
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <span class="help-block text-muted small-font"> Expiry Month</span>
                    <input type="text" class="form-control" placeholder="MM" required="" />
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <span class="help-block text-muted small-font"> Expiry Year</span>
                    <input type="text" class="form-control" placeholder="YY" required="" />
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3">
                    <span class="help-block text-muted small-font"> CCV</span>
                    <input type="text" class="form-control" placeholder="CCV" required="" />
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-3"><br>
                    <img src="images/creditcard.png" class="img-rounded" required="" />
                  </div>
                </div>
                <br>
                <div class="row ">
                  <div class="col-md-12 pad-adjust">

                    <input type="text" class="form-control" placeholder="Name On The Card" required="" />
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12 pad-adjust">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" checked class="text-muted" required=""> Save details for fast payments. <a href="#">Learn More</a>
                      </label>
                    </div>
                  </div>
                </div>
                <div class="row ">
                  <div class="col-md-6 col-sm-6 col-xs-6 pad-adjust">
                    <a href="payment.php"><input type="submit" class="btn btn-danger btn-block" value="CANCEL" required="" /></a>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-6 pad-adjust">
                    <?php
                    if (isset($_POST)) {
                      $hidden_total = $_POST['hidden_total'];
                      $hidden_oid = $_POST['hidden_oid'];
                    }
                    ?>
                    <form action="COD.php" method="POST">
                      <input type="hidden" name="hidden_total" value="<?php echo $hidden_total ?>">
                      <input type="hidden" name="hidden_oid" value="<?php echo $hidden_oid ?>">
                      <input type="submit" class="btn btn-success btn-block" value="PAY NOW">
                    </form>
                  </div>
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </main>
  <?= footer();
  scripts(); ?>
</body>

</html>