<?php
include('utils/session_m.php');
include("common/head_scripts.php");
include("common/components.php");

if (!isset($login_session)) {
  header('Location: managerlogin.php'); // Redirecting To Home Page
}

$error = "";
$response = "";

if (isset($_POST['submit'])) {
  $name = $conn->real_escape_string($_POST['name']);
  $price = $conn->real_escape_string($_POST['price']);
  $description = $conn->real_escape_string($_POST['description']);


  // Storing Session
  $user_check = $_SESSION['login_user1'];
  $R_IDsql = "SELECT RESTAURANTS.R_ID FROM RESTAURANTS, MANAGER WHERE RESTAURANTS.M_ID='$user_check'";
  $R_IDresult = mysqli_query($conn, $R_IDsql);
  $R_IDrs = mysqli_fetch_array($R_IDresult, MYSQLI_BOTH);
  $R_ID = $R_IDrs['R_ID'];

  $images_path = $conn->real_escape_string($_POST['images_path']);

  $query = "INSERT INTO FOOD(name,price,description,R_ID,images_path) VALUES('" . $name . "','" . $price . "','" . $description . "','" . $R_ID . "','" . $images_path . "')";
  $success = $conn->query($query);

  if (!$success) {
    $error = ("Couldnt enter data: " . $conn->error);
  } else {
    $response = "success";
  }
}

?>
<!DOCTYPE html>
<html>
<?= head("My Restaurant") ?>

<body>
  <?=
  toTopBtn();
  navbar();
  ?>
  <main class="py-5">

    <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-success">Success</h5>
          </div>
          <div class="modal-body">
            <p><?php echo $name ?> has been added.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary"><a href="add_food_items.php">Okay</a></button>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center">
          <?= adminSideBar("add"); ?>
        </div>
        <div class="col-md-8">
          <div class="form-area px-lg-5 mx-lg-5">
            <form action="" method="POST">
              <br style="clear: both">
              <h3 class="text-center mb-4">ADD NEW FOOD ITEM HERE</h3>

              <label class="text-danger mb-3"><span> <?php echo $error; ?> </span></label>

              <div class="form-group mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Your Food name" required="">
              </div>

              <div class="form-group mb-3">
                <input type="text" class="form-control" id="price" name="price" placeholder="Your Food Price (PHP)" required="">
              </div>

              <div class="form-group mb-3">
                <input type="text" class="form-control" id="description" name="description" placeholder="Your Food Description" required="">
              </div>

              <div class="form-group mb-3">
                <input type="text" class="form-control" id="images_path" name="images_path" placeholder="Your Food Image Path [images/<filename>.<extention>]" required="">
              </div>

              <div class="form-group mb-3">
                <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">ADD FOOD</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
    </div>
  </main>
  <?= footer();
  scripts(); ?>

  <script>
    var response = "<?php echo $response ?>";
    var successModal = new bootstrap.Modal(document.getElementById('successModal'))
    if (response == "success") {
      successModal.show();
    }
  </script>
</body>

</html>