<?php
include('utils/session_m.php');
include("common/head_scripts.php");
include("common/components.php");

if (!isset($login_session)) {
  header('Location: managerlogin.php');
}

$error = "";
$response = "";

if (isset($_POST['submit'])) {
  $F_ID = $_POST['dfid'];
  $name = $_POST['dname'];
  $price = $_POST['dprice'];
  $description = $_POST['ddescription'];
  $calories = $_POST['dcalories'];
  $allergens = $_POST['dallergens'];

  $target_dir = "images/";
  $uploadOk = 1;

  if ($_FILES['image']['name'] == "") {
    $target_file = $_POST['old_image'];
    $query = mysqli_query($conn, "UPDATE food set name='$name', price='$price', calories='$calories', allergens='$allergens', description='$description', images_path='$target_file' where F_ID='$F_ID'");
    $query = "DELETE FROM weekly_items WHERE F_ID = '$F_ID'";
    $conn->query($query);
    if (!empty($_POST['week'])) {
      foreach ($_POST['week'] as $id) {
        //saving into weekly items table
        $query = "INSERT INTO weekly_items (day_id, F_ID) VALUES ($id, $F_ID)";
        $success = $conn->query($query);
      }
    }
    $response = "success";
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
        $query = mysqli_query($conn, "UPDATE food set name='$name', price='$price', calories='$calories', allergens='$allergens', description='$description', images_path='$target_file' where F_ID='$F_ID'");
        $query = "DELETE FROM weekly_items WHERE F_ID = '$F_ID'";
        $conn->query($query);
        if (!empty($_POST['week'])) {
          foreach ($_POST['week'] as $id) {
            //saving into weekly items table
            $query = "INSERT INTO weekly_items (day_id, F_ID) VALUES ($id, $F_ID)";
            $success = $conn->query($query);
          }
        }
        $response = "success";
      } else {
        $error = "Sorry, there was an error uploading your image.";
      }
    }
  }
}

?>
<!DOCTYPE html>
<html>
<?= head("Edit Food Items") ?>

<body>
  <?= toTopBtn();
  navbar("control"); ?>
  <main>
    <!-- ======= Creating Restaurant Success Modal ======= -->
    <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-success">Success</h5>
          </div>
          <div class="modal-body">
            <p><?php echo $name ?> has been updated.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary"><a href="edit_food_items.php">Okay</a></button>
          </div>
        </div>
      </div>
    </div>
    <!-- End success modal -->

    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center">
          <?= adminSideBar("edit"); ?>
        </div>
        <div class="col-md-8">
          <div class="form-area px-lg-5 mx-lg-5">
            <h3 class="mb-4">Select food item to edit</h3>
            <?php
            $query = mysqli_query($conn, "SELECT * FROM food f WHERE f.R_ID IN (SELECT r.R_ID FROM RESTAURANTS r WHERE r.M_ID='$user_check') ORDER BY F_ID");
            while ($row = mysqli_fetch_array($query)) { ?>
              <div class="list-group">
                <?php
                echo "<b><a href='edit_food_items.php?update= {$row['F_ID']}'>{$row['name']}</a></b>";
                ?>
              </div>
              <?php
            }
            if (isset($_GET['update'])) {
              $update = $_GET['update'];
              $query1 = mysqli_query($conn, "SELECT * FROM food WHERE F_ID=$update");
              while ($row1 = mysqli_fetch_array($query1)) {
              ?>
          </div>
          <div class="row">
            <div class="form-area px-lg-5 mx-lg-5">
              <hr>
              <form action="" method="POST" enctype="multipart/form-data">
                <br style="clear: both">
                <h3 class="text-center">EDIT FOOD ITEM</h3>

                <label class="text-danger mb-3"><span> <?php echo $error; ?> </span></label>

                <div class="form-group mb-3">
                  <input class='input' type='hidden' name="dfid" value=<?php echo $row1['F_ID'];  ?> />
                </div>

                <div class="form-group mb-3">
                  <label for="dname"><span class="text-danger me-2">*</span> Food Name: </label>
                  <input type="text" class="form-control" id="dname" name="dname" value="<?php echo $row1['name'];  ?>" placeholder="Your Food name" required="">
                </div>

                <div class="form-group mb-3">
                  <label for="dprice"><span class="text-danger me-2">*</span> Food Price: </label>
                  <input type="number" class="form-control" id="dprice" name="dprice" value=<?php echo $row1['price'];  ?> placeholder="Your Food Price (INR)" required="">
                </div>

                <div class="form-group mb-3">
                  <label for="ddescription"><span class="text-danger me-2">*</span> Food Description: </label>
                  <input type="text" class="form-control" id="ddescription" name="ddescription" value="<?php echo $row1['description'];  ?>" placeholder="Your Food Description" required="">
                </div>

                <div class="form-group mb-3">
                  <label for="dcalories"><span class="text-danger me-2">*</span> Food Calories: </label>
                  <input type="number" class="form-control" id="dcalories" name="dcalories" value=<?php echo $row1['calories'];  ?> placeholder="Calories" required="">
                </div>

                <div class="form-group mb-3">
                  <label for="dallergens">Food Allergens: </label>
                  <input type="text" class="form-control" id="dallergens" name="dallergens" value="<?php echo $row1['allergens'];  ?>" placeholder="Allergens" >
                </div>

                <div class="form-group mb-3">
                  <label for="image"><span class="text-danger me-2">*</span> Food Image: </label>
                  <div class="row align-items-center">
                    <div class="col">
                      <figure class="figure">
                        <img src="<?php echo $row1['images_path'];  ?>" alt="old image" class="figure-img img-fluid rounded">
                        <figcaption class="figure-caption">Current food image</figcaption>
                      </figure>
                    </div>
                    <div class="col">
                      <div class="input-group">
                        <label class="input-group-text" for="image"><span class="bi-camera-fill"></span></label>
                        <input class='input' type='hidden' name="old_image" value=<?php echo $row1['images_path'];   ?> />
                        <input type="file" class="form-control" id="image" name="image">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group mb-3">
                  <label class="form-label">Days Available</label> <br>
                  <div class="btn-group" role="group">
                    <?php
                    $F_ID = $row1['F_ID'];
                    $query = "SELECT a.day_id, a.day_name, b.F_ID FROM week a LEFT OUTER JOIN (SELECT * FROM weekly_items WHERE F_ID = $F_ID) b ON (a.day_id = b.day_id) ORDER BY a.day_id ASC";
                    $result = $conn->query($query);
                    if ($result) {
                      while ($row2 = mysqli_fetch_assoc($result)) { ?>
                        <input type="checkbox" class="btn-check" name="week[]" id="<?php echo $row2['day_id']; ?>" value="<?php echo $row2['day_id']; ?>" autocomplete="off" <?php if ($row2['F_ID'] !== null) echo ' checked'; ?>>
                        <label class="btn btn-outline-secondary" for="<?php echo $row2['day_id'] ?>"><?php echo $row2['day_name']; ?></label>
                      <?php
                      }
                      ?>
                  </div>
                </div>

                <div class="form-group mb-3">
                  <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">UPDATE</button>
                </div>
              </form>
        <?php
                    }
                  }
                }
        ?>
            </div>
          </div>
          <?php
          mysqli_close($conn);
          ?>
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
<br>

</html>