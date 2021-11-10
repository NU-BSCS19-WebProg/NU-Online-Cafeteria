<?php
session_start();
include("utils/session_u.php");
include("common/head_scripts.php");
include("common/components.php");

?>

<!DOCTYPE html>
<html lang="en">
<?= head("Profile"); ?>

<body>
    <?= toTopBtn();
    navbar("profile"); ?>

    <main>
        <div class="container">
            <h1>Past Orders</h1>
            <?php
            $query = "SELECT * FROM orders  WHERE username = '$login_session' AND paid = 1";
            $result = $conn->query($query);
            if ($result && mysqli_num_rows($result) > 0) { ?>
                <div class="row">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Items</th>
                                <th>Total Price</th>
                                <th>Date Placed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><strong><?php echo $row['O_ID'] ?></strong></td>
                                    <td>
                                        <ul>
                                            <?php
                                            $oid = $row['O_ID'];
                                            $query2 = "SELECT * FROM order_items WHERE O_ID = $oid";
                                            $result2 = $conn->query($query2);
                                            if ($result2 && mysqli_num_rows($result2) > 0) {
                                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                                    echo '<li>' . $row2['foodname'] . ' (' . $row2['quantity'] . ')' . '</li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                    <td>Php <?php echo $row['total_price'] ?></td>
                                    <td><?php echo $row['date_placed'] ?></td>
                                </tr>


                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else {
                echo '<h5>You have no past orders</h5>';
            }
                ?>
                </div>
        </div>
    </main>


    <?= footer();
    scripts(); ?>
</body>

</html>