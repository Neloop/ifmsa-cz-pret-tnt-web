<?php

namespace App\Presenters;

use Nette;
use App\Menu\MenuControl;
use App\Helpers\AppConfig;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var AppConfig
     * @inject
     */
    public $appConfig;

    protected function createComponentMenu()
    {
        return new MenuControl();
    }

    protected function startup()
    {
        parent::startup();

        $this->template->appConfig = $this->appConfig;
    }
}
