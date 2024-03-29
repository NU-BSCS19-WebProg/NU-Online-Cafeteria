<?php

// button that takes page to top component
function toTopBtn()
{
  echo '
    <button onclick="topFunction()" id="myBtn" title="Go to top">
    <i class="bi-chevron-up"></i>
    </button>';
}

// navbar component
function navbar($page)
{
  include("website_info.php");
  include_once("utils/getCurrentDay.php");
  include_once("utils/cart_count.php");

  echo '<nav class="navbar navbar-expand-lg" role="navigation">
    <div class="container">
      <a href="index.php" class="navbar-brand d-flex align-items-center">
        <img src="images/bulldog.png" alt="logo" class="d-inline-block align-top">
        <span>';
  echo $website_name;
  echo '</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"><i class="bi-list"></i></span>
      </button>

      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a href="about_us.php" class="nav-link';
  if ($page === "about") echo ' active';
  echo '">About</a></li></ul>';
  if (isset($_SESSION['login_user1'])) { //if admin
    echo '
            <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link admin-name"><span class="bi-person-fill"></span> Welcome ';
    echo $_SESSION['login_user1'];
    echo '
            </a></li>
            <li class="nav-item"><a href="myrestaurant.php" class="nav-link';
            if ($page === "control") echo ' active';
            echo '"><span class="fa fa-tools"></span> MANAGER CONTROL PANEL</a></li>
            <li class="nav-item"><a href="utils/logout_m.php" class="nav-link"><span class="bi-box-arrow-left"></span> Log Out </a></li>
          </ul>
          ';
  } else if (isset($_SESSION['login_user2'])) { //if customer
    echo '
        <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="customer_profile.php" class="nav-link';
    if ($page === "profile") echo ' active';
    echo '"><span class="bi-person-fill"></span> Welcome ';
    echo $_SESSION['login_user2'];
    echo '</a></li>
        <li class="nav-item"><a href="foodlist.php?id='.setDayIDURL().'" class="nav-link';
    if ($page === "foodlist") echo ' active';
    echo '"><span class="fa fa-cutlery"></span> Food Zone </a></li>
        <li class="nav-item"><a href="cart.php" class="nav-link';
    if ($page === "cart") echo ' active';
    echo '"><span class="bi-cart-fill"></span> Cart (';
    echo getCartCount();
    echo ')
            </a></li>
        <li class="nav-item"><a href="utils/logout_u.php" class="nav-link"><span class="bi-box-arrow-left"></span> Log Out </a></li>
    </ul>';
  } else {
    echo '
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            <a class="nav-link';
    if ($page === "signup") echo ' active';
    echo ' dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="bi-person-fill"></span> Sign Up</a>
            <ul class="dropdown-menu">
                <li><a href="customersignup.php" class="dropdown-item">User Sign-up</a></li>
                <li><a href="managersignup.php" class="dropdown-item">Manager Sign-up</a></li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link';
    if ($page === "login") echo ' active';
    echo ' dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="bi-box-arrow-right"></span> Login
            </a>
            <ul class="dropdown-menu">
                <li><a href="customerlogin.php" class="dropdown-item">User Login</a></li>
                <li><a href="managerlogin.php" class="dropdown-item">Manager Login</a></li>
            </ul>
        </li>
    </ul>';
  }
  echo '</div>
    </div>
    </nav>';
}

// footer component
function footer()
{
  include("website_info.php");
  echo ' <footer class="footer mt-auto">
<div class="container ">
  <div class="col-md-6 mx-auto text-center brand">
    <a href="index.php">';
  echo $website_name;
  echo '</a>
  <p>Since 2021</p>
  </div>
</div>
<div class="names py-2 text-center ">
  <div class="container">
  <hr>
  <div class="row justify-content-evenly">
    <div class="col-lg-3"><span>Bowwi Katigbak</span></div>
    <div class="col-lg-3"><span>Maureen Kate Dadap</span></div>
    <div class="col-lg-3"><span>Reymar Bulanon</span></div>
    <div class="col-lg-3"><span>Zyrhus Joshua Tayag</span></div>
  </div>
  </div>
</div>
</footer>';
}

// admin sidebar component for admin-related pages
function adminSideBar($page)
{
  echo '<div class="text-start">
    <h1>Hello Manager! </h1>
    <p>Manage your restaurant from here</p>
  </div>
  <div class="list-group">';

  echo '<a href="myrestaurant.php" class="list-group-item';
  if ($page === "restaurant") echo ' active';
  echo '">My Restaurant</a>';

  echo '<a href="view_food_items.php" class="list-group-item';
  if ($page === "view-items") echo ' active';
  echo '">View Food Items</a>';

  echo '<a href="add_food_items.php" class="list-group-item';
  if ($page === "add") echo ' active';
  echo '">Add Food Items</a>';

  echo ' <a href="edit_food_items.php" class="list-group-item';
  if ($page === "edit") echo ' active';
  echo '">Edit Food Items</a>';

  echo '<a href="delete_food_items.php" class="list-group-item';
  if ($page === "delete") echo ' active';
  echo '">Delete Food Items</a>';

  echo '<a href="view_order_details.php" class="list-group-item';
  if ($page === "orders") echo ' active';
  echo '">View Order Details</a>';

  echo '</div>';
}
