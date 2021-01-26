<?php

class Home {
    public function __construct(){
        echo "This is the home page";
        $this->_other();
    }

    protected function _other() {
        echo "This is the other function, lolz.";
    }
}