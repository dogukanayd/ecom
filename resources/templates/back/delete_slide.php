<?php

require_once("../../config.php");

if(isset($_GET['id'])){
    // Delete from file
    $query_find_image = query("SELECT slide_image FROM slides WHERE slide_id = " . escape_string($_GET['id']) . " LIMIT 1 ");
    confirm($query_find_image);

    $row = fetch_array($query_find_image);
    $target_path = UPLOAD_DIRECTORY . DS . $row['slide_image'];
    unlink($target_path);
    // Delete from file

    $query = query("DELETE FROM slides WHERE slide_id = " . $_GET['id']) ."";
    confirm($query);




    unlink($target_path);

    set_message("Slide Deleted");
    redirect("../../../public/admin/index.php?slides");

}else{
    redirect("../../../public/admin/index.php?slides");

}



?>