<?php
namespace App\Models;

use App\Services\Database;

class User
{
    private $id;
    private $username;
    private $email;
    private $passwordHash;
    private $role;
    public function __construct($username, $email, $passwordHash, $role = 'user') {
        $this->username = $username;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
    }

    public function verifyPassword($password) : bool
    {
        return password_verify($password, $this->passwordHash);
    }
}