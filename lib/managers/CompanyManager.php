<?php
require_once __DIR__."/../Company.class.php";
require_once "BaseManager.php";
require_once "ManagerCreator.php";


class CompanyManager extends BaseManager
{
    protected $meta;
    protected $managerCreator;
    protected $bindingOption;

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->meta = [
            "className" => "Company",
            "table" => "companies"
        ];
        $dataCreator = [
            "className" => $this->meta["className"],
            "table" => $this->meta["table"]
        ];
        $this->managerCreator = new ManagerCreator($dataCreator);
        $this->bindingOption = [];
    }

    public function add(Company $company) : int
    {
        $id = parent::add($company);
        return $id;
    }

    public function update(Company $company) : void
    {
        parent::update($company);
    }

    public function delete(Company $company) : void
    {
        parent::delete($company);
    }

    /**
     * Récupère la liste des client de l'entreprise
     */
    public function getCustomerList() : array
    {
        $query = $this->bdd->query("SELECT C.*
                                    FROM ".$this->meta['table']." AS C
                                    INNER JOIN company_types AS CT ON (C.id_type = CT.id)
                                    WHERE CT.code = 'CUSTOMER'");
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        $objectArray = [];
        foreach($data as $pieceOfData) {
            $objectArray[] = new $this->meta['className']($pieceOfData);
        }
        return $objectArray;
    }
}
