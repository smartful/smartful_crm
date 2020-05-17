<?php
function chargerClassePOPO($classe)
{
    require ucfirst($classe).'.class.php';
}
spl_autoload_register('chargerClassePOPO');