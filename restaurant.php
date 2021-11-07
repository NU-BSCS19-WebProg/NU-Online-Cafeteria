<?php
include("utils/session_u.php");
include("common/head_scripts.php");
include("common/components.php");

if (!isset($_SESSION['login_user2'])) {
    header("location: customerlogin.php");
}

if (isset($_GET['r_id'])) {
    $R_ID = $_GET['r_id'];
    $query = "SELECT * FROM restaurants WHERE R_ID = $R_ID";
    $result = $conn->query($query);
    if ($result && mysqli_num_rows($result) > 0) {
        $restaurant = $result->fetch_assoc();
    } else {
        echo 'This restaurant does not exist.';
        die;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?= head($restaurant['name']) ?>

<body>
    <?= toTopBtn();
    navbar("foodlist"); ?>
    <main class="pt-0">
        <!-- ====== Header Section ======= -->
        <div class="restaurant jumbotron" style="background: linear-gradient(90deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?php echo $restaurant['images_path'] ?>')">
            <div class="container text-white">
                <h1><?php echo $restaurant['name']; ?></h1>
                <p>
                    <span class="bi-telephone-fill me-2"></span><?php echo $restaurant['contact']; ?>
                    <span class="bi-envelope-fill mx-2 "></span><?php echo $restaurant['email']; ?> <br>
                    <span class="bi-geo-alt-fill me-2"></span><?php echo $restaurant['name']; ?>
                </p>
            </div>
        </div>
        <!-- End header section -->

        <!-- ====== Food Grid Section ======= -->
        <div class="container py-5">
            <h2>Food Items</h2>
            <div class="row g-4 py-5">
                <?php
                $query = "SELECT * FROM FOOD WHERE R_ID = $R_ID ORDER BY F_ID";
                $result = $conn->query($query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $canOrder = false; //ui that lets user order is dependent on this var

                        $query2 = "SELECT * FROM weekly_items WHERE F_ID =" . $row['F_ID'];
                        $result2 = $conn->query($query2);
                        if ($result2 && mysqli_num_rows($result2) > 0) {
                            while ($row2 = mysqli_fetch_array($result2)) {
                                if ($row2['day_id'] === setDayIDURL()) {
                                    $canOrder = true;
                                    break;
                                }
                            }
                        }
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
                                            <li class="list-group-item">Allergens:
                                                <?php if ($row["allergens"] === "") echo "none";
                                                else echo $row["allergens"]; ?>
                                            </li>
                                            <li class="list-group-item">
                                                <h4>&#8369; <?php echo $row["price"]; ?></h4>
                                            </li>

                                            <?php if ($canOrder == true) { ?>
                                                <li class="list-group-item">
                                                    <h5>Quantity: <input type="number" min="1" max="25" name="quantity" class="form-control d-inline-block" value="1" style="width: 60px;"> </h5>
                                                </li>
                                            <?php } ?>
                                        </ul>

                                        <?php if ($canOrder == true) { ?>
                                            <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>">
                                            <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
                                            <input type="hidden" name="hidden_RID" value="<?php echo $row["R_ID"]; ?>">
                                            <input type="submit" name="add" class="btn btn-success" value="Add to Cart">
                                        <?php } else { ?>
                                            <p>Not available today</p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                <?php }
                } else {
                    echo '<h5>No items available</h5>';
                }

                ?>
            </div>
        </div>
        <!-- Food Grid section -->
    </main>
    <?= footer();
    scripts(); ?>
</body>

</html>