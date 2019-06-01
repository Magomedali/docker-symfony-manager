<?php
namespace App\Model\User;

use Doctrine\ORM\EntityManager;
/**
 * Description of Flusher
 *
 * @author ali
 */
class Flusher {
    
    private $em;
    
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function flush():void
    {
        $this->em->flush();
    }
}
