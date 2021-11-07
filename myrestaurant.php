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
$hasRestaurant = false; // if true, does not show the form for creation of new restaurant
$isEdit = false; //if true, shows the form that will edit restaurant details

//check first if manager has already created a restaurant for themselves
$query = "SELECT * FROM restaurants WHERE M_ID = '$m_id'";
$result = $conn->query($query);
if ($result && mysqli_num_rows($result) > 0) {
  $hasRestaurant = true;
  $restaurant = mysqli_fetch_assoc($result);
  $r_id = $restaurant['R_ID'];
  $menu_items = 0;

  //check for the total number of menu items in restaurant
  $query = "SELECT COUNT(*) FROM food WHERE R_ID = '$r_id'";
  $result = $conn->query($query);
  if ($result) {
    $menu_items = mysqli_fetch_array($result)['0'];
  }
}

if (isset($_GET['action']) && $_GET['action'] === 'edit') {
  $isEdit = true;
}


// creation of new restaurant
if (isset($_POST['submit'])) {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $contact = $conn->real_escape_string($_POST['contact']);
  $address = $conn->real_escape_string($_POST['address']);

  $target_dir = "images/";
  $uploadOk = 1;

  if ($isEdit === true) { //is editing restaurant
    $r_id = $restaurant['R_ID'];
    if ($_FILES['image']['name'] == "") { //if image is left unchanged
      $target_file = $_POST['old_image'];
      $query = "UPDATE restaurants set name = '$name', email = '$email', contact='$contact', address='$address', images_path='$target_file' WHERE R_ID = '$r_id'";
      $success = $conn->query($query);
    } else {
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      // Check if image file is a actual image or fake image
      $check = getimagesize($_FILES["image"]["tmp_name"]);
      if ($check !== false) {
        $uploadOk = 1;
      } else {
        $error = "File is not an image.";
        $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk !== 0) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
          $images_path = $target_file;
          $query = "UPDATE restaurants set name = '$name', email = '$email', contact='$contact', address='$address', images_path='$images_path' WHERE R_ID = '$r_id'";
          $success = $conn->query($query);
        } else {
          $error = "Sorry, there was an error uploading your image.";
        }
      }
    }

    if (!$success) {
      $error = ("Couldnt enter data: " . $conn->error);
    } else {
      $response = "edited";
    }
  } else { //is adding a new restaurant
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
      $uploadOk = 1;
    } else {
      $error = "File is not an image.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk !== 0) {
      if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $images_path = $target_file;

        //saving into restaurant table
        $query = "INSERT INTO RESTAURANTS(name,email,contact,address,M_ID, images_path) VALUES('" . $name . "','" . $email . "','" . $contact . "','" . $address . "','" . $_SESSION['login_user1'] . "', '" . $images_path . "')";
        $success = $conn->query($query);
        if (!$success) {
          $error = ("Couldnt enter data: " . $conn->error);
        } else {
          $response = "success";
        }
      } else {
        $error = "Sorry, there was an error uploading your image.";
      }
    }
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

    <!-- ======= Editing Restaurant Success Modal ======= -->
    <div class="modal fade" id="editedModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-success">Success</h5>
          </div>
          <div class="modal-body">
            <p><?php echo $name ?> has been edited.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary"><a href="myrestaurant.php">Okay</a></button>
          </div>
        </div>
      </div>
    </div>
    <!-- End edited modal -->

    <div class="container">
      <div class="row">
        <!-- ======= Admin sidebar ======= -->
        <div class="col-md-4 text-center">
          <?= adminSideBar("restaurant"); ?>
        </div>
        <!-- End admin sidebar -->

        <!-- ======= Restaurant ======= -->
        <div class="col-md-8">
          <div class="form-area px-lg-5 mx-lg-5">
            <h3 class="text-center mb-4">MY RESTAURANT</h3>
            <?php if ($hasRestaurant === true) {
              if ($isEdit === true) { ?>
                <!-- ======= Restaurant Edit Form ======= -->
                <form action="" method="POST" enctype="multipart/form-data">
                  <br style="clear: both">
                  <div class="form-group mb-3">
                    <label for="name">Restaurant Name: </label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $restaurant['name']; ?>" required="">
                  </div>

                  <label for="email">Restaurant Email: </label>
                  <div class="form-group mb-3">
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $restaurant['email']; ?>" required="">
                  </div>

                  <div class="form-group mb-3">
                    <label for="contact">Restaurant Contact: </label>
                    <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $restaurant['contact']; ?>" required="">
                  </div>

                  <div class="form-group mb-3">
                    <label for="address">Restaurant Address: </label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo $restaurant['address']; ?>" required="">
                  </div>

                  <div class="form-group mb-3">
                    <label for="image">Restaurant Banner: </label>
                    <figure class="figure">
                      <img src="<?php echo $restaurant['images_path'];  ?>" alt="old image" class="figure-img img-fluid rounded">
                      <figcaption class="figure-caption">Current Restaurant Banner</figcaption>
                    </figure>
                    <div class="input-group">
                      <label class="input-group-text" for="image"><span class="bi-camera-fill"></span></label>
                      <input class='input' type='hidden' name="old_image" value=<?php echo $restaurant['images_path'];   ?> />
                      <input type="file" class="form-control" id="image" name="image">
                    </div>
                  </div>

                  <label class="text-danger mb-3"><span> <?php echo $error;  ?> </span></label>

                  <div class="form-group mb-3">
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">UPDATE DETAILS</button>
                  </div>
                </form>
                <!-- End restaurant edit form -->

              <?php } else { ?>
                <!-- ======= Restaurant Info ======= -->
                <figure class="figure">
                  <img src="<?php echo $restaurant['images_path'] ?>" class="figure-img img-fluid rounded" alt="...">
                  <figcaption class="figure-caption text-center">Restaurant Cover</figcaption>
                </figure>
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

                <a href="myrestaurant.php?action=edit" class="btn btn-primary"><span class="bi-pencil-fill"></span> Edit Details</a>
                <!-- End restaurant info -->

              <?php }
            } else { ?>

              <!-- ======= Restaurant Create form ======= -->
              <form action="" method="POST" enctype="multipart/form-data">
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

                <div class="input-group mb-3">
                  <label class="input-group-text" for="image"><span class="bi-camera-fill"></span></label>
                  <input type="file" class="form-control" id="image" name="image">
                </div>

                <label class="text-danger mb-3"><span> <?php echo $error;  ?> </span></label>
                <div class="form-group mb-3">
                  <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right"> ADD RESTAURANT </button>
                </div>
              </form>
              <!-- End restaurant create form -->
            <?php } ?>
          </div>
        </div>
        <!-- End restaurant -->
      </div>
    </div>
  </main>

  <?= footer();
  scripts(); ?>

  <script>
    var response = "<?php echo $response ?>";
    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    var editedModal = new bootstrap.Modal(document.getElementById('editedModal'));
    if (response == "success") {
      successModal.show();
    } else if (response === "edited") {
      editedModal.show();
    }
  </script>
</body>

</html>