<?php

class General {
    protected function redirect($address) {
        header("Location: $address");
    }
    public function count_table_row($table) {
        global $database;
        $result = $database->query("SELECT COUNT(*) FROM $table");
        $row = $result->fetch_row();
        return $row[0];
    }
}