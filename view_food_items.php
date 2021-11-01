<?php
include('utils/session_m.php');
include("common/head_scripts.php");
include("common/components.php");


if (!isset($login_session)) {
  header('Location: managerlogin.php'); // Redirecting To Home Page
}

?>
<!DOCTYPE html>
<html>
<?= head("Manage Food Items") ?>

<body>
  <?=
  toTopBtn();
  navbar();
  ?>
  <main class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center">
          <?= adminSideBar("view-items"); ?>
        </div>
        <div class="col-md-8">
          <div class="form-area px-lg-5 mx-lg-5">
            <form action="" method="POST">
              <br style="clear: both">
              <h3 class="text-center mb-4">YOUR FOOD ITEMS LIST</h3>
              <?php
              // Storing Session
              $user_check = $_SESSION['login_user1'];
              $sql = "SELECT * FROM food f WHERE f.R_ID IN (SELECT r.R_ID FROM RESTAURANTS r WHERE r.M_ID='$user_check') ORDER BY F_ID";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
              ?>
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th> </th>
                      <th> Food ID </th>
                      <th> Food Name </th>
                      <th> Price </th>
                      <th> Description </th>
                      <th> Restaurant ID </th>
                    </tr>
                  </thead>
                  <?PHP
                  //OUTPUT DATA OF EACH ROW
                  while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <tbody>
                      <tr>
                        <td> <span class="glyphicon glyphicon-menu-right"></span> </td>
                        <td><?php echo $row["F_ID"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                        <td><?php echo $row["R_ID"]; ?></td>
                      </tr>
                    </tbody>
                  <?php } ?>
                </table>
                <br>
              <?php } else { ?>
                <h4 class="text-center">0 RESULTS</h4>
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