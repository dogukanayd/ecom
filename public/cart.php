<?php require_once("../resources/config.php"); ?>
<?php
if(isset($_GET['add'])){

    $query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['add']) . " ");
    confirm($query);
    while($row = fetch_array($query)){
        if($row['product_quantity'] != $_SESSION['product_' . $_GET['add']]){
            $_SESSION['product_' . $_GET['add']] +=1;
            redirect("checkout.php");
        }else{
            set_message("We only have " . $row['product_quantity'] . " " . "{$row['product_title']} " ."available");
            redirect("checkout.php");
        }
    }

   // $_SESSION['product_' . $_GET['add']] +=1;
    //redirect("index.php");
}

if(isset($_GET['remove'])){
    $_SESSION['product_' . $_GET['remove']]--;
    if($_SESSION['product_' . $_GET['remove']] < 1){
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("checkout.php");
    }else{
        redirect("checkout.php");
    }
}

if(isset($_GET['delete'])){
    $_SESSION['product_' . $_GET['delete']] = '0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
    redirect("checkout.php");

}

function cart(){
    $total = 0;
    $item_quantity = 0;
    foreach ($_SESSION as $name => $value) {
        if($value > 0){
            if(substr($name,0,8) == "product_" ){
                $length = strlen($name - 8);
                $id = substr($name, 8, $length);
                $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id) . " ");
                confirm($query);
                while($row = fetch_array($query)){
                    $sub = $row['product_price']*$value;
                    $item_quantity += $value;
                    $product = <<< DELIMETER
            <tr>
                <td>{$row['product_title']}</td>
                <td>&#36; {$row['product_price']}</td>
                <td>{$value}</td>
                <td>&#36;{$sub}</td>
                <td>
                <a class="btn btn-warning" href="cart.php?remove={$row['product_id']}">
                <span class='glyphicon glyphicon-minus'></span>
                </a>
                 
                <a class="btn btn-success"  href="cart.php?add={$row['product_id']}">
                <span class='glyphicon glyphicon-plus'></span>
                </a>
                
                <a class="btn btn-danger"  href="cart.php?delete={$row['product_id']}">
                <span class='glyphicon glyphicon-remove'></span>
                </a>
                
                </td>
              
            </tr>

DELIMETER;
                    echo $product;
               }
                echo $_SESSION['item_total'] = $total += $sub;
                echo $_SESSION['item_quantity'] += $item_quantity;
        }


        }

    }


}


?>