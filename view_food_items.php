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
  navbar("control");
  ?>
  <main>
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center">
          <?= adminSideBar("view-items"); ?>
        </div>
        <div class="col-md-8">
          <div class="form-area mx-lg-3">
            <form action="" method="POST">
              <br style="clear: both">
              <h3 class="text-center mb-4">FOOD ITEMS LIST</h3>
              <?php
              // Storing Session
              $user_check = $_SESSION['login_user1'];

              $sql = "SELECT * FROM food f WHERE f.R_ID IN (SELECT r.R_ID FROM RESTAURANTS r WHERE r.M_ID='$user_check') ORDER BY F_ID";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) {
              ?>
                <table class="table table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th>Description</th>
                      <th>Days Served</th>
                    </tr>
                  </thead>
                  <?PHP
                  //OUTPUT DATA OF EACH ROW
                  while ($row = mysqli_fetch_assoc($result)) {
                    $f_id = $row['F_ID'];
                    $query = "SELECT w.day_name FROM week w WHERE w.day_id IN (SELECT wi.day_id FROM weekly_items wi WHERE F_ID = $f_id)";
                  ?>
                    <tbody>
                      <tr>
                        <td><?php echo $f_id; ?></td>
                        <td><img src="<?php echo $row["images_path"]; ?>" alt="food img" class="rounded"></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td>Php <?php echo $row["price"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                        <td><?php $result2 = mysqli_query($conn, $query);
                            if ($result2 && mysqli_num_rows($result2) > 0) {
                              while ($row2 = mysqli_fetch_assoc($result2)) {
                                echo $row2['day_name'] . " ";
                              }
                            } ?></td>
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