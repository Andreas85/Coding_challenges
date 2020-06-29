<?php
echo "<pre>";

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
        $this->fish[] = new Fish();
        $this->fish[] = new Fish();
        $this->fish[] = new Fish();
        $this->fish[] = new Fish();
        $this->fish[] = new Fish();
        $this->fish[] = new Fish();
        $this->fish[] = new Fish();
    }
}

class Fish {
    public function __construct() {
        echo "Spawning fish\n";
    }
}

class CoconutTree {
    public $coconuts;

    public function __construct() {
        echo "Spawning coconut tree\n";
        $this->coconuts[] = new Coconut();
        $this->coconuts[] = new Coconut();
        $this->coconuts[] = new Coconut();
        $this->coconuts[] = new Coconut();
        $this->coconuts[] = new Coconut();
    }
}

class Coconut {
    public function __construct() {
        echo "Spawning coconut\n";
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
}

class Axe extends Means {

}

class FishingLine extends Means {

}

class Hook extends Means {

}

class Wood extends Means {
    public $unit;
    public $quantity;

/*
    public function __construct($quantity, $unit) {
        echo "Spawning wood\n";
        $this->unit = $unit;
        $this->quantity = $quantity;
    }
*/
}

class Human {
    public $means;

    public function __construct() {
        $this->means[] = new Time(24, null, 'hours'); 
        $this->means[] = new Axe(1, null, '', false);
        $this->means[] = new FishingLine(1, null, '', false);
        $this->means[] = new Hook(1, null, '', false);
    }

    public function addMeans(Means $means) {
        $this->means[] = $means;
    }

    public function showHuman() {
        echo "\n\n";
        echo "Human:\n";
        echo "Available means:\n";
        if (isset($this->means)) {
            foreach ($this->means as $mean) {
                echo "  " . $mean->available . " ";
                echo $mean->unit . " ";
                echo get_class($mean) . "\n";
            }
        }
        echo "\n\n";
    }

    public function takeAction(Labor $labor) {
        echo "Human engaging in labor " . get_class($labor) . "\n";

        if (isset($labor->requiredMeans)) {
            echo "Cost of labor: \n";
            $requirementOfMeansCount = 0;
            foreach ($labor->requiredMeans as $requiredMean) {
                echo "  * " . get_class($requiredMean) . ": " . $requiredMean->cost . " " . $requiredMean->unit . "\n";

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
                echo "  * All mean requirements passed\n";
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

        $this->means[] = $labor->reward;
    }
}

class Labor {
    public $requiredMeans;
    public $reward;

    public function __construct($name) {
    }
}

class ChopDownTree extends Labor {
    public function __construct(&$land, $landObjectIndex) {
        $this->requiredMeans[] = new Time(null, 5, 'hours');
        $this->requiredMeans[] = new Axe(null, 1, '', false);

        $this->reward = new Wood($land->objects[$landObjectIndex]->quantity, null, $land->objects[$landObjectIndex]->unit);

        unset($land->objects[$landObjectIndex]);
    }
}

$land = new Land();

$human1 = new Human();
$human1->showHuman();
$human1->takeAction(new ChopDownTree($land, $land->find('YewTree')));
$human1->showHuman();
