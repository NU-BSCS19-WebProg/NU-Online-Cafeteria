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
  $calories = $conn->real_escape_string($_POST['calories']);
  $allergens = $_POST['allergens'];

  $target_dir = "images/";
  $target_file = $target_dir . basename($_FILES["image"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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
      // Storing Session
      $user_check = $_SESSION['login_user1'];
      $R_IDsql = "SELECT RESTAURANTS.R_ID FROM RESTAURANTS, MANAGER WHERE RESTAURANTS.M_ID='$user_check'";
      $R_IDresult = mysqli_query($conn, $R_IDsql);
      $R_IDrs = mysqli_fetch_array($R_IDresult, MYSQLI_BOTH);
      $R_ID = $R_IDrs['R_ID'];

      $images_path = $target_file;

      //saving into food table
      $query = "INSERT INTO FOOD(name,price,description, calories, allergens,R_ID,images_path) VALUES('" . $name . "','" . $price . "','" . $description . "','" . $calories . "','" . $allergens . "','" . $R_ID . "','" . $images_path . "')";
      $success = $conn->query($query);

      if (!$success) {
        $error = ("Couldnt enter data: " . $conn->error);
      } else {
        //food item is saved in table, now save the food in the weekly items based on checked days available
        if (!empty($_POST['week'])) {
          //get the last inserted food item
          $query = "SELECT * FROM FOOD ORDER BY F_ID DESC LIMIT 1;";
          $result = $conn->query($query);
          $F_ID = mysqli_fetch_array($result)['F_ID'];

          foreach ($_POST['week'] as $id) {
            //saving into weekly items table
            $query = "INSERT INTO weekly_items (day_id, F_ID) VALUES ($id, $F_ID)";
            $success = $conn->query($query);
          }
        }
        $response = "success";
      }
    } else {
      $error = "Sorry, there was an error uploading your file.";
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
            <form action="" method="POST" enctype="multipart/form-data">
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
                <input type="number" class="form-control" id="calories" name="calories" placeholder="Calories" required="">
              </div>

              <div class="form-group mb-3">
                <input type="text" class="form-control" id="allergens" name="allergens" placeholder="Allergens" required="">
              </div>

              <div class="form-group mb-3">
                <!-- <input type="text" class="form-control" id="images_path" name="images_path" placeholder="Your Food Image Path [images/<filename>.<extention>]" required=""> -->
                <div class="input-group">
                  <label class="input-group-text" for="image"><span class="bi-camera-fill"></span></label>
                  <input type="file" class="form-control" id="image" name="image" required="">
                </div>
              </div>

              <div class="form-group mb-3">
                <label class="form-label">Days Available</label> <br>
                <div class="btn-group" role="group">
                  <?php
                  $query =  "SELECT * FROM week";
                  $result = $conn->query($query);
                  if ($result) {
                    while ($row = mysqli_fetch_array($result)) { ?>
                      <input type="checkbox" class="btn-check" name="week[]" id="<?php echo $row['day_id'] ?>" value="<?php echo $row['day_id'] ?>" autocomplete="off">
                      <label class="btn btn-outline-secondary" for="<?php echo $row['day_id'] ?>"><?php echo $row['day_name'] ?></label>
                  <?php }
                  }
                  ?>
                </div>
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