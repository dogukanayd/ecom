<?php
// helper functions

function last_id(){
    global $connection;
    return mysqli_insert_id($connection);
}

function set_message($msg){
    if(!empty($msg)){
        $_SESSION['message'] = $msg;
    }else{
        $msg = "";
    }
}

function display_message(){
    if(isset($_SESSION['message'])){

        echo $_SESSION['message'];
        unset($_SESSION['message']);

    }
}

function redirect($location){
    header("Location: $location");
}

function query($sql){
    global $connection; //from config
    return mysqli_query($connection,$sql);
}

function confirm($result){
    global $connection;
    if(!$result){
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function escape_string($string){
    global $connection;
    return mysqli_real_escape_string($connection,$string);
}

function fetch_array($result){

    return mysqli_fetch_array($result);
}
//******************************** FRONT END FUNCTIONS *******************
// get products

function get_products_in_cat_page(){
    $query = query("SELECT * FROM products WHERE product_category_id = ". escape_string($_GET['id']) ." ");
    confirm($query);

    while($row = fetch_array($query)){

        $product = <<<DELIMETER

 
                 <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row['product_image']}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> 
                            <a href=" item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;

        echo $product;

    }


}

function get_products(){
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)){

        $product = <<<DELIMETER

 <div class="col-sm-4 col-lg-4 col-md-4">
               <div class="thumbnail">
                           <a href="item.php?id={$row['product_id']}"> <img src="{$row['product_image']}" alt=""> </a>
                            <div class="caption">

                                <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                                <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
                                </h4>

                                <p>{$row['short_desc']}</p>

                                <a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}" >Add to cart</a>
                            </div>
                        </div>
                    </div>

DELIMETER;

        echo $product;

    }


}

function get_categories(){
    $query = query("SELECT * FROM categories");
    confirm($query);
    while($row = fetch_array($query)){
        $categories_links = <<<DELIMETER

 <a href='category.php?id={$row['cat_id']}' class="list-group-item">{$row['cat_title']}</a>
DELIMETER;
echo $categories_links;
    }
}

function get_products_shop_page(){
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)){

        $product = <<<DELIMETER

 
                 <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="{$row['product_image']}" alt="">
                    <div class="caption">
                        <h3>{$row['product_title']}</h3>
                        <p>{$row['short_desc']}</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> 
                            <a href=" item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;

        echo $product;
    }
}

function login_user(){
    if(isset($_POST['submit'])){
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}'");
        confirm($query);

       if( mysqli_num_rows($query) == 0){
           set_message("Your password or username are wrong!");
           redirect("login.php");
       }
       else{
           $_SESSION['username'] = $username;
           redirect("admin");
       }
    }
}

function send_message(){
    if(isset($_POST['submit'])){
        $to = "mail@mail.com";
        $from_name =  $_POST['name'];
        $subject =  $_POST['subject'];
        $email =  $_POST['email'];
        $message =  $_POST['message'];
        $headers = "From: {$from_name} {$email}";

        $result = mail($to,$subject,$message,$headers);
        if(!$result){
            set_message("Sorry we could not send your message");
            redirect("contact.php");
        }else{
            set_message("Your Message has been sent");
            redirect("contact.php");
        }

    }
}

//******************************** BACK END FUNCTIONS *******************

function display_orders(){
    $query = query("SELECT * FROM orders");
    confirm($query);
    while($row = fetch_array($query)){

        $orders = <<<DELIMETER
        <tr>
            <td>{$row['order_id']} </td>
            <td>{$row['order_amount']} </td>
            <td>{$row['order_transaction']} </td>
            <td>{$row['order_currency']} </td>
            <td>{$row['order_status']} </td>
            <td><a href="../../resources/templates/back/delete_order.php?id={$row['order_id']}" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> </a></td>
        </tr>
DELIMETER;

echo $orders;
    }
}

