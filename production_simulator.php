<html>
  <head>
    <link rel="stylesheet" href="css/economics_simulator.css">
  </head>
<body>
<pre>
<?php

class Land {
    public $objects;

    public function __construct() {
        echo "Spawning land\n";
        $this->objects[] = new Lake();
        $this->objects[] = new CoconutTree();
        $this->objects[] = new YewTree();
        $this->objects[] = new YewTree();
    }

    public function addObjectsToLand(LandObject $obj) {
        $this->objects[] = $obj;
    }

    public function find($objectToLocate) {
        foreach ($this->objects as $key => $obj) {
            if (get_class($obj) === $objectToLocate) {
                return $key;
            }
        }
        return false;
    }
}

class Lake {
    public $fish;

    public function __construct() {
        echo "Spawning lake\n";
        $this->fish[] = new Fish(1, null, '');
        $this->fish[] = new Fish(1, null, '');
        $this->fish[] = new Fish(1, null, '');
        $this->fish[] = new Fish(1, null, '');
        $this->fish[] = new Fish(1, null, '');
        $this->fish[] = new Fish(1, null, '');
        $this->fish[] = new Fish(1, null, '');
    }
}

class CoconutTree {
    public $coconuts;

    public function __construct() {
        echo "Spawning coconut tree\n";
        $this->coconuts[] = new Coconut(1, null, '');
        $this->coconuts[] = new Coconut(1, null, '');
        $this->coconuts[] = new Coconut(1, null, '');
        $this->coconuts[] = new Coconut(1, null, '');
        $this->coconuts[] = new Coconut(1, null, '');
    }
}

class YewTree {
    public $unit;
    public $quantity;

    public function __construct() {
        echo "Spawning yew tree\n";
        $this->unit = 'kg';
        $this->quantity = 30;
    }
}


class Means {
    public $cost;
    public $available;
    public $unit;
    public $getsUsedUpInProduction;

    public function __construct($available, $cost, $unit, $getsUsedUpInProduction = true) {
        if ($available !== null) {
            $this->available = $available;
        }

        if ($cost !== null) {
            $this->cost = $cost;
        }

        $this->getsUsedUpInProduction = $getsUsedUpInProduction;
        $this->unit = $unit;
    }
}

class Time extends Means {
    const tradable = false;
}

class Axe extends Means {
    const tradable = true;
}

class Knife extends Means {
    const tradable = true;
}

class FishingLine extends Means {
    const tradable = true;
}

class Hook extends Means {
    const tradable = true;
}

class Wood extends Means {
    const tradable = true;
}

class Fish extends Means {
    const tradable = true;
}


class FishingPole extends Means {
    const tradable = true;
}

class Coconut extends Means{
    const tradable = true;
}

class Human {
    public $name;
    public $means;

    public $skills;
    public $values;

    public function __construct($name) {
        $this->name = $name;
        $this->skills["PickCoconuts"] = rand(0, 10);
        $this->skills["GoFishing"] = rand(0, 10);
    }

    public function addMeans(Means $means) {
        $this->means[] = $means;
    }

    public function showHuman() {
        echo "\n\n";
        echo $this->name . ":\n";
        echo "Available means:\n";
        if (isset($this->means)) {
            foreach ($this->means as $mean) {
                echo "  " . $mean->available . " ";
                echo $mean->unit . " ";
                echo get_class($mean) . "\n";
            }
        }
        echo "\n\n";
        echo "Skills:\n";
        if (isset($this->skills)) {
            foreach ($this->skills as $key => $skill) {
                echo $key . " (" . $skill . ")\n";
            }
        }
        echo "\n\n";
    }

    private function addReward(Means $reward) {
        foreach ($this->means as $key => $mean) {
            if (get_class($reward) === get_class($mean)) {
                $this->means[$key]->available += $reward->available;
                return true;
            }
        }
        $this->means[] = $reward;
    }

    public function takeAction(Labor $labor) {
        echo "Human engaging in labor " . get_class($labor) . "\n";
        echo "Human name: " . $this->name . "\n";
        EconomicObserver::observAction($this->name, get_class($labor));

        if (isset($labor->requiredMeans)) {
            //echo "Cost of labor: \n";
            $requirementOfMeansCount = 0;
            foreach ($labor->requiredMeans as $requiredMean) {
                //echo "  * " . get_class($requiredMean) . ": " . $requiredMean->cost . " " . $requiredMean->unit . "\n";
                foreach ($this->means as $availableMean) {
                    if (get_class($requiredMean) == get_class($availableMean)) {
                        //echo get_class($requiredMean) . " available in human means \n";
                        //echo "cost: " . $requiredMean->cost . " available: " . $availableMean->available . "\n";
                        if ($availableMean->available >= $requiredMean->cost) {
                            //echo "Enough means available to perform action\n";
                            $requirementOfMeansCount++;
                            continue;
                        }
                    }
                }
            }

            if ($requirementOfMeansCount == count($labor->requiredMeans)) {
                //echo "  * All mean requirements passed\n";
            } else {
                echo "  * Not enough means to perform action\n";
            }
        }

        foreach ($labor->requiredMeans as $requiredMean) {
            foreach ($this->means as $availableMean) {
                if (get_class($requiredMean) == get_class($availableMean) && $requiredMean->getsUsedUpInProduction) {
                    $availableMean->available -= $requiredMean->cost;
                    continue;
                }
            }
        }

        if ($labor->reward !== null) {
            $this->addReward($labor->reward);
        }
    }
}

