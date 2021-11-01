<?php
session_start();
include("common/website_info.php");
include("common/head_scripts.php");
include("common/components.php");

if (!isset($_SESSION['login_user2'])) {
  header("location: customerlogin.php");
}
?>
<html>
<?= head("Food Zone") ?>

<body>
  <?=
  toTopBtn();
  navbar();
  ?>
  <main>
    <div class="carousel-container">
      <div class="header">
        <h1 class="display-1">Welcome to <?php echo $website_name ?></h1>
      </div>

      <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="images/slide1.jpg" class="d-block w-100" alt="slide 1">
          </div>
          <div class="carousel-item">
            <img src="images/slide2.jpg" class="d-block w-100" alt="slide 2">
          </div>
          <div class="carousel-item">
            <img src="images/slide3.jpg" class="d-block w-100" alt="slide 2">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>

    <div class="container py-5">
      <div class="row menu-heading text-center justify-content-center py-5">
        <div class="col-md-9">
          <h6>Weekly Menu</h6>
          <h2>What's on the Menu?</h2>
          <p>NU Laguna provides students with a wide variety of dishes. Find out what's on the menu this week!</p>
        </div>
      </div>
      <div class="row days-container text-center justify-content-center pb-5">
        <div class="col-md-7 d-flex justify-content-between">
          <a href="" class="btn day">MON</a>
          <a href="" class="btn day">TUE</a>
          <a href="" class="btn day">WED</a>
          <a href="" class="btn day">THUR</a>
          <a href="" class="btn day">SAT</a>
          <a href="" class="btn day">SUN</a>
        </div>
      </div>
      <!-- Display all Food from food table -->
      <?php

      require 'utils/connection.php';
      $conn = Connect();

      $sql = "SELECT * FROM FOOD WHERE options = 'ENABLE' ORDER BY F_ID";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        $count = 0;

        while ($row = mysqli_fetch_assoc($result)) {
          if ($count == 0)
            echo "<div class='row py-5 food-grid'>";

      ?>
          <div class="col-md-3">
            <form method="post" action="cart.php?action=add&id=<?php echo $row["F_ID"]; ?>">
              <div class="card" align="center" ;>
                <img src="<?php echo $row["images_path"]; ?>" class="card-img-top">
                <div class="card-body">
                  <h4 class="card-title"><?php echo $row["name"]; ?></h4>
                  <ul class="list-group list-group-flush text-start">
                    <li class="list-group-item text-center">
                      <p class="card-text"><?php echo $row["description"]; ?></p>
                    </li>
                    <li class="list-group-item">50 kcal</li>
                    <li class="list-group-item">Allergens: Milk, Peanuts</li>
                    <li class="list-group-item">
                      <h4>&#8369; <?php echo $row["price"]; ?></h4>
                    </li>
                    <li class="list-group-item">
                      <h5>Quantity: <input type="number" min="1" max="25" name="quantity" class="form-control d-inline-block" value="1" style="width: 60px;"> </h5>
                    </li>
                  </ul>

                  <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>">
                  <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
                  <input type="hidden" name="hidden_RID" value="<?php echo $row["R_ID"]; ?>">
                  <input type="submit" name="add" style="margin-top:5px;" class="btn btn-success" value="Add to Cart">
                </div>
              </div>
            </form>


          </div>

        <?php
          $count++;
          if ($count == 4) {
            echo "</div>";
            $count = 0;
          }
        }
        ?>

    </div>
    </div>
  <?php
      } else {
  ?>

    <div class="container">
      <div class="jumbotron">
        <center>
          <label style="margin-left: 5px;color: red;">
            <h1>Oops! No food is available.</h1>
          </label>
          <p>Stay Hungry...! :P</p>
        </center>

      </div>
    </div>

  <?php

      }

  ?>
  </main>
  <?=
  footer();
  scripts();
  ?>
</body>

</html>