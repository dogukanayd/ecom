<?php
require_once("../../config.php");

if(isset($_GET['id'])){

    $query = query("DELETE FROM slides WHERE slide_id = " . $_GET['id']) ."";
    confirm($query);

    set_message("Slide Deleted");
    redirect("../../../public/admin/index.php?slides");

}else{
    redirect("../../../public/admin/index.php?slides");

}


?>