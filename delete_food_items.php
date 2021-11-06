<?php
include('utils/session_m.php');
include("common/head_scripts.php");
include("common/components.php");

if (!isset($login_session)) {
  header('Location: managerlogin.php'); // Redirecting To Home Page
}

$response = "";

if (isset($_POST['delete'])) {
  $cheks = implode("','", $_POST['checkbox']);
  $sql = "DELETE FROM food WHERE F_ID in ('$cheks')";
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  $response = "deleted";
}

?>
<!DOCTYPE html>
<html>
<?= head("Delete Food Item") ?>

<body>
  <?= toTopBtn();
  navbar("control"); ?>

  <!-- ======= Deleted Modal ======= -->
  <div class="modal fade" id="deletedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Deleted</h5>
        </div>
        <div class="modal-body">
          <p>Item(s) has been deleted.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary"><a href="delete_food_items.php">Okay</a></button>
        </div>
      </div>
    </div>
  </div>
  <!-- End deleted modal -->

  <main>
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center admin-side-bar">
          <?= adminSideBar("delete"); ?>
        </div>
        <div class="col-md-8">
          <div class="form-area mx-lg-5">
            <form action="" method="POST">
              <br style="clear: both">
              <h3 class="text-center mb-4">DELETE FOOD ITEMS</h3>
              <?php
              // Storing Session
              $user_check = $_SESSION['login_user1'];
              $sql = "SELECT * FROM food f WHERE f.R_ID IN (SELECT r.R_ID FROM RESTAURANTS r WHERE r.M_ID='$user_check') ORDER BY F_ID";
              $result = mysqli_query($conn, $sql);
              if (mysqli_num_rows($result) > 0) { ?>
                <table class="table table-striped">
                  <thead class="thead-dark">
                    <tr>
                      <th> # </th>
                      <th> ID </th>
                      <th> Name </th>
                      <th> Price </th>
                      <th> Description </th>
                    </tr>
                  </thead>

                  <?PHP
                  //OUTPUT DATA OF EACH ROW
                  while ($row = mysqli_fetch_assoc($result)) {
                  ?>
                    <tbody>
                      <tr>
                        <td> <input name="checkbox[]" type="checkbox" value="<?php echo $row['F_ID']; ?>" /> </td>
                        <td><?php echo $row["F_ID"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["price"]; ?></td>
                        <td><?php echo $row["description"]; ?></td>
                      </tr>
                    </tbody>

                  <?php } ?>
                </table>
                <br>
                <div class="form-group">
                  <button type="submit" id="submit" name="delete" value="Delete" class="btn btn-danger"> DELETE</button>
                </div>

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
  <script>
    var response = "<?php echo $response ?>";
    var deleteModal = new bootstrap.Modal(document.getElementById('deletedModal'));
    if (response === "deleted") {
      deleteModal.show();
    }
  </script>
</body>

</html>