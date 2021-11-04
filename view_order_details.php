<?php
include('utils/session_m.php');
include("common/head_scripts.php");
include("common/components.php");

if (!isset($login_session)) {
  header('Location: managerlogin.php');
}

?>
<!DOCTYPE html>
<html>
<?= head("Manage Orders") ?>

<body>
  <?= toTopBtn();
  navbar("control"); ?>
  <main>
    <div class="container">
      <div class="row">
      <div class="col-md-4 text-center">
          <?= adminSideBar("orders"); ?>
        </div>
        <div class="col-md-8">
          <div class="form-area px-lg-5 mx-lg-5">
            <form action="" method="POST">
              <br style="clear: both">
              <h3 class="text-center mb-4">CUSTOMER ORDERS LIST</h3>
              <?php
              // Storing Session
              $user_check = $_SESSION['login_user1'];
              // $sql = "SELECT * FROM order_items o WHERE o.R_ID IN (SELECT r.R_ID FROM RESTAURANTS r WHERE r.M_ID='$user_check') ORDER BY date_placed";
              $sql = "SELECT o.*, b.paid FROM order_items o JOIN orders b ON o.O_ID = b.O_ID WHERE o.R_ID IN (SELECT r.R_ID FROM RESTAURANTS r WHERE r.M_ID='$user_check') AND b.paid = 1;";
              $result = mysqli_query($conn, $sql);
              if ($result && mysqli_num_rows($result) > 0) {
              ?>

                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th> </th>
                      <th> Order ID </th>
                      <th> Food ID </th>
                      <!-- <th> Order Date </th> -->
                      <th> Food Name </th>
                      <th> Price </th>
                      <th> Quantity </th>
                      <th> Customer </th>
                    </tr>
                  </thead>

                  <?PHP
                  //OUTPUT DATA OF EACH ROW
                  while ($row = mysqli_fetch_assoc($result)) {
                  ?>

                    <tbody>
                      <tr>
                        <td> <span class="bi-menu-right"></span> </td>
                        <td><?php echo $row["O_ID"]; ?></td>
                        <td><?php echo $row["F_ID"]; ?></td>
                        <!-- <td><?php echo $row["order_date"]; ?></td> -->
                        <td><?php echo $row["foodname"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo $row["quantity"]; ?></td>
                        <td><?php echo $row["username"]; ?></td>

                      </tr>
                    </tbody>

                  <?php } ?>
                </table>
                <br>


              <?php } else { ?>

                <h4 class="text-center">
                  0 RESULTS
                </h4>
              <?php } ?>

            </form>


          </div>

        </div>
      </div>
    </div>
  </main>

  <?= footer();
  scripts(); ?>
</body>

</html>