<?php
declare(strict_types=1);
namespace App\Model\User\UseCase\Network\Auth;

/**
 * Description of Command
 *
 * @author ali
 */
class Command{
    
    
    public $network;
    
    
    public $identity;


    public function __construct($network,$identity)
    {
    	$this->network = $network;
    	$this->identity = $identity;
    }
    
}
