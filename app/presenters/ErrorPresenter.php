<?php

namespace App\Presenters;

use Nette;
use Nette\Application\Responses;
use Tracy\ILogger;


class ErrorPresenter implements Nette\Application\IPresenter
{
	use Nette\SmartObject;

	/** @var ILogger */
	private $logger;


	public function __construct(ILogger $logger)
	{
		$this->logger = $logger;
	}


	/**
	 * @return Nette\Application\IResponse
	 */
	public function run(Nette\Application\Request $request)
	{
		$e = $request->getParameter('exception');

		if ($e instanceof Nette\Application\BadRequestException) {
			// $this->logger->log("HTTP code {$e->getCode()}: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}", 'access');

            // load template 403.latte or 404.latte or ... 4xx.latte
            $file = __DIR__ . "/templates/Error/{$e->getCode()}.latte";
            $this->template->setFile(is_file($file) ? $file : __DIR__ . '/templates/Error/4xx.latte');
        } else {
            $this->logger->log($e, ILogger::EXCEPTION);
            return new Responses\CallbackResponse(function () {
                require __DIR__ . '/templates/Error/500.phtml';
            });
        }
	}

}
