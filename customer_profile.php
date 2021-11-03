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
            <h1>Past Orders</h1>
            <div class="row">

            </div>
        </div>
    </main>


    <?= footer();
    scripts(); ?>
</body>

</html>