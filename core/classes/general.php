<?php

class General {
    protected function redirect($address) {
        header("Location: $address");
    }
}