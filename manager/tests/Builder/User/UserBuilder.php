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

    private $confirmed;


    public function __construct()
    {
        $this->id = Id::next();
        $this->date = new \DateTimeImmutable();
    }

    public static function instance():self{
        return new self();
    }

    public function confirmed(): self
    {
        $clone = clone $this;
        $clone->confirmed = true;
        return $clone;
    }

    public function viaEmail(Email $email = null, string $hash = null, Token $token = null): self
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
        
        if ($this->email) {
            $user=User::signUpByEmail(
                $this->id,
                $this->email,
                $this->token,
                $this->hash
            );

            if ($this->confirmed) {
                $user->confirmToken();
            }

            return $user;
        }

        if ($this->network) {
            return  User::signUpByNetwork(
                $this->id,
                $this->network,
                $this->identity
            );
        }

        throw new \BadMethodCallException('Specify via method.');
    }
}
