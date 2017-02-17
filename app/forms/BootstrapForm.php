<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

class BootstrapForm extends Form
{
    public function __construct(Nette\ComponentModel\IContainer $parent = null, $name = null)
    {
        parent::__construct($parent, $name);

        $renderer = $this->getRenderer();
        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['pair']['container'] = 'div class="form-group row"';
        $renderer->wrappers['pair']['.error'] = 'has-error';
        $renderer->wrappers['control']['container'] = 'div class="col-10"';
        $renderer->wrappers['label']['container'] = 'div class="col-2 control-label"';
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
