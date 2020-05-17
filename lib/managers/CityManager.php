<?php
require_once __DIR__."/../City.class.php";
require_once "BaseManager.php";
require_once "ManagerCreator.php";


class CityManager extends BaseManager
{
    protected $meta;
    protected $managerCreator;
    protected $bindingOption;

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->meta = [
            "className" => "City",
            "table" => "cities"
        ];
        $dataCreator = [
            "className" => $this->meta["className"],
            "table" => $this->meta["table"]
        ];
        $this->managerCreator = new ManagerCreator($dataCreator);
        $this->bindingOption = [];
    }

    /**
     * Récupère les informations d'une ville en fonction du code postale.
     */
    public function getCityByPostalCode(string $postalCode)
    {
        $query = $this->bdd->prepare("SELECT *
                                      FROM ".$this->meta['table']."
                                      WHERE postal_code = :postal_code");
        $query->bindValue('postal_code', $postalCode, PDO::PARAM_STR);

        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        if ($data == false) {
            return false;
        }
        return $data;
    }

}
