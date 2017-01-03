<?php

namespace App\Menu;

/**
 * Description of MenuItem
 */
class MenuItem
{
    public function __construct($name, $presenter = "", $action = "")
    {
        $this->name = $name;
        $this->linkPresenter = $presenter;
        $this->linkAction = $action;
    }

    public $active = false;
    public $name = "";
    public $linkPresenter = "";
    public $linkAction = "";
    public $subItems = array();
}
