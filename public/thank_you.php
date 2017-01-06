<?php require_once ("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS. "header.php"); ?>
<?php
proccess_transaction();
?>
<div class="container">
    <h1 class="text-center">Thank you!</h1>
</div>

<?php include (TEMPLATE_FRONT . DS . "footer.php"); ?>
