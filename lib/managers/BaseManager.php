<?php
require_once __DIR__."/../Base.php";
require_once "ManagerCreator.php";

abstract class BaseManager
{
    protected $bdd;
    protected $meta;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    /**
     * Vérifie si une entité existe à partir d'un ID
     */
    public function exist($id) : bool
    {
        $id = (int) $id;
        $query = $this->bdd->prepare("SELECT COUNT(*) FROM ".$this->meta['table']." WHERE id = :id");
        $query->bindValue("id", $id, PDO::PARAM_INT);

        $query->execute();
        $isExist = $query->fetchColumn();
        $query->closeCursor();
        return (bool) $isExist;
    }

    /**
     * Retourne le nombre d'entité
     */
    public function count() : int
    {
        $query = $this->bdd->query("SELECT COUNT(*) FROM ".$this->meta['table']);

        $nombre = $query->fetchColumn();
        $query->closeCursor();
        return $nombre;
    }

    /**
     * Ajout d'une entité
     */
    public function add(Base $object): int
    {
        $objectName = array_keys(get_defined_vars())[0];
        $query = $this->bdd->prepare($this->managerCreator->getAddQuery());
        foreach ($this->managerCreator->getBindOperation($objectName, $this->bindingOption) as $bindOperation) {
            eval($bindOperation);
        }

        $query->execute();
        $query->closeCursor();
        $id = (int) $this->bdd->lastInsertId();
        return $id;
    }

    /**
     * Mise à jour d'une entité
     */
    public function update(Base $object) : void
    {
        $objectName = array_keys(get_defined_vars())[0];
        $query = $this->bdd->prepare($this->managerCreator->getUpdateQuery());
        foreach ($this->managerCreator->getBindOperation($objectName, $this->bindingOption) as $bindOperation) {
            eval($bindOperation);
        }
        $query->bindValue("id", $object->get("id"), PDO::PARAM_INT);

        $query->execute();
        $query->closeCursor();
    }

    /**
     * Supprime une entité de la base de données
     */
    public function delete(Base $object) : void
    {
        $query = $this->bdd->prepare($this->managerCreator->getDeleteQuery());
        $query->bindValue("id", $object->get("id"), PDO::PARAM_INT);

        $query->execute();
        $query->closeCursor();
    }

    /**
     * Récupère une entité en fonction de son ID
     */
    public function get($id, array $formatDate = []) : object
    {
        $id = (int) $id;
        $query = $this->bdd->prepare($this->managerCreator->getReadQuery($formatDate));
        $query->bindValue('id', $id, PDO::PARAM_INT);

        $query->execute();
        $data = $query->fetch();
        $query->closeCursor();
        $object = new $this->meta['className']($data);
        return $object;
    }

    /**
     * Récupère la liste des entités
     */
    public function getList(array $formatDate = []) : array
    {
        $objects = [];
        $query = $this->bdd->query($this->managerCreator->getReadQuery($formatDate, true));
        while ($data = $query->fetch()) {
            $objects[] = new $this->meta['className']($data);
        }
        
        $query->closeCursor();
        return $objects;
    }

    /**
     * Récupère l'ID de l'entite en fonction du nom rentré en paramètre
     */
    public function getIdByTypeName($type)
    {
        $query = $this->bdd->prepare("SELECT id
                                      FROM ".$this->meta['table']."
                                      WHERE code LIKE :type");
        $query->bindValue('type', "%".$type."%", PDO::PARAM_STR);

        $query->execute();
        $id = $query->fetchColumn();
        $query->closeCursor();
        if ($id == false) {
            return false;
        }
        return (int) $id;
    }

    /**
     * Récupère l'ID d'une table de relation en fonction des ID des 2 tables mises en relation
     */
    public function getRelationshipId(int $tableAId, int $tableBId) : int
    {
        $tab = [$tableAId, $tableBId];
        $query = $this->bdd->prepare($this->managerCreator->getIdRelationshipQuery());
        foreach ($this->managerCreator->getBindRelationship($tab) as $bindOperation) {
            eval($bindOperation);
        }

        $query->execute();
        $result = $query->fetch(PDO::FETCH_NUM);
        $id = (int) $result[0];
        $query->closeCursor();
        if ($id == false) {
            return false;
        }
        return $id;
    }
}