class Labor {
    public function __construct() {
        echo "Labor construct\n";
    }
    public $requiredMeans;
    public $reward;
}

class ChopDownTree extends Labor {
    public function __construct(&$land, $landObjectIndex) {
        parent::__construct();

        $this->requiredMeans[] = new Time(null, 2, 'hours');
        $this->requiredMeans[] = new Axe(null, 1, '', false);

        $this->reward = new Wood($land->objects[$landObjectIndex]->quantity, null, $land->objects[$landObjectIndex]->unit);

        unset($land->objects[$landObjectIndex]);
    }
}

class MakeFishingPole extends Labor {
    public function __construct() {
        parent::__construct();

        $this->requiredMeans[] = new Time(null, 3, 'hours');
        $this->requiredMeans[] = new Axe(null, 1, '', false);
        $this->requiredMeans[] = new Wood(null, 2, 'kg');

        $this->reward = new FishingPole(1, null, '');
    }
}

class GoFishing extends Labor {
    public function __construct($durationHours, $skills) {
        parent::__construct();

        $this->requiredMeans[] = new Time(null, $durationHours, 'hours');
        $this->requiredMeans[] = new FishingPole(null, 1, '', false);
        $this->requiredMeans[] = new FishingLine(null, 1, '', false);
        $this->requiredMeans[] = new Hook(null, 1, '', false);

        for ($a = 0, $fishCaught = 0; $a < $durationHours; $a++) {
            if (rand(0, 10) <= $skills) {
                $fishCaught++;
            }
        }

        if ($fishCaught) {
            $this->reward = new Fish($fishCaught, null, '');
        }
    }
}

class PickCoconuts extends Labor {
    public function __construct($durationHours, $skills) {
        parent::__construct();

        $this->requiredMeans[] = new Time(null, 1, 'hours');
        $this->requiredMeans[] = new Knife(null, 1, '', false);

        for ($a = 0, $coconutsPicked = 0; $a < $durationHours; $a++) {
            if (rand(0, 10) <= $skills) {
                $coconutsPicked++;
            }
        }

        if ($coconutsPicked) {
            $this->reward = new Coconut($coconutsPicked, null, '');
        }
    }
}

/*
class Trade extends Labor {
    public function __construct() {
        $this->requiredMeans[] = new Time(null, 1, 'hours');

    }
}
*/

class Market {
    private $traders;

    public function __construct() {

    }

    public function addTrader(Human $trader) {
        $this->traders[] = $trader;
    }

    public function showTraders() {
        echo "Traders in market:\n";
        foreach ($this->traders as $trader) {
            echo "<b>" . $trader->name . "</b>\n";
            foreach ($trader->means as $mean) {
                if ($mean::tradable) {
                    echo $mean->available . " " . get_class($mean) . "\n";
                }
            }
            echo "\n";
        }
    }
}

class Subject {
    public $name;

    public function __construct($name) {
        echo '<span class="observer">Subject initialized</span>';
        $this->name = $name;
    }
}

class ValueScale {
    public function __construct() {
        echo '<span class="observer">Economic observer initialized</span>';
    }

    public static function createScale() {
        $vs = new self;
    }
}

class EconomicObserver {
    public static $subjects = [];

    public static $valueScales = [];

    public function __construct() {
        echo '<span class="observer">Economic observer initialized</span>';
    }

    public static function addSubject(Subject $subject) {
        self::$subjects[] = $subject;
    }

    public static function observAction($name, $action) {
        echo '<span class="observer">Actor ' . $name . ' valued the action ' . $action . ' more than anything else at this time</span>';
    }

}

$land = new Land();

EconomicObserver::addSubject(new Subject('Charlie'));
EconomicObserver::addSubject(new Subject('Stephanie'));

$human1 = new Human('Charlie');

$human1->addMeans(new Time(24, null, 'hours'));
$human1->addMeans(new Axe(1, null, '', false));
$human1->addMeans(new FishingLine(1, null, '', false));
$human1->addMeans(new Hook(1, null, '', false));

$human1->showHuman();
$human1->takeAction(new ChopDownTree($land, $land->find('YewTree')));
$human1->showHuman();
$human1->takeAction(new MakeFishingPole());
$human1->takeAction(new MakeFishingPole());
$human1->takeAction(new GoFishing(3, $human1->skills['GoFishing']));
$human1->showHuman();

$human2 = new Human('Stephanie');
$human2->addMeans(new Time(24, null, 'hours'));
$human2->addMeans(new Knife(1, null, '', false));
$human2->takeAction(new PickCoconuts(10, $human2->skills['PickCoconuts']));
$human2->showHuman();

$market = new Market();
$market->addTrader($human1);
$market->addTrader($human2);
$market->showTraders();

