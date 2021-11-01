<?php
include('utils/session_m.php');
include("common/head_scripts.php");
include("common/components.php");

$error = "";
$response = "";


if (!isset($login_session)) {
  header('Location: managerlogin.php'); // Redirecting To Home Page
}

$error = "";
$response = "";

if (isset($_POST['submit'])) {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $contact = $conn->real_escape_string($_POST['contact']);
  $address = $conn->real_escape_string($_POST['address']);

  $query = "INSERT INTO RESTAURANTS(name,email,contact,address,M_ID) VALUES('" . $name . "','" . $email . "','" . $contact . "','" . $address . "','" . $_SESSION['login_user1'] . "')";
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
            <button type="button" class="btn btn-primary"><a href="myrestaurant.php">Okay</a></button>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center">
          <?= adminSideBar("restaurant"); ?>
        </div>
        <div class="col-md-8">
          <div class="form-area px-lg-5 mx-lg-5">
            <form action="" method="POST">
              <br style="clear: both">
              <h3 class="text-center mb-4">MY RESTAURANT</h3>

              <div class="form-group mb-3">
                <input type="text" class="form-control" id="name" name="name" placeholder="Your Restaurant's Name" required="">
              </div>

              <div class="form-group mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Your Restaurant's Email" required="">
              </div>

              <div class="form-group mb-3">
                <input type="text" class="form-control" id="contact" name="contact" placeholder="Your Restaurant's Contact Number" required="">
              </div>

              <div class="form-group mb-3">
                <input type="text" class="form-control" id="address" name="address" placeholder="Your Restaurant's Address" required="">
              </div>

              <div class="form-group mb-3">
                <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right"> ADD RESTAURANT </button>
              </div>
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
    var successModal = new bootstrap.Modal(document.getElementById('successModal'))
    if (response == "success") {
      successModal.show();
    }
  </script>
</body>

</html>