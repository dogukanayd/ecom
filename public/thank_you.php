<?php require_once ("../resources/config.php"); ?>
<?php require_once ("cart.php");?>
<?php include(TEMPLATE_FRONT . DS. "header.php"); ?>
<?php
if(isset($_GET['tx'])){
   $amount =  $_GET['amt'];
   $currency =  $_GET['cc'];
   $transaction =  $_GET['tx'];
   $status =  $_GET['st'];

    $query = query("INSERT INTO orders(order_amount,order_transaction,order_status,order_currency)
VALUES ('{$amount}','{$currency}','{$transaction}','{$status}')");
    confirm($query);

    session_destroy();


}else{
    redirect("index.php");
}

?>
<div class="container">
    <h1 class="text-center">Thank you</h1>
</div>

<?php include (TEMPLATE_FRONT . DS . "footer.php"); ?>
