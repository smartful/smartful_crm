<?php
require_once "Base.php";

class User extends Base
{
    protected $id;
    protected $id_company;
    protected $first_name;
    protected $last_name;
    protected $email;
    protected $password;
    protected $id_profil;
    protected $last_connexion;
    protected $is_active;

    public function __construct($data)
    {
        $this->hydrate($data);
    }
}