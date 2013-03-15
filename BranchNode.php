<?php
require_once 'BaseNode.php';

class BranchNode extends BaseNode{
    
    private $child = '';
    
    public function __construct($index = 1) {
        $this->node_index = (int) $index;
    }
    
    /**
     * add child at the and of chain
     * 
     * @param void
     * @return void
     */
    public function addNode(){
        if(!empty($this->child)){
            $this->child->addNode();
        }else{
            $this->child = new BranchNode($this->node_index + 1);
        }
    }
    
    /**
     * generated and output html for all Node and his childs
     * 
     * @param void
     * @return void
     */
    public function output(){
        $index = $this->getType();
        if($index != 0){ 
            echo "$index <a href=\"?command=delete&node=$index\">delete</a><br />";
        }

        if($this->isLastNode()){ 
            echo '<a href="?command=add">add</a>';
        }
        
        if(!empty($this->child)){
            $this->child->output();
        }
    }
    
    /**
     * 
     * delete child from chain wich starts from $node_index
     * 
     * @param int $node_index
     * @return void
     */
    public function deleteNode($node_index){
        
        if(!empty($this->child)){
            $this->child->deleteNode($node_index);
        }
        if($this->getType() + 1 >= $node_index){
            unset($this->child);
        }
        
        //if specified begin of branch node
        if($node_index == 1){
            $this->setType(0);
        }
    }
    
    /**
     * 
     * Return true if this child is last in chain
     * 
     * @param void
     * @return bool
     */
    public function isLastNode(){
        return empty($this->child);
    }
    
    /**
     * 
     * Set current node index
     * 
     * @param int $node_index
     * @return void
     */
    public function setType($node_index){
        $this->node_index = (int) $node_index;
    }
}

session_start();

if(empty($_SESSION['node'])){
    $a = new BranchNode();
    $_SESSION['node'] = $a;
}else{
    $a = $_SESSION['node'];
}

switch($_GET['command']){
    
    case 'delete':
        if(!empty($_GET['node']) && is_numeric($_GET['node'])){
            $a->deleteNode((int) $_GET['node']);
            $_SESSION['node'] = $a;
        }
    break;
    
    case 'add':
        $a->addNode();
    break;
}

if(!empty($_GET['node'])){
    $a->deleteNode((int) $_GET['node']);
    $_SESSION['node'] = $a;
}

$_SESSION['node']->output();





?>
