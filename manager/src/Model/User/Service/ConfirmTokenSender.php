<?php
namespace App\Model\User\Service;

use App\Model\User\Entity\User\Email;
/**
 * Description of ConfirmTokenSender
 *
 * @author ali
 */
interface ConfirmTokenSender {
    
    public function send(Email $email,string $token):void;
}
