<?php
include('utils/login_u.php');
include('common/website_info.php');
include("common/head_scripts.php");
include("common/components.php");

if (isset($_SESSION['login_user2'])) {
  header("location: foodlist.php");
}
?>

<!DOCTYPE html>
<html>
<?= head("Guest Login"); ?>

<body class="login">
  <?=
  toTopBtn();
  navbar()
  ?>
  <main class="py-5">
    <div class="container">
      <header class="text-center">
        <h1>Hi Guest</h1>
        <h1>Welcome to <span class="website_name"> <?= $website_name ?> </span></h1>
        <h4>Kindly log in to continue.</h4>
      </header>

      <div class="col-md-5 mx-auto mt-5">
        <div class="card">
          <div class="card-header">Login</div>

          <div class="card-body">
            <form action="" method="POST">
              <div class="row mb-3">
                <div class="form-group col-xs-12">
                  <label for="username"><span class="text-danger">*</span> Username: </label>
                  <div class="input-group">
                    <span class="input-group-text bi-person-fill"></span>
                    <input class="form-control" id="username" type="text" name="username" placeholder="Username" required="" autofocus="">
                    </span>
                  </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="form-group col-xs-12">
                  <label for="password"><span class="text-danger">*</span> Password: </label>
                  <div class="input-group">
                    <span class="input-group-text bi-lock-fill"></span>
                    <input class="form-control" id="password" type="password" name="password" placeholder="Password" required="">
                  </div>
                </div>
              </div>

              <label class="text-danger mb-3"><span> <?php echo $error;  ?> </span></label>

              <div class="row mb-3">
                <div class="form-group col-xs-4">
                  <button class="btn btn-primary" name="submit" type="submit" value="Login">Submit</button>
                </div>
              </div>

              <label>or</label> <br>
              <label><a href="customersignup.php">Create a new account.</a></label>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?=
  footer();
  scripts();
  ?>
</body>

</html>