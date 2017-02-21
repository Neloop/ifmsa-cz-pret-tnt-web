<?php

namespace App\Forms;

use App\Model\Entity\Participant;
use App\Model\Repository\Participants;
use App\Helpers\RegistrationLabelsHelper;
use App\Helpers\Emails\RegistrationEmailsSender;
use Nette\Forms\Form;

/**
 * Factory for both registration forms used by participants.
 */
class RegistrationFormsFactory
{
    /**
     * Participants repository.
     * @var Participants
     */
    private $participants;
    /**
     * Labels helper.
     * @var RegistrationLabelsHelper
     */
    private $labelsHelper;
    /**
     * Helper which sends registration emails.
     * @var RegistrationEmailsSender
     */
    private $registrationEmailsSender;

    /**
     * Constructor initialized via DI.
     * @param Participants $participants
     * @param RegistrationLabelsHelper $registrationLabelsHelper
     * @param RegistrationEmailsSender $registrationEmailsSender
     */
    public function __construct(
        Participants $participants,
        RegistrationLabelsHelper $registrationLabelsHelper,
        RegistrationEmailsSender $registrationEmailsSender
    ) {

        $this->participants = $participants;
        $this->labelsHelper = $registrationLabelsHelper;
        $this->registrationEmailsSender = $registrationEmailsSender;
    }

    /**
     * Get all items which should be visible within diet radio list.
     * @return array
     */
    private function getDietItems(): array
    {
        return array(
            "regular" => "Regular",
            "glutenFree" => "Gluten Free",
            "vegetarian" => "Vegetarian",
            "another" => "Another:"
        );
    }

    /**
     * Create basic form which is same for both events.
     * @return BootstrapForm
     */
    private function createBasicRegistrationForm(): BootstrapForm
    {
        $form = new BootstrapForm();

        $form->addText("firstname", $this->labelsHelper->getLabel("firstname"))
                ->setRequired("Firstname is required")
                ->setAttribute("placeholder", $this->labelsHelper->getLabel("firstname"))
                ->addRule(Form::MAX_LENGTH, "Firstname is too long", 255);
        $form->addText("surname", $this->labelsHelper->getLabel("surname"))
                ->setRequired("Surname is required")
                ->setAttribute("placeholder", $this->labelsHelper->getLabel("surname"))
                ->addRule(Form::MAX_LENGTH, "Surname is too long", 255);
        $form->addText("email", $this->labelsHelper->getLabel("email"))
                ->setAttribute("placeholder", $this->labelsHelper->getLabel("email"))
                ->setRequired("Email is required")
                ->addRule(Form::MAX_LENGTH, "Email is too long", 255)
                ->addRule(Form::EMAIL, "Email is not in the right format");
        $form->addText("phone", $this->labelsHelper->getLabel("phone"))
                ->setRequired("Phone is required")
                ->setAttribute("placeholder", $this->labelsHelper->getLabel("phone"))
                ->addRule(Form::MAX_LENGTH, "Phone is too long", 255);
        $form->addText("allergies", $this->labelsHelper->getLabel("allergies"))
                ->setRequired(false)
                ->setAttribute("placeholder", "None")
                ->addRule(Form::MAX_LENGTH, "Allergies text is too long", 1000);
        $form->addRadioList("diet", $this->labelsHelper->getLabel("diet"), $this->getDietItems())
                ->setRequired("Diet is required");
        $form->addText("dietText")->setRequired(false)
                ->addRule(Form::MAX_LENGTH, "Diet text is too long", 1000);
        $form->addCheckbox("visaNeeded", "Do you need a visa to Czech republic?");
        $form->addCheckbox("invitationLetterNeeded", "Do you need an invitation letter?");

        $form->addText("nmo", $this->labelsHelper->getLabel("nmo"))
                ->setRequired("NMO is required")
                ->setAttribute("placeholder", "National Member Organization")
                ->addRule(Form::MAX_LENGTH, "NMO is too long", 255);
        $form->addText("nmoPosition", $this->labelsHelper->getLabel("nmoPosition"))
                ->setRequired("NMO Position is required")
                ->setAttribute("placeholder", "Position in National Member Organization")
                ->addRule(Form::MAX_LENGTH, "NMO Position is too long", 255);
        $form->addTextArea("ifmsaEventsAttended", $this->labelsHelper->getLabel("ifmsaEventsAttended"))
                ->setRequired(false)
                ->setAttribute("placeholder", "None")
                ->addRule(Form::MAX_LENGTH, "IFMSA events attended text is too long", 1000);

        $form->addText("universityFaculty", $this->labelsHelper->getLabel("universityFaculty"))
                ->setRequired("University/Faculty is required")
                ->setAttribute("placeholder", $this->labelsHelper->getLabel("universityFaculty"))
                ->addRule(Form::MAX_LENGTH, "University/Faculty is too long", 255);
        $form->addText("city", $this->labelsHelper->getLabel("city"))
                ->setRequired("City is required")
                ->setAttribute("placeholder", $this->labelsHelper->getLabel("city"))
                ->addRule(Form::MAX_LENGTH, "City is too long", 255);
        $form->addText("yearOfStudy", $this->labelsHelper->getLabel("yearOfStudy"))
                ->setType("number")->setDefaultValue(1)
                ->setRequired("Year of Study is required")
                ->addRule(Form::INTEGER, "Year of Study has to be integer")
                ->addRule(Form::RANGE, "Year of Study has to be number from 1 to 6", [1, 6]);

        $form->addTextArea("motivation", $this->labelsHelper->getLabel("motivation"))
                ->setRequired("Motivation is required")
                ->setAttribute("placeholder", "Motivation")
                ->addRule(Form::MAX_LENGTH, "Motivation is too long", 1000);

        $form->addReCaptcha('captcha', null, "Please prove you're not a robot.");

        return $form;
    }

