<?php

require_once __DIR__."/../Base.php";

class DateTools extends Base
{
    protected $dateIso = "";

    public function __construct(string $dateIso)
    {
        $this->dateIso = $dateIso;
    }

    /**
     * Associe un nombre à son mois littéral (FR)
     */
    public static function litteralMonthFr($monthNumber) : string
    {
        $monthsFr = [
            "janvier",
            "février",
            "mars",
            "avril",
            "mai",
            "juin",
            "juillet",
            "août",
            "septembre",
            "octobre",
            "novembre",
            "décembre"
        ];
        return $monthsFr[$monthNumber - 1];
    }

    /**
     * Décompose une date ISO 8601 (YYYY-MM-DD) en dans un tableau
     */
    public function fromIsoToArray() : array
    {
        $year = substr($this->dateIso, 0, 4);
        $month = substr($this->dateIso, 5, 2);
        $day = substr($this->dateIso, 8, 2);
        $dateArray = [
            "day" => (int) $day,
            "month" => (int) $month,
            "year" => (int) $year
        ];
        return $dateArray;
    }

    /**
     * Transforme une date ISO 8601 (YYYY-MM-DD) en texte littéral (ex : 1 octobre 1909)
     */
    public function fromIsoToLitteral() : string
    {
        $arrayDate = $this->fromIsoToArray();
        $litteralMonthFr = self::litteralMonthFr($arrayDate['month']);
        $litteralDate = $arrayDate['day']." ".$litteralMonthFr." ".$arrayDate['year'];
        return $litteralDate;
    }

    /**
     * Obtenir le timestamp de la date
     */
    public function getTimestamp() : int
    {
        $arrayDate = $this->fromIsoToArray();
        return mktime(0, 0, 0, $arrayDate['month'], $arrayDate['day'], $arrayDate['year']);
    }
}