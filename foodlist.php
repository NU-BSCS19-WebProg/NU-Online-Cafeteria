<?php
include("utils/session_u.php");
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
  navbar("foodlist");
  ?>
  <main class="py-0">
    <!-- ======= Carousel ======= -->
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
    <!-- End carousel -->


    <!-- ======= Restaurants Header ======= -->
    <div class="container py-5">
      <div class="row menu-heading text-center justify-content-center py-5">
        <div class="col-md-9">
          <h6>Our partner vendors</h6>
          <h2>Restaurants</h2>
          <p>Browse the menu by restaurant.</p>
        </div>
      </div>

      <!-- End restaurants header -->

      <!-- ======= Restaurants Cards ======= -->
      <div class="row restaurant-card justify-content-center py-3">
        <?php
        $query = "SELECT * FROM restaurants";
        $result = $conn->query($query);
        if ($result && mysqli_num_rows($result) > 0) {
          while ($row1 = mysqli_fetch_assoc($result)) { ?>
            <div class="col-lg-4 col-md-6">
              <a href="restaurant.php?r_id=<?php echo $row1['R_ID'] ?>">
                <div class="rounded">
                  <img src="images/burger.jpg" alt="burger" class="rounded img-fluid">
                  <h5 class="py-2"><strong><?php echo $row1['name'] ?></strong></h5>
                </div>
              </a>
            </div>
          <?php
          }
        } else { ?>
          <h2 class="text-center text-danger">Oops, looks like no one's here.</h2>
        <?php } ?>
      </div>
    </div>
    <!-- End restaurants cards -->

    <!-- ======= Weekly Menu Header ======= -->
    <div class="container py-5">
      <div class="row menu-heading text-center justify-content-center py-5" id="days-section">
        <div class="col-md-9">
          <h6>See what's cooking</h6>
          <h2>What's on the Menu?</h2>
          <p>NU Laguna provides students with a wide variety of dishes from various vendors. Find out what's on the menu this week!</p>
        </div>
      </div>
      <!-- End weekly menu header -->

      <!-- FOOD BY WEEK ROW -->
      <div class="row days-container text-center justify-content-center pb-5">
        <div class="col-md-7 d-flex justify-content-between">
          <?php
          $query = "SELECT * FROM week";
          $result = $conn->query($query);

          while ($week = mysqli_fetch_array($result)) { ?>
            <span class="day-item <?php if ($_GET['id'] === $week['day_id']) echo 'active'; ?>">
              <a href="foodlist.php?id=<?php echo $week['day_id'] ?>#days-section" class="btn day"><?php echo $week['day_name'] ?></a>
            </span>
          <?php } ?>
        </div>
      </div>

      <!-- Display all Food from food table -->
      <?php

      // $sql = "SELECT * FROM FOOD WHERE options = 'ENABLE' ORDER BY F_ID";
      $id = $_GET['id'];
      $sql = "SELECT a.day_id, b.* FROM weekly_items a, food b WHERE a.F_ID = b.F_ID AND a.day_id = $id AND b.options = 'ENABLE' ORDER BY a.F_ID";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        $count = 0;

        while ($row = mysqli_fetch_assoc($result)) {
          if ($count == 0)
            echo "<div class='row py-5 food-grid justify-content-center'>";

      ?>
          <div class="col-md-5 col-lg-3">
            <form method="post" action="cart.php?action=add&id=<?php echo $row["F_ID"]; ?>">
              <div class="card shadow" align="center" ;>
                <img src="<?php echo $row["images_path"]; ?>" class="card-img-top">
                <div class="card-body">
                  <h4 class="card-title"><?php echo $row["name"]; ?></h4>
                  <ul class="list-group list-group-flush text-start">
                    <li class="list-group-item text-center">
                      <p class="card-text"><?php echo $row["description"]; ?></p>
                    </li>
                    <li class="list-group-item"><?php echo $row["calories"]; ?> kcal</li>
                    <li class="list-group-item">Allergens: <?php if ($row["allergens"] === "") echo "none";
                                                            else echo $row["allergens"]; ?></li>
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
            <h2>Oops! No food is available.</h2>
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