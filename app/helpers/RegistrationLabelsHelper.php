<?php

namespace App\Helpers;

/**
 * Registration labels holder which is able to find label value to appropriate
 * label key identification.
 */
class RegistrationLabelsHelper
{
    /**
     * List of all labels which this helper contains.
     * @var array
     */
    private $labels = array(
            "firstname" => "Firstname",
            "surname" => "Surname",
            "email" => "Email",
            "phone" => "Phone Number",
            "allergies" => "Allergies",
            "diet" => "Diet",
            "visaNeeded" => "Do you need a visa to the Czech republic?",
            "invitationLetterNeeded" => "Do you need an invitation letter?",
            "nmo" => "NMO",
            "nmoPosition" => "Position in NMO",
            "ifmsaEventsAttended" => "IFMSA events attended",
            "universityFaculty" => "University/Faculty",
            "city" => "City",
            "yearOfStudy" => "Year of Study",
            "motivation" => "What is your Motivation to attend the PRET/TNT?",
            "pretOrTnt" => "PRET/TNT",
            "tntStrengthsAsTrainer" => "What are your strengths and how will they help you to perform as a trainer?",
            "tntVisionAsTrainer" => "What is your vision of a trainer in IFMSA?",
            "tntUsageOfKnowledge" => "How do you plan to use the acquired knowledge as a trainer?"
        );

    /**
     * For the given key find appropriate label values.
     * @param string $key
     * @return string
     */
    public function getLabel(string $key): string
    {
        return $this->labels[$key];
    }
}
