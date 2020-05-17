<?php
require_once __DIR__."/../Address.class.php";
require_once "BaseManager.php";
require_once "ManagerCreator.php";


class AddressManager extends BaseManager
{
    protected $meta;
    protected $managerCreator;
    protected $bindingOption;

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->meta = [
            "className" => "Address",
            "table" => "addresses"
        ];
        $dataCreator = [
            "className" => $this->meta["className"],
            "table" => $this->meta["table"]
        ];
        $this->managerCreator = new ManagerCreator($dataCreator);
        $this->bindingOption = ['id_type' => 'int'];
    }

    public function add(Address $address) : int
    {
        $id = parent::add($address);
        return $id;
    }

    public function update(Address $address) : void
    {
        parent::update($address);
    }

    public function delete(Address $address) : void
    {
        parent::delete($address);
    }

    /**
     * Vérifie si une entité Address existe à partir d'un email
     */
    public function existByEmail(string $email) : bool
    {
        $query = $this->bdd->prepare("SELECT COUNT(*) FROM ".$this->meta['table']."
                                      WHERE email = :email");
        $query->bindValue("email", $email, PDO::PARAM_STR);

        $query->execute();
        $isExist = $query->fetchColumn();
        $query->closeCursor();
        return (bool) $isExist;
    }

    /**
     * Récupère une entité Address en fonction de son email
     */
    public function getByEmail(string $email) : object
    {
        $query = $this->bdd->prepare("SELECT *
                                      FROM ".$this->meta['table']."
                                      WHERE email = :email");
        $query->bindValue('email', $email, PDO::PARAM_STR);

        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        $object = new $this->meta['className']($data);
        return $object;
    }
}
