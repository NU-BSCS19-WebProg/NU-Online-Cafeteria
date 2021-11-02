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
    navbar(); ?>

    <main>
        <div class="container">
            <div class="row">
                <h1>My orders</h1>
            </div>
        </div>
    </main>


    <?= footer();
    scripts(); ?>
</body>

</html>