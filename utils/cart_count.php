<?php
function getUserOrderID()
{
    include('session_u.php');
    //check first if user has an order that hasnt been paid/fulfilled in the orders table
    $username = $login_session;
    $query = "SELECT * FROM orders WHERE username = '$username' AND paid = 0";
    $result = mysqli_query($conn, $query);

    $date = MYSQLI_TYPE_DATETIME;

    if (mysqli_num_rows($result) === 0) { // no unpaid order for user/all orders from user is paid
        $query = "INSERT INTO orders (username, date_placed, total_price, paid) VALUES ('$username', $date, 0, 0)"; //create or open a new order
        mysqli_query($conn, $query);
    }

    //get the id of the order
    $query = "SELECT * FROM orders WHERE username = '$username' AND paid = 0";
    $result = mysqli_query($conn, $query);

    $order = mysqli_fetch_array($result);
    $order_id = $order['O_ID'];


    return $order_id;
}

function getCartCount()
{
    include('session_u.php');

    $O_ID = getUserOrderID();
    $query = "SELECT * FROM order_items WHERE O_ID = $O_ID";
    $result = mysqli_query($conn, $query);
    if ($result)
        $cartCount = mysqli_num_rows($result);
    else $cartCount = 0;

    return $cartCount;
}
