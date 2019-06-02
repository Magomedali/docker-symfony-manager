<?php

namespace App\Model\User\Entity\User;

use Ramsey\Uuid\Uuid;

/**
 * Description of Network
 *
 * @author ali
 */
class Network {
    
    
    private $id;
    
    
    private $network;
    
    
    private $identity;
    
    
    private $user;
    
    
    public function __construct(User $user,string $network,string $identity) {
        
        $this->id = Uuid::uuid4()->toString();
        $this->user = $user;
        $this->network = $network;
        $this->identity = $identity;
        
    }
    
    
    
    public function isForNetwork(string $network):bool
    {
        return $this->network === $network;
    }
    
    
    public function getNetwork():string 
    {
        return $this->network;
    }
    
    public function getIdentity():string 
    {
        return $this->identity;
    }
}
