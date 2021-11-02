<?php
include('utils/session_m.php');
include("common/head_scripts.php");
include("common/components.php");

if (!isset($login_session)) {
  header('Location: managerlogin.php'); // Redirecting To Home Page
}

$error = "";
$response = "";
$m_id = $_SESSION['login_user1'];
$hasRestaurant = false;

//check first if manager has already created a restaurant for themselves
$query = "SELECT * FROM restaurants WHERE m_id = '$m_id'";
$result = $conn->query($query);
if (mysqli_num_rows($result) > 0) {
  $hasRestaurant = true;
  $restaurant = mysqli_fetch_assoc($result);
  $r_id = $restaurant['R_ID'];

  //check for the total number of menu items in restaurant
  $query = "SELECT COUNT FROM food WHERE r_id = '$r_id'";
  $menu_items = $conn->query($query);
  if (!$menu_items) {
    $menu_items = 0;
  }
}

// creation of new restaurant
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
  navbar("control");
  ?>
  <main>
    <!-- ======= Creating Restaurant Success Modal ======= -->
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
    <!-- End success modal -->

    <div class="container">
      <div class="row">
        <!-- ======= Admin sidebar ======= -->
        <div class="col-md-4 text-center">
          <?= adminSideBar("restaurant"); ?>
        </div>
        <!-- End admin sidebar -->

        <!-- ======= Restaurant Info ======= -->
        <div class="col-md-8">
          <div class="form-area px-lg-5 mx-lg-5">
            <h3 class="text-center mb-4">MY RESTAURANT</h3>
            <?php if ($hasRestaurant === true) { ?>
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td><strong>Restaurant Name</strong></td>
                    <td><?php echo $restaurant['name']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Restaurant Email</strong></td>
                    <td><?php echo $restaurant['email']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Restaurant Contact</strong></td>
                    <td><?php echo $restaurant['contact']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Restaurant Address: </strong> </td>
                    <td><?php echo $restaurant['address']; ?></td>
                  </tr>
                  <tr>
                    <td><strong>Restaurant Total Menu Items: </strong></td>
                    <td><?php echo $menu_items; ?></td>
                  </tr>
                </tbody>
              </table>
            <?php } else { ?>
              <form action="" method="POST">
                <br style="clear: both">

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

                <label class="text-danger mb-3"><span> <?php echo $error;  ?> </span></label>

                <div class="form-group mb-3">
                  <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right"> ADD RESTAURANT </button>
                </div>
              </form>
            <?php } ?>
          </div>
        </div>
        <!-- End restaurant info -->
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