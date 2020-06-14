<?php

class Appartment {
    private $rooms;
    private $cleaningSchedule;

    public function __construct() {
    }

    public function addRoom(string $name, int $size, Person $inhabitant = null) {
        $this->rooms[] = new Room($name, $size, $inhabitant);
    }

    public function addInhabitant(int $room, Person $person) {
        $this->rooms[$room]->addInhabitant($person);
    }

    public function printAppartment() {
        echo "<b>Printing appartment</b>\n\n";
        foreach ($this->rooms as $room) {
            $room->printRoom();
        }
    }

    public function generateCleaningSchedule() {
        $tennants = [];
        foreach ($this->rooms as $room) {
            if (get_class($room->inhabitant) == 'Tennant') {
                $tennants[] = $room->inhabitant->name;
            }
        }
        $this->cleaningSchedule = CleaningSchedule::generate($tennants);
    }

    public function printCleaningSchedule() {
        $this->cleaningSchedule->printSchedule();
    }
}

class CleaningSchedule {

    private $kitchenSchedule;
    private $bathroomSchedule;

    public function __construct() {
        $this->kitchenSchedule = [];
        $this->bathroomSchedule = [];
    }

    public static function generate($tennants) {
        $cs = new self;

        for ($a = 0, $b = 0; $a < 52; $a++) {
            $cs->kitchenSchedule[] = $tennants[++$b % count($tennants)]; 
            $cs->bathroomSchedule[] = $tennants[++$b % count($tennants)]; 
        }

        return $cs;
    }

    public function printSchedule() {
        echo "\n<b>Printing cleaning schedule</b>\n\n";
        for ($a = 0; $a < 52; $a++) {
            echo "Week " . ($a+1) . "\n";
            echo $this->kitchenSchedule[$a] . " is cleaning the kitchen\n";
            echo $this->bathroomSchedule[$a] . " is cleaning the bathroom\n\n";
        }
    }

}

class Room {
    private $name;
    private $size;
    public $inhabitant;

    public function __construct($name, $size, Person $inhabitant = null) {
        $this->name = $name;
        $this->size = $size;
        if (isset($inhabitant)) {
            $this->inhabitant = $inhabitant;
        }
    }

    public function addInhabitant($person) {
        $this->inhabitant = $person;
    }

    public function printRoom() {
        print_r(['name' => $this->name, 'size' => $this->size, 'inhabitant' => $this->inhabitant]);
        echo "\n";
    }
}

abstract class Person {
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

}

class Tennant extends Person {

}


class Landlord extends Person{

}



echo "<pre>";

$appartment = new Appartment();

$inhabitants = [];
$inhabitants['andreas'] = new Tennant('Andreas');

$appartment->addRoom('Garderoben', 8, $inhabitants['andreas']);
$appartment->addRoom('Gregorsz gamla', 15);
$appartment->addRoom('Jonas gamla', 14);
$appartment->addRoom('Williams vrå', 14);
$appartment->addRoom('Köket', 14);
$appartment->addRoom('Badrummet', 10);

$inhabitants['newguy'] = new Tennant('Newguy');
$appartment->addInhabitant(1, $inhabitants['newguy']);

$inhabitants['william'] = new Tennant('William');
$appartment->addInhabitant(3, $inhabitants['william']);

$inhabitants['dan'] = new Landlord('Dan');
$appartment->addInhabitant(2, $inhabitants['dan']);

$appartment->printAppartment();


$appartment->generateCleaningSchedule();
$appartment->printCleaningSchedule();
