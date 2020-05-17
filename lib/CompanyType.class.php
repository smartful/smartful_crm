<?php
require_once "Base.php";

class CompanyType extends Base
{
    protected $id;
    protected $code;
    protected $name;

    public function __construct($data)
    {
        $this->hydrate($data);
    }
}