<?php

namespace App\Menu;

use Nette;

/**
 * Control containing menu with all its items and rendering set up.
 */
class MenuControl extends Nette\Application\UI\Control
{
    /**
     * Create all MenuItem object which should be in the menu.
     * @return array list of menu items
     */
    private function createItems(): array
    {
        $items = array();

        // create all top level items
        $items[] = new MenuItem("Homepage", "Homepage");
        $items[] = $aboutUs = new MenuItem("About Us", "AboutUs");
        $items[] = $pret = new MenuItem("PRET", "Pret");
        $items[] = $tnt = new MenuItem("TNT", "Tnt");
        $items[] = $venues = new MenuItem("Venues", "Venues");
        $items[] = $registration = new MenuItem("Registration & fees", "Registration");
        $items[] = new MenuItem("Contacts", "Contacts");
        $items[] = new MenuItem("Sponzors", "Sponzors");

        $aboutUs->subItems[] = new MenuItem("IFMSA CZ", "AboutUs", "ifmsaCz");
        $aboutUs->subItems[] = new MenuItem("Prague", "AboutUs", "prague");
        $aboutUs->subItems[] = new MenuItem("How to reach us", "AboutUs", "reachUs");

        $pret->subItems[] = new MenuItem("Basic information", "Pret", "information");
        //$pret->subItems[] = new MenuItem("Agenda", "Pret", "agenda");
        $pret->subItems[] = new MenuItem("Trainers", "Pret", "trainers");
        //$pret->subItems[] = new MenuItem("Social programme", "Pret", "socialProgramme");

        $tnt->subItems[] = new MenuItem("Basic information", "Tnt", "information");
        //$tnt->subItems[] = new MenuItem("Agenda", "Tnt", "agenda");
        $tnt->subItems[] = new MenuItem("Trainers", "Tnt", "trainers");
        //$tnt->subItems[] = new MenuItem("Social programme", "Tnt", "socialProgramme");

        //$venues->subItems[] = new MenuItem("Boarding", "Venues", "boarding");
        $venues->subItems[] = new MenuItem("Accommodation", "Venues", "accommodation");
        //$venues->subItems[] = new MenuItem("Transportation", "Venues", "transportation");
        //$venues->subItems[] = new MenuItem("Main event", "Venues", "mainEvent");

        $registration->subItems[] = new MenuItem("Timetable & fees", "Registration", "information");
        $registration->subItems[] = new MenuItem("PRET Registration", "Registration", "pretForm");
        $registration->subItems[] = new MenuItem("TNT Registration", "Registration", "tntForm");

        if ($this->presenter->user->isLoggedIn()) {
            $items[] = $priv = new MenuItem("Management", "Private");
            $priv->subItems[] = new MenuItem("List of Participants", "Private", "list");
            $priv->subItems[] = new MenuItem("List of Transactions", "Private", "transactions");
        }

        return $items;
    }

    /**
     * Create all items in menu and figure out which ones are active.
     * @return array list of menu items
     */
    private function create(): array
    {
        $result = $this->createItems();

        foreach ($result as $item) {
            if ($item->linkPresenter == $this->presenter->name) {
                $item->active = true;
            }

            foreach ($item->subItems as $subItem) {
                if ($subItem->linkPresenter == $this->presenter->name &&
                        $subItem->linkAction == $this->presenter->action) {
                    $subItem->active = true;
                }
            }
        }

        return $result;
    }

    /**
     * Render menu from special template and display all items.
     */
    public function render()
    {
        $this->template->setFile(__DIR__ . '/menu.latte');

        // push some values into template
        $this->template->items = $this->create();

        // and render it
        $this->template->render();
    }
}
