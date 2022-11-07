<?php

namespace iutnc\sae\db;


class User
{
    private string $email;
    private string $passwd;
    private int $role;

    /**
     * @param string $email
     * @param string $passwd
     * @param int $role
     */
    public function __construct(string $email, string $passwd, int $role)
    {
        $this->email = $email;
        $this->passwd = $passwd;
        $this->role = $role;
    }


    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }






}