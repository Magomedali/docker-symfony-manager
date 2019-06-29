<?php
declare(strict_types=1);
namespace App\Tests\Builder\User;

use App\Model\User\Entity\User\Token;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\Id;

class UserBuilder
{
    private $id;

    private $email;

    private $hash;

    private $token;

    private $network;

    private $identity;

    public function __construct()
    {
        $this->id = Id::next();
        $this->date = new \DateTimeImmutable();
    }


    public function viaEmail(Email $email = null, string $hash = null, string $token = null): self
    {
        $clone = clone $this;
        $clone->email = $email ?? new Email('mail@app.test');
        $clone->hash = $hash ?? 'hash';
        $clone->token = $token ?? new Token("token");
        return $clone;
    }


    public function viaNetwork(string $network = null, string $identity = null): self
    {
        $clone = clone $this;
        $clone->network = $network ?? 'vk';
        $clone->identity = $identity ?? '0001';
        return $clone;
    }

    
    public function build(): User
    {
        $user = new User(
            $this->id
        );
        if ($this->email) {
            $user->signUpByEmail(
                $this->email,
                $this->token,
                $this->hash
            );
        }
        if ($this->network) {
            $user->signUpByNetwork(
                $this->network,
                $this->identity
            );
        }
        return $user;
    }
}
