<?php

namespace App\Menu;

/**
 * Holder of information about menu items.
 */
class MenuItem
{
    /**
     * Constructor with initial values.
     * @param string $name title of menu item
     * @param string $presenter presenter identification
     * @param string $action action identification
     */
    public function __construct($name, $presenter = "", $action = "")
    {
        $this->name = $name;
        $this->linkPresenter = $presenter;
        $this->linkAction = $action;
    }

    /**
     * True if item is active.
     * @var bool
     */
    public $active = false;

    /**
     * Title of menu item.
     * @var string
     */
    public $name = "";

    /**
     * Presenter identification which will be used in link.
     * @var string
     */
    public $linkPresenter = "";

    /**
     * Action identification used in link.
     * @var string
     */
    public $linkAction = "";

    /**
     * Array of this item sub items.
     * @var array
     */
    public $subItems = array();
}
