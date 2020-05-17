<?php
require_once "Base.php";

class Company extends Base
{
    protected $id;
    protected $id_address;
    protected $id_type;
    protected $name;
    protected $siret;
    protected $siren;

    public function __construct($data)
    {
        $this->hydrate($data);
    }
}