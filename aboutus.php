<?php
session_start();

include("common/head_scripts.php");
include("common/components.php");

?>

<html>
<?= head("About Us"); ?>

<body>
  <?=
  toTopBtn();
  navbar();
  ?>

  <div class="wide">

    <div class="tagline">Food is not about the <font color="darkblue"><strong>looks</strong></font>, it's about the <font color="gold"><strong><em>taste</em>.</strong></font>of it.</div>
    <h3 style="color: gray">About the food culture in Le Comscie'</h3>
    <br>
    <h3 style="color: black;">We deliver food from your neighborhood local joints, your favorite cafes, luxurious & elite restaurants in your area, <h3 style="color: black;"> and also from chains like Dominos, KFC, Burger King, Pizza Hut, FreshMenu, Mc Donald's, Jollibee, chowking, Mang Inasal, Kenny Rogers and more. Isn't that great?</h3>
      <h3 style="color : black"> We place no minimum order restrictions! Order in as little (or as much) as you'd like. We'll give it to you!</h3>
    </h3>
  </div>

  <div style="display:flex;">
    <img style="border-radius:100px;margin:20px;" src="images/bowwi.jpg" alt="owners" width="20%" height="40%">
    <img style="border-radius:100px;margin:20px" src="images/reymar.jpg" alt="owners" width="20%" height="10%">
  </div>
</body>
<?=
footer();
scripts();
?>

</html>