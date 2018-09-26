<?php
function get_base_name($filename)
{
    return pathinfo($filename)['filename'];
}

function change_extension($filename,$base="",$extension="") {
    
    $new_file_name = $base.get_base_name($filename).$extension;
    return $new_file_name;
}

function rename_extension($filename,$base="",$extension="") {
    
    $new_file_name = $base.get_base_name($filename).$extension;
    if(!rename($filename,$new_file_name))
    {
        //handle failed to rename case
    }
    return $new_file_name;
}

?>