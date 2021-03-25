<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;

/**
 * Special form derived from basic nette form for Twitter bootstrap css/js
 * framework. During construction renderer is appropriatelly set up.
 *
 * @method void addReCaptcha(string $controlName, ?string $label, ?string $errorMessage)
 */
class BootstrapForm extends Form
{
    /**
     * Set up parent instance and appropriate rendering for bootstrap.
     * @param IContainer|null $parent
     * @param null $name
     */
    public function __construct(IContainer $parent = null, $name = null)
    {
        parent::__construct($parent, $name);

        /** @var object $renderer */
        $renderer = $this->getRenderer();
        $renderer->wrappers['controls']['container'] = 'div class="row"';
        $renderer->wrappers['pair']['container'] = 'div class="form-group col-12"';
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = null;
        $renderer->wrappers['label']['container'] = null;
        $renderer->wrappers['control']['description'] = 'span class="help-block"';
        $renderer->wrappers['control']['errorcontainer'] = 'span class="help-block text-danger"';
        $renderer->wrappers['error']['container'] = 'div';
        $renderer->wrappers['error']['item'] = 'div class="alert alert-danger" role="alert"';
        $this->getElementPrototype()->class('form-horizontal');

        $this->onRender[] = function ($form) {
            foreach ($form->getControls() as $control) {
                $type = $control->getOption('type');
                if ($type === 'button') {
                    $control->getControlPrototype()->addClass(empty($usedPrimary) ? 'btn btn-primary' : 'btn btn-default');
                    $usedPrimary = true;
                } elseif (in_array($type, ['text', 'textarea', 'select'], true)) {
                    $control->getControlPrototype()->addClass('form-control');
                } elseif (in_array($type, ['checkbox', 'radio'], true)) {
                    $control->getSeparatorPrototype()->setName('div')->addClass($type);
                }
            }
        };
    }
}
