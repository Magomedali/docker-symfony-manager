<?php

namespace App\Model\User\Entity\User;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Network
 * @author ali
 *
 * @ORM\Entity
 * @ORM\Table(name="user_user_networks", uniqueConstraints={
 *          @ORM\UniqueConstraint(columns={"network","identity"}) 
 * })
 */
class Network {
    
    /**
    * @ORM\Column(type="guid")
    * @ORM\Id
    */
    private $id;
    
    /**
    * @ORM\Column(type="string", length=32, nullable=true)
    */
    private $network;
    
    /**
    * @ORM\Column(type="string", length=32, nullable=true)
    */
    private $identity;
    
    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="networks")
    * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
    */
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
