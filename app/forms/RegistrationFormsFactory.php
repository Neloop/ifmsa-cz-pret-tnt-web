<?php

namespace App\Forms;

use App\Model\Entity\Participant;
use App\Model\Repository\Participants;
use App\Helpers\RegistrationLabelsHelper;
use App\Helpers\Emails\RegistrationEmailsSender;
use Nette\Forms\Form;

/**
 *
 * @author Neloop
 */
class RegistrationFormsFactory
{
    /** @var Participants */
    private $participants;
    /** @var RegistrationLabelsHelper */
    private $labelsHelper;
    /** @var RegistrationEmailsSender */
    private $registrationEmailsSender;

    public function __construct(
        Participants $participants,
        RegistrationLabelsHelper $registrationLabelsHelper,
        RegistrationEmailsSender $registrationEmailsSender
    ) {

        $this->participants = $participants;
        $this->labelsHelper = $registrationLabelsHelper;
        $this->registrationEmailsSender = $registrationEmailsSender;
    }

    private function getAllergiesItems()
    {
        return array(
            "no" => "No",
            "yes" => "Yes:"
        );
    }

    private function getDietItems()
    {
        return array(
            "regular" => "Regular",
            "glutenFree" => "Gluten Free",
            "vegetarian" => "Vegetarian",
            "another" => "Another:"
        );
    }

    private function getEventsAttendedItems()
    {
        return array(
            "none" => "None",
            "some" => "Some:"
        );
    }

    private function createBasicRegistrationForm(): BootstrapForm
    {
        $form = new BootstrapForm();

        $form->addText("firstname", $this->labelsHelper->getLabel("firstname"))
                ->setRequired("Firstname is required")
                ->addRule(Form::MAX_LENGTH, "Firstname is too long", 255);
        $form->addText("surname", $this->labelsHelper->getLabel("surname"))
                ->setRequired("Surname is required")
                ->addRule(Form::MAX_LENGTH, "Surname is too long", 255);
        $form->addText("email", $this->labelsHelper->getLabel("email"))
                ->setRequired("Email is required")
                ->addRule(Form::MAX_LENGTH, "Email is too long", 255)
                ->addRule(Form::EMAIL, "Email is not in the right format");
        $form->addText("phone", $this->labelsHelper->getLabel("phone"))
                ->setRequired("Phone is required")
                ->addRule(Form::MAX_LENGTH, "Phone is too long", 255);
        $form->addRadioList("allergies", $this->labelsHelper->getLabel("allergies"), $this->getAllergiesItems())
                ->setRequired("Allergies are required");
        $form->addText("allergiesText")->setRequired(false)
                ->addRule(Form::MAX_LENGTH, "Allergies text is too long", 1000);
        $form->addRadioList("diet", $this->labelsHelper->getLabel("diet"), $this->getDietItems())
                ->setRequired("Diet is required");
        $form->addText("dietText")->setRequired(false)
                ->addRule(Form::MAX_LENGTH, "Diet text is too long", 1000);
        $form->addCheckbox("visaNeeded", "Do you need a visa to Czech republic?");
        $form->addCheckbox("invitationLetterNeeded", "Do you need an invitation letter?");

        $form->addText("nmo", $this->labelsHelper->getLabel("nmo"))
                ->setRequired("NMO is required")
                ->addRule(Form::MAX_LENGTH, "NMO is too long", 255);
        $form->addText("nmoPosition", $this->labelsHelper->getLabel("nmoPosition"))
                ->setRequired("NMO Position is required")
                ->addRule(Form::MAX_LENGTH, "NMO Position is too long", 255);
        $form->addRadioList("ifmsaEventsAttended", $this->labelsHelper->getLabel("ifmsaEventsAttended"), $this->getEventsAttendedItems())
                ->setRequired("IFMSA events attended field is required");
        $form->addText("ifmsaEventsAttendedText")->setRequired(false)
                ->addRule(Form::MAX_LENGTH, "IFMSA events attended text is too long", 1000);

        $form->addText("universityFaculty", $this->labelsHelper->getLabel("universityFaculty"))
                ->setRequired("University/Faculty is required")
                ->addRule(Form::MAX_LENGTH, "University/Faculty is too long", 255);
        $form->addText("city", $this->labelsHelper->getLabel("city"))
                ->setRequired("City is required")
                ->addRule(Form::MAX_LENGTH, "City is too long", 255);
        $form->addText("yearOfStudy", $this->labelsHelper->getLabel("yearOfStudy"))
                ->setType("number")->setDefaultValue(1)
                ->setRequired("Year of Study is required")
                ->addRule(Form::INTEGER, "Year of Study has to be integer")
                ->addRule(Form::RANGE, "Year of Study has to be number from 1 to 6", [1, 6]);

        $form->addText("motivation", $this->labelsHelper->getLabel("motivation"))
                ->setRequired("Motivation is required")
                ->addRule(Form::MAX_LENGTH, "Motivation is too long", 1000);

        return $form;
    }

    public function createPretRegistrationForm(): BootstrapForm
    {
        $form = $this->createBasicRegistrationForm();
        $form->addSubmit('send', 'Register');
        $form->onSuccess[] = array($this, 'pretRegistrationFormSucceeded');
        return $form;
    }

    public function createTntRegistrationForm(): BootstrapForm
    {
        $form = $this->createBasicRegistrationForm();

        $form->addTextArea("tntStrengthsAsTrainer", $this->labelsHelper->getLabel("tntStrengthsAsTrainer"))
                ->setRequired("Strengths are required")
                ->addRule(Form::MAX_LENGTH, "Strengths are too long", 1200);
        $form->addTextArea("tntVisionAsTrainer", $this->labelsHelper->getLabel("tntVisionAsTrainer"))
                ->setRequired("Vision is required")
                ->addRule(Form::MAX_LENGTH, "Vision is too long", 600);
        $form->addTextArea("tntUsageOfKnowledge", $this->labelsHelper->getLabel("tntUsageOfKnowledge"))
                ->setRequired("Usage of Knowledge is required")
                ->addRule(Form::MAX_LENGTH, "Usage of Knowledge too long", 1000);

        $form->addSubmit('send', 'Register');
        $form->onSuccess[] = array($this, 'tntRegistrationFormSucceeded');
        return $form;
    }

    /**
     * @param BootstrapForm $form
     * @param array $values
     * @return bool true if form is ok
     */
    private function checkBasicRegistrationForm(BootstrapForm $form, $values): bool
    {
        return true;
    }

    private function getAllergiesFromValues($values): string
    {
        if ($values->allergies === "yes") {
            return $values->allergiesText;
        } else {
            return $this->getAllergiesItems()[$values->allergies];
        }
    }

    private function getDietFromValues($values): string
    {
        if ($values->diet === "another") {
            return $values->dietText;
        } else {
            return $this->getDietItems()[$values->diet];
        }
    }

    private function getEventsAttendedFromValues($values): string
    {
        if ($values->ifmsaEventsAttended === "some") {
            return $values->ifmsaEventsAttendedText;
        } else {
            return $this->getEventsAttendedItems()[$values->ifmsaEventsAttended];
        }
    }

    private function createBasicParticipant(BootstrapForm $form, $values): Participant
    {
        $participant = new Participant(
            $values->firstname,
            $values->surname,
            $values->email,
            $values->phone,
            $this->getAllergiesFromValues($values),
            $this->getDietFromValues($values),
            $values->visaNeeded,
            $values->invitationLetterNeeded,
            $values->nmo,
            $values->nmoPosition,
            $this->getEventsAttendedFromValues($values),
            $values->universityFaculty,
            $values->city,
            $values->yearOfStudy,
            $values->motivation
        );
        return $participant;
    }

    public function pretRegistrationFormSucceeded(BootstrapForm $form, $values)
    {
        if (!$this->checkBasicRegistrationForm($form, $values)) {
            return;
        }

        $participant = $this->createBasicParticipant($form, $values);
        $participant->setPret();
        $this->participants->persist($participant);

        $this->registrationEmailsSender->send($participant);
    }

    public function tntRegistrationFormSucceeded(BootstrapForm $form, $values)
    {
        if (!$this->checkBasicRegistrationForm($form, $values)) {
            return;
        }

        $participant = $this->createBasicParticipant($form, $values);
        $participant->setTnt();
        $participant->tntStrengthsAsTrainer = $values->tntStrengthsAsTrainer;
        $participant->tntVisionAsTrainer = $values->tntVisionAsTrainer;
        $participant->tntUsageOfKnowledge = $values->tntUsageOfKnowledge;
        $this->participants->persist($participant);

        $this->registrationEmailsSender->send($participant);
    }
}
