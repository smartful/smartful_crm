<?php

require_once __DIR__."/../Base.php";

class MathTools extends Base
{

    /**
     * Calcul la distance entre 2 points dans un espace en 2D
     */
    public static function distance(float $xa, float $ya, float $xb, float $yb) : float
    {
        $result = sqrt(pow($xa - $xb, 2) + pow($ya - $yb, 2));
        return $result;
    }

}