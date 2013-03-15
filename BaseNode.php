<?php

class BaseNode{
    
    protected $node_index = 0;
    
    /**
     * return 0 if obj is RootNode and 1 or more if obj is BranchNode
     */
    public function getType(){
        return $this->node_index;
    }
}
?>
