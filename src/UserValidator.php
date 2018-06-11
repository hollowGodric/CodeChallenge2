<?php

namespace App;


class UserValidator
{

    /**
     * UserValidator constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $token
     * @return User
     * @throws \Exception
     */
    public function getUserFromToken($token): User
    {
        if (is_null($token)) {
            throw new \Exception('Token invalid');
        }

        return new User;
    }

}