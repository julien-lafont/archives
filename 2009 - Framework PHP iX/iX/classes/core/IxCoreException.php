<?php

class IxCoreException extends Exception {
    
    
    public function __construct($message, $code=0) {
        
        parent::__construct($message, $code);
        echo $this->__toString();
    }
    
    public function __toString() {
        $r= "<br /><br />##################################################################<br />";
        $r.= "<strong>Une erreur est survenue !</strong><br />";
        $r.= __CLASS__ . ": [{$this->code}]: {$this->message}";
        $r.= "<br />##################################################################<br />";
    
        return $r;
    }
}

?>