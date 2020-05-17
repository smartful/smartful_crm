<?php
require_once "Base.php";

class Address extends Base
{
    protected $id;
    protected $id_city;
    protected $address_1;
    protected $address_2;
    protected $email;
    protected $phone;

    public function __construct($data)
    {
        $this->hydrate($data);
    }
}