    /**
     * Create form specific for PRET event.
     * @return BootstrapForm
     */
    public function createPretRegistrationForm(): BootstrapForm
    {
        $form = $this->createBasicRegistrationForm();
        $form->addSubmit('send', 'Register');
        $form->onSuccess[] = array($this, 'pretRegistrationFormSucceeded');
        return $form;
    }

    /**
     * Create form specific for TNT event.
     * @return BootstrapForm
     */
    public function createTntRegistrationForm(): BootstrapForm
    {
        $form = $this->createBasicRegistrationForm();

        $form->addTextArea("tntStrengthsAsTrainer", $this->labelsHelper->getLabel("tntStrengthsAsTrainer"))
                ->setRequired("Strengths are required")
                ->setAttribute("placeholder", "Strengths as Trainer")
                ->addRule(Form::MAX_LENGTH, "Strengths are too long", 1200);
        $form->addTextArea("tntVisionAsTrainer", $this->labelsHelper->getLabel("tntVisionAsTrainer"))
                ->setRequired("Vision is required")
                ->setAttribute("placeholder", "Vision as Trainer")
                ->addRule(Form::MAX_LENGTH, "Vision is too long", 600);
        $form->addTextArea("tntUsageOfKnowledge", $this->labelsHelper->getLabel("tntUsageOfKnowledge"))
                ->setRequired("Usage of Knowledge is required")
                ->setAttribute("placeholder", "Usage of Gained Knowledge")
                ->addRule(Form::MAX_LENGTH, "Usage of Knowledge too long", 1000);

        $form->addSubmit('send', 'Register');
        $form->onSuccess[] = array($this, 'tntRegistrationFormSucceeded');
        return $form;
    }

    /**
     * Get value of diet from radio list or from additional text if another item
     * was chosen.
     * @param array $values
     * @return string
     */
    private function getDietFromValues($values): string
    {
        if ($values->diet === "another") {
            return $values->dietText;
        } else {
            return $this->getDietItems()[$values->diet];
        }
    }

    /**
     * Create participant entity with some basic information from form values.
     * @param BootstrapForm $form
     * @param array $values
     * @return Participant
     */
    private function createBasicParticipant(BootstrapForm $form, $values): Participant
    {
        $participant = new Participant(
            $values->firstname,
            $values->surname,
            $values->email,
            $values->phone,
            $values->allergies,
            $this->getDietFromValues($values),
            $values->visaNeeded,
            $values->invitationLetterNeeded,
            $values->nmo,
            $values->nmoPosition,
            $values->ifmsaEventsAttended,
            $values->universityFaculty,
            $values->city,
            $values->yearOfStudy,
            $values->motivation
        );
        return $participant;
    }

    /**
     * Called on successful PRET registration form submit. Stores information
     * about participant into database.
     * @param BootstrapForm $form
     * @param array $values
     */
    public function pretRegistrationFormSucceeded(BootstrapForm $form, $values)
    {
        $participant = $this->createBasicParticipant($form, $values);
        $participant->setPret();
        $this->participants->persist($participant);

        $this->registrationEmailsSender->send($participant);
    }

    /**
     * Called on successful TNT registration form submit. Stores information
     * about participant into database.
     * @param BootstrapForm $form
     * @param array $values
     */
    public function tntRegistrationFormSucceeded(BootstrapForm $form, $values)
    {
        $participant = $this->createBasicParticipant($form, $values);
        $participant->setTnt();
        $participant->tntStrengthsAsTrainer = $values->tntStrengthsAsTrainer;
        $participant->tntVisionAsTrainer = $values->tntVisionAsTrainer;
        $participant->tntUsageOfKnowledge = $values->tntUsageOfKnowledge;
        $this->participants->persist($participant);

        $this->registrationEmailsSender->send($participant);
    }
}
