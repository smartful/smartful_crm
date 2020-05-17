<?php
require_once __DIR__."/../Base.php";

class HtmlTools extends Base
{
    protected $fields = [];
    protected $values = [];

    public function __construct(array $fields, array $values)
    {
        $this->fields = $fields;
        $this->values = $values;
    }

    /**
     * Vérifie que les champs d'un formulaire sont bien remplies
     */
    public function isFormFilled() : bool
    {
        foreach ($this->fields as $key => $value) {
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Transforme un tableau de valeurs en une liste d'options pour une balise <select>
     */
    public function createOptionFromValues() : string
    {
        $optionBlock = "";
        foreach ($this->values as $key => $value) {
            $optionBlock .= "<option value='" . $value . "'>" . $value;
        }
        return $optionBlock;
    }

    /**
     * Vérifie que la chaîne de caractère est bien un email
     */
    public static function isEmail(string $emailInput) : bool
    {
        if (preg_match("#^[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", trim($emailInput))) {
            return true;
        }
        return false;
    }
}
