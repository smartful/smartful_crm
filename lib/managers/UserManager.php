<?php
require_once __DIR__."/../User.class.php";
require_once "BaseManager.php";
require_once "ManagerCreator.php";


class UserManager extends BaseManager
{
    protected $meta;
    protected $managerCreator;
    protected $bindingOption;

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->meta = [
            "className" => "User",
            "table" => "users"
        ];
        $dataCreator = [
            "className" => $this->meta["className"],
            "table" => $this->meta["table"]
        ];
        $this->managerCreator = new ManagerCreator($dataCreator);
        $this->bindingOption = [
            'id_company' => 'int',
            'id_profil' => 'int'
        ];
    }

    public function add(User $user) : int
    {
        $id = parent::add($user);
        return $id;
    }

    public function update(User $user) : void
    {
        parent::update($user);
    }

    public function delete(User $user) : void
    {
        parent::delete($user);
    }

    /**
     * Vérifie si une entité existe à partir du email User
     */
    public function existByEmail(string $email) : bool
    {
        $query = $this->bdd->prepare("SELECT COUNT(*) FROM ".$this->meta['table']."
                                      WHERE email = :email
                                      AND is_active = 1");
        $query->bindValue("email", $email, PDO::PARAM_STR);

        $query->execute();
        $isExist = $query->fetchColumn();
        $query->closeCursor();
        return (bool) $isExist;
    }

    /**
     * Récupère une entité User en fonction de son email
     */
    public function getByEmail(string $email) : object
    {
        $query = $this->bdd->prepare("SELECT *
                                      FROM ".$this->meta['table']."
                                      WHERE email = :email
                                      AND is_active = 1");
        $query->bindValue('email', $email, PDO::PARAM_STR);

        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $query->closeCursor();
        $object = new $this->meta['className']($data);
        return $object;
    }

    /**
     * Récupère la liste des user par entreprise
     */
    public function getListByCompany(int $id_company) : array
    {
        $query = $this->bdd->prepare("SELECT *
                                      FROM ".$this->meta['table']."
                                      WHERE is_active = 1
                                      AND id_company = :id_company");
        $query->bindValue("id_company", $id_company, PDO::PARAM_INT);
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $data;
    }

    /**
     * Vérifie si une entité existe à partir d'un email
     */
    public function existByMail(string $email) : bool
    {
        $query = $this->bdd->prepare("SELECT COUNT(*) FROM ".$this->meta['table']."
                                      WHERE email LIKE :email ");
        $query->bindValue("email", "%".$email."%", PDO::PARAM_STR);

        $query->execute();
        $isExist = $query->fetchColumn();
        $query->closeCursor();
        return (bool) $isExist;
    }

    /**
     * Récupère une entité en fonction de son email
     * En effet, l'email doit être unique.
     */
    public function getByMail(string $email) : array
    {
        $objects = [];
        $query = $this->bdd->prepare("SELECT * FROM ".$this->meta['table']."
                                      WHERE email LIKE :email ");
        $query->bindValue('email', "%".$email."%", PDO::PARAM_STR);

        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        foreach ($data as $objectData) {
            $objects[] = new $this->meta['className']($objectData);
        }
        return $objects;
    }
}
