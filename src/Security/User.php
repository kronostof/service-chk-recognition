<?php
namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUser;

final class User extends JWTUser
{
    // Your own logic

    public function __construct($username, array $roles, $email)
    {
        parent::__construct($username, $roles);
        $this->email = $email;
    }

    public static function createFromPayload($username, array $payload)
    {
        return new self(
            $username,
            $payload['roles'], // Added by default
            $payload['email']  // Custom
        );
    }
}