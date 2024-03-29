<?php
session_start();
include("common/website_info.php");
include("common/head_scripts.php");
include_once("common/components.php");
require_once("utils/connection.php");
include_once("utils/getCurrentDay.php");

if (isset($_SESSION['login_user2'])) {
  header("location: foodlist.php?id=".setDayIDURL());
} 

if(isset($_SESSION['login_user1'])) {
  header("location: myrestaurant.php");
}

?>

<html>
<?= head("Home"); ?>

<body class="landing">
  <?=
  toTopBtn();
  navbar("");
  ?>

  <main>
    <div class="container text-center py-5">
      <div class="row justify-content-center mb-4">
        <div class="col-md-8">
          <img src="images/bulldog.png" alt="logo" class="mb-3">
          <h1 class="display-1">Skip the line,</h1>
          <h1 class="display-1">order online!</h1>
          <p><?php echo $website_name ?> offers online ordering from the NU Cafeteria.</p>
        </div>
      </div>
      <a class="btn btn-lg" href="customerlogin.php" role="button">Order Now</a>
    </div>
  </main>

  <?=
  footer();
  scripts();
  ?>
</body>

</html>