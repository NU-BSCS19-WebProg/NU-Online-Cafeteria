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
<?= head("Edit Food Items") ?>
<script type="text/javascript">
  function display_alert() {
    alert("Data Updated Successfully...!!!");
  }
</script>

<body>
  <?= toTopBtn();
  navbar(); ?>
  <main class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center">
          <?= adminSideBar("edit"); ?>
        </div>
        <div class="col-md-8">
          <div class="form-area px-lg-5 mx-lg-5">
            <div style="text-align: center;">
              <h3 class="text-center mb-4">Click On Menu</h3>
            </div>
            <?php
            if (isset($_GET['submit'])) {
              $F_ID = $_GET['dfid'];
              $name = $_GET['dname'];
              $price = $_GET['dprice'];
              $description = $_GET['ddescription'];

              $query = mysqli_query($conn, "UPDATE food set name='$name', price='$price', description='$description' where F_ID='$F_ID'");
            }
            $query = mysqli_query($conn, "SELECT * FROM food f WHERE f.R_ID IN (SELECT r.R_ID FROM RESTAURANTS r WHERE r.M_ID='$user_check') ORDER BY F_ID");
            while ($row = mysqli_fetch_array($query)) {

            ?>

              <div class="list-group text-center">
                <?php
                echo "<b><a href='edit_food_items.php?update= {$row['F_ID']}'>{$row['name']}</a></b>";
                ?>
              </div>


            <?php
            }
            ?>

            <?php
            if (isset($_GET['update'])) {
              $update = $_GET['update'];
              $query1 = mysqli_query($conn, "SELECT * FROM food WHERE F_ID=$update");
              while ($row1 = mysqli_fetch_array($query1)) {

            ?>
          </div>


          <div class="row">
            <div class="form-area px-lg-5 mx-lg-5">
              <form action="edit_food_items.php" method="GET">
                <br style="clear: both">
                <h3 class="text-center mb-4"> EDIT YOUR FOOD ITEMS HERE </h3>

                <div class="form-group mb-3">
                  <input class='input' type='hidden' name="dfid" value=<?php echo $row1['F_ID'];  ?> />
                </div>

                <div class="form-group mb-3">
                  <label for="username"><span class="text-danger" style="margin-right: 5px;">*</span> Food Name: </label>
                  <input type="text" class="form-control" id="dname" name="dname" value=<?php echo $row1['name'];  ?> placeholder="Your Food name" required="">
                </div>

                <div class="form-group mb-3">
                  <label for="username"><span class="text-danger" style="margin-right: 5px;">*</span> Food Price: </label>
                  <input type="text" class="form-control" id="dprice" name="dprice" value=<?php echo $row1['price'];  ?> placeholder="Your Food Price (INR)" required="">
                </div>

                <div class="form-group mb-3">
                  <label for="username"><span class="text-danger" style="margin-right: 5px;">*</span> Food Description: </label>
                  <input type="text" class="form-control" id="ddescription" name="ddescription" value=<?php echo $row1['description'];  ?> placeholder="Your Food Description" required="">
                </div>

                <div class="form-group mb-3">
                  <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right" onclick="display_alert()" value="Display alert box"> Update </button>
                </div>
              </form>


          <?php
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
</body>
<br>

</html>