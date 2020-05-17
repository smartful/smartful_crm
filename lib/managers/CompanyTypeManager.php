<?php
require_once __DIR__."/../CompanyType.class.php";
require_once "BaseManager.php";
require_once "ManagerCreator.php";


class CompanyTypeManager extends BaseManager
{
    protected $meta;
    protected $managerCreator;
    protected $bindingOption;

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->meta = [
            "className" => "CompanyType",
            "table" => "company_types"
        ];
        $dataCreator = [
            "className" => $this->meta["className"],
            "table" => $this->meta["table"]
        ];
        $this->managerCreator = new ManagerCreator($dataCreator);
        $this->bindingOption = [];
    }

    public function add(CompanyType $company_type) : int
    {
        $id = parent::add($company_type);
        return $id;
    }

    public function update(CompanyType $company_type) : void
    {
        parent::update($company_type);
    }

    public function delete(CompanyType $company_type) : void
    {
        parent::delete($company_type);
    }
}
