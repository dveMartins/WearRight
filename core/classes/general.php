<?php

class General {
    public function redirect($address) {
        header("Location: $address");
    }
    public function count_table_row($table) {
        global $database;
        $result = $database->query("SELECT COUNT(*) FROM $table");
        $row = $result->fetch_row();
        return $row[0];
    }
    
    public function upload_image($tmp_name, $image, $target_dir) {
        $target_file = $target_dir . basename($image);
        return move_uploaded_file($tmp_name, $target_file);
    }
    
    public function delete_image($dir, $image) {
        $target_dir = "../images/$dir/";
        if($image != "default-product.png" || $image != "user-default.png") {
            unlink($target_dir . $image);
        }
    }
    
    public function convert_date($date) {
        $date_registered = substr($date, 0, 10);
        $newDate = date("d-m-Y", strtotime($date_registered));
        return $newDate;
    }
    
}