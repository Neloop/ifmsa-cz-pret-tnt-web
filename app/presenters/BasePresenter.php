<?php

namespace App\Presenters;

use Nette;
use App\Menu\MenuControl;
use App\Helpers\AppParams;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var AppParams
     * @inject
     */
    public $appParams;

    protected function createComponentMenu(): MenuControl
    {
        return new MenuControl();
    }

    protected function startup(): void
    {
        parent::startup();

        $this->template->appParams = $this->appParams;
    }
}
