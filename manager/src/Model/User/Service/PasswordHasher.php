<?php
namespace App\Model\User\Service;

class PasswordHasher {
    
    
    public function hash(string $string):string
    {
        $hash = password_hash($string, PASSWORD_ARGON2I);
        
        if($hash == false)
            throw new \RuntimeException("Unable to generate hash");
        
        return $hash;
    }



    public function validate($password, $hash): bool
    {
    	return password_verify($password, $hash);
    	// return $hash == $this->hash($password);
    }
}
