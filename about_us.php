<?php
session_start();
include("common/website_info.php");
include("common/head_scripts.php");
include("common/components.php");
?>

<html>
<?= head("About Us"); ?>

<body>
  <?=
  toTopBtn();
  navbar("about");
  ?>

  <main class="pt-0">
    <div class="about jumbotron">
      <div class="container">
        <h1 class="text-center text-white">About <?= $website_name ?></h1>
      </div>
    </div>
    <div class="container pt-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <h4>Affordable cost. Incredible hours. You don't need cash. And the food rivals even your Mom's cooking. Any questions?</h4>
          <p><strong>Focus on your classes, while we focus on your food.</strong> Welcome to <?= $website_name ?>, NU Laguna's online website for dining services.
            We have a strong commitment to our student’s success and aim to provide services that support a healthy mind and body,
            as safely and efficiently as possible. Thank you for your patience as we continue to
            evolve in this constantly changing environment.</p>
          <p> We place no minimum order restrictions! Order in as little (or as much) as you'd like. We'll give it to you!</p>
          <h4>How does it work?</h4>
          <ol>
            <li>Place your order.</li>
            <li>Pay with your preferred method.</li>
            <li>Pick up your food and enjoy!</li>
          </ol>
        </div>
      </div>
    </div>
  </main>
</body>
<?=
footer();
scripts();
?>

</html>