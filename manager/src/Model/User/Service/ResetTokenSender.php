<?php

namespace App\Model\User\Service;

use App\Model\User\Entity\User\{Email,ResetToken};
use Twig\Environment;

/**
 *
 * @author ali
 */
class ResetTokenSender {
    
    private $mailer;
    private $twig;
    private $from;


    public function __construct(\Swift_Mailer $mailer, Environment $twig, array $from)
    {
    	$this->mailer = $mailer;
        $this->twig = $twig;
        $this->from = $from;
    }

    public function send(Email $email, ResetToken $token):void
    {
    	$message = (new \Swift_Mailer('Password resetting'))
    				->setFrom($from)
    				->setTo($email->getValue())
    				->setBody($this->twig->render("mail/user/reset.html.twig",[
    					'token'=>$token->getToken()
    				]), "text/html");
    				

    	if(!$this->mailer->send($message))
    	{
    		throw new \RuntimeException('Unable to send message.');
    	}
    }

}
