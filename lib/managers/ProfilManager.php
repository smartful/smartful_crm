<?php
require_once __DIR__."/../Profile.class.php";
require_once "BaseManager.php";
require_once "ManagerCreator.php";


class ProfileManager extends BaseManager
{
    protected $meta;
    protected $managerCreator;
    protected $bindingOption;

    public function __construct($bdd)
    {
        parent::__construct($bdd);
        $this->meta = [
            "className" => "Profile",
            "table" => "profiles"
        ];
        $dataCreator = [
            "className" => $this->meta["className"],
            "table" => $this->meta["table"]
        ];
        $this->managerCreator = new ManagerCreator($dataCreator);
        $this->bindingOption = [];
    }

    public function add(Profile $profile) : int
    {
        $id = parent::add($profile);
        return $id;
    }

    public function update(Profile $profile) : void
    {
        parent::update($profile);
    }

    public function delete(Profile $profile) : void
    {
        parent::delete($profile);
    }
}
