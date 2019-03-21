<?php

namespace App\Commands\Traits;

/**
 * Trait GitUserTrait
 * @package App\Commands\Traits
 */
trait GitUserTrait
{
    /**
     * @return string
     */
    public function getUsername()
    {
        $username = exec('git config --get user.name');

        if (empty($username)) {
            $username = strstr($this->getEmail(), '@', true);
        }

        return $username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        $email = exec('git config --get user.email');

        return $email;
    }
}
