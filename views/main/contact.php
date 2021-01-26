<?php

class Contact {
    public function __construct(){
        echo "This is the contact page";
        // $this->_other();
    }

    protected function _other() {
        echo "This is the contact route";
    }
}