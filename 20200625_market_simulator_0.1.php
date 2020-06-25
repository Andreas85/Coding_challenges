<?php

echo "<pre>";

class Item {
    public $name;
    public $quantity;

    public static function randomize() {
        $possibleItems = ['Chicken', 'Potato', 'Shovel'];

        $item = new self;
        $item->name = $possibleItems[rand(0, count($possibleItems) - 1)];
        $item->quantity = rand(1, 3);

        return $item;
    }
}

class Value {
    public $name;
    public $quantity;

    public static function randomize() {
        $possibleValues = ['Chicken', 'Potato', 'Shovel'];

        $value = new self;
        $value->name = $possibleValues[rand(0, count($possibleValues) - 1)];
        $value->quantity = rand(1, 3);

        return $value;
    }
}

class Person {
    private $values;
    private $possessions;

    public function __construct() {
        $values = [];
        $possessions = [];
    }

    public function addValue($value) {
        $this->values[] = $value;
    }

    public function getValues() {
        return $this->values;
    }

    public function addPossession(Item $possession) {
        $this->possessions[] = $possession;
    }

    public function getPossessions() {
        return $this->possessions;
    }

}

class Market {
    public function __construct() {
    }

    public function attemptTrade(Person $person1, Person $person2) {
        $person1Value = $person1->getValues()[0];
        $person1Possession = $person1->getPossessions()[0];

        $person2Value = $person2->getValues()[0];
        $person2Possession = $person2->getPossessions()[0];

        echo "Person 1 has " . $person1Possession->quantity . " " . $person1Possession->name;
        echo "<br>";
        echo "Person 1 wants " . $person1Value->quantity . " " . $person1Value->name;
        echo "<br>";
        echo "<br>";
        echo "Person 2 has " . $person2Possession->quantity . " " . $person2Possession->name;
        echo "<br>";
        echo "Person 2 wants " . $person2Value->quantity . " " . $person2Value->name;
        echo "<br>";

        if (
            (
                $person1Value->quantity <= $person2Possession->quantity &&
                $person1Value->name == $person2Possession->name
            ) &&
            (
                $person2Value->quantity <= $person1Possession->quantity &&
                $person2Value->name == $person1Possession->name
            )
        ) {
            echo "Trade was made\n";
        } else {
            echo "Trade could not be made\n";
        }
    }

}

$person1 = new Person();
$person1->addValue(Value::randomize());
$person1->addPossession(Item::randomize());

$person2 = new Person();
$person2->addValue(Value::randomize());
$person2->addPossession(Item::randomize());

$market = new Market();

$market->attemptTrade($person1, $person2);
