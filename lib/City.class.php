<?php
require_once "Base.php";

class City extends Base
{
    protected $id;
    protected $name;
    protected $postal_code;
    protected $latitude_deg;
    protected $longitude_deg;

    public function __construct($data)
    {
        $this->hydrate($data);
    }
}