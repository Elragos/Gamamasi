<?php
    require 'config.php';
    require 'smarty/Smarty.class.php';
    
    function GetSmarty(){
        $smarty = new Smarty();

        $smarty->setCompileDir(ROOT_FOLDER . '/cache/compile')->setCacheDir(ROOT_FOLDER . '/cache/result');

        return $smarty;
    }