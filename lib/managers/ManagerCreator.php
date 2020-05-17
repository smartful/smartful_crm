<?php
//chargement des classes
require_once __DIR__."/../autoload.inc.php";
require_once __DIR__."/../Base.php";

class ManagerCreator extends Base
{
    protected $className;
    protected $table;

    public function __construct($data)
    {
        $this->hydrate($data);
    }

    /**
     * Prend les attributs de la classe et les traduits en chaîne de caractères.
     */
    private function getInsertFields() : array
    {
        $object = new $this->className([]);
        $attributes = $object->arrayAttributes();
        $result = [];
        $fields = "";
        $tags = "";
        foreach ($attributes as $attribute) {
            if ($attribute == "id") {
                continue;
            }
            $fields .= $attribute.", ";
            $tags .= ":".$attribute.", ";
        }
        $fields = substr($fields, 0, -2);
        $tags = substr($tags, 0, -2);
        $result = [
            "fields" => $fields,
            "tags" => $tags
        ];
        return $result;
    }

    /**
     * Adapte les attributs de la classe pour l'usage lors d'un Update
     */
    private function getSettingFields() : string
    {
        $attributes = explode(", ", $this->getInsertFields()['fields']);
        $tags = explode(", ", $this->getInsertFields()['tags']);
        $settingFields = "";
        for ($i = 0; $i < count($attributes); $i++) {
            $settingFields .= $attributes[$i]." = ".$tags[$i].", ";
        }
        $settingFields = substr($settingFields, 0, -2);

        return $settingFields;
    }

    /**
     * Adapte les attributs de la classe pour l'usage lors d'un Select
     */
    private function getReadFields(array $formatDates = []) : string
    {
        $attributes = "id, ";
        $attributesArray = explode(", ", $this->getInsertFields()['fields']);
        foreach ($attributesArray as $attribute) {
            if (array_key_exists($attribute, $formatDates)) {
                $attributes .= "DATE_FORMAT(".$attribute.",'".$formatDates[$attribute]."') AS ".$attribute.", ";
            } else {
                $attributes .= $attribute.", ";
            }
        }
        $attributes = substr($attributes, 0, -2);

        return $attributes;
    }

    /**
     * Génère une requête d'ajout
     */
    public function getAddQuery() : string
    {
        $query = "INSERT INTO ".$this->table."(".$this->getInsertFields()['fields'].") ".
                 "VALUES(".$this->getInsertFields()['tags'].")";
        return $query;
    }

    /**
     * Génère une requête de mise à jour
     */
    public function getUpdateQuery() : string
    {
        $query = "UPDATE ".$this->table." SET ".$this->getSettingFields()." WHERE id = :id";
        return $query;
    }

    /**
     * Génère une requête de suppression
     */
    public function getDeleteQuery() : string
    {
        $query = "DELETE FROM ".$this->table." WHERE id = :id";
        return $query;
    }

    /**
     * Génère une requête de lecture
     */
    public function getReadQuery(array $formatOption = [], bool $isList = false) : string
    {
        $query = "SELECT ".$this->getReadFields($formatOption)." FROM ".$this->table;
        if (!$isList) {
            $query .= " WHERE id = :id";
        }

        return $query;
    }

    /**
     * Génère une requête de lecture de l'ID d'une table de relation
     */
    public function getIdRelationshipQuery() : string
    {
        $matching = explode(", ", $this->getSettingFields());
        $query = "SELECT id FROM ".$this->table." WHERE ".$matching[0]." AND ".$matching[1];
        return $query;
    }

    /**
     * Génère un tableau contenant les bind des valeurs des attributs à leur étiquette dans une requête
     */
    public function getBindOperation(string $objectName, array $options = []) : array
    {
        $bindOperations = [];
        $attributes = explode(", ", $this->getInsertFields()['fields']);

        foreach ($attributes as $attribute) {
            $pdo_param = "PDO::PARAM_STR";
            foreach ($options as $attributeNotString => $type) {
                if ($attributeNotString == $attribute) {
                    switch ($type) {
                        case 'int':
                            $pdo_param = "PDO::PARAM_INT";
                            break;
                        case 'bool':
                            $pdo_param = "PDO::PARAM_BOOL";
                            break;
                        default:
                            $pdo_param = "PDO::PARAM_STR";
                    }
                }
            }

            $binding = '$query->bindValue("'.$attribute.'", $'.$objectName.'->get("'.$attribute.'"), '.$pdo_param.');';
            $bindOperations[] = $binding;
        }

        return $bindOperations;
    }

    /**
     * Génère un tableau contenant les bind pour les tables de relation
     */
    public function getBindRelationship(array $tab) : array
    {
        $bindOperations = [];
        $attributes = explode(", ", $this->getInsertFields()['fields']);

        $i = 0;
        foreach ($attributes as $attribute) {
            $binding = '$query->bindValue("'.$attribute.'", $tab['.$i.'], PDO::PARAM_INT);';
            $bindOperations[] = $binding;
            $i++;
        }

        return $bindOperations;
    }
}