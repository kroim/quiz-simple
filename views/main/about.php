<?php

class About {
    public function __construct(){
        echo "This is the about page" . '<br/>';
        // $this->_other();
    }

    protected function _other() {
        echo "This is the about route.";
    }
}