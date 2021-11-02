<?php
session_start();
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
            <div class="row">
                <h1>Active Orders</h1>
            </div>
            <div>
                <h1>Past Orders</h1>
            </div>
        </div>
    </main>


    <?= footer();
    scripts(); ?>
</body>

</html>