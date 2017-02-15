<?php

namespace App\Presenters;

use Nette\Http\IResponse;
use App\Helpers\PrivateParams;
use App\Model\Repository\Participants;
use App\Helpers\RegistrationLabelsHelper;

class PrivatePresenter extends BasePresenter
{
    /**
     * @var PrivateParams
     * @inject
     */
    public $privateParams;

    /**
     * @var Participants
     * @inject
     */
    public $participants;

    /**
     * @var RegistrationLabelsHelper
     * @inject
     */
    public $registrationLabelsHelper;

    public function startup()
    {
        parent::startup();

        if (!isset($_SERVER['PHP_AUTH_USER']) ||
                $_SERVER['PHP_AUTH_USER'] !== $this->privateParams->getUsername() ||
                $_SERVER['PHP_AUTH_PW'] !== $this->privateParams->getPassword()) {
            $response = $this->getHttpResponse();
            $response->setHeader('WWW-Authenticate', 'Basic realm="PRET&TNT CZ Private Parts"');
            $response->setCode(IResponse::S401_UNAUTHORIZED);

            echo "<h1>Authentication failed</h1>";

            $this->terminate();
        }
    }

    public function actionDefault()
    {
        $this->template->participants = $this->participants->findAll();
    }

    public function actionParticipant($id)
    {
        $this->template->labelsHelper = $this->registrationLabelsHelper;
        $this->template->participant = $this->participants->findOrThrow($id);
    }
}
