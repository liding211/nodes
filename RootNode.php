<?php

require_once 'BaseNode.php';

/**
 * singleton
 */
class RootNode extends BaseNode{
    
    protected static $root;
    
    private function __constract(){}
    
    public static function getRoot(){
        if(empty(self::$root)){
            self::$root = new RootNode();
        }
        return self::$root;
    }
}
?>
