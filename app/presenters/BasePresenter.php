<?php

namespace App\Presenters;

use Nette;
use App\Menu\MenuControl;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    protected function createComponentMenu()
    {
        return new MenuControl();
    }
}
