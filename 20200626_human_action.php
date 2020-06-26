<?php
echo "<pre>";

class Means {
    public $name;
    public $quantity;
    public $unit;
    public $getsUsedUpInProduction;

    public function __construct($name, $quantity, $unit, $getsUsedUpInProduction = null) {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->unit = $unit;
        $this->getsUsedUpInProduction = $getsUsedUpInProduction;
    }
}

class Human {
    public $means;

    public function __construct() {
    }

    public function addMeans(Means $means) {
        $this->means[] = $means;
    }

    public function showHuman() {
        echo "\n\n";
        echo "Show human\n";
        echo "Available means:\n";
        foreach ($this->means as $mean) {
            echo $mean->name . " ";
            echo $mean->quantity. " ";
            echo $mean->unit . "\n";
        }
    }

    public function takeAction(Action $action) {
        echo "\n\n";
        if ($action->attemptAction($this->means)) {
            $this->means[] = new Means('Table', 1, '');
        }
        echo "\n\n";
    }
}

class Action {
    public $name;
    public $requiredMeans;

    public function __construct($name) {
        $this->name = $name;
    }

    public function addRequiredMeans(Means $requiredMeans) {
        $this->requiredMeans[] = $requiredMeans;
    }

    public function attemptAction(&$availableMeans) {
        echo "Action attempted\n";

        foreach ($this->requiredMeans as $requiredMean) {
            foreach ($availableMeans as $availableMean) {
                if ($requiredMean->name == $availableMean->name && $requiredMean->quantity <= $availableMean->quantity) {
                    echo "Required " . $requiredMean->name  . " " . $requiredMean->quantity . " - Available " . $availableMean->name . " " . $availableMean->quantity . "\n";
                } elseif ($requiredMean->name == $availableMean->name && $requiredMean->quantity > $availableMean->quantity) {
                    return "false not enough " . $requiredMean->name;
                }
            }
        }

        foreach ($this->requiredMeans as $requiredMean) {
            foreach ($availableMeans as $availableMean) {
                if ($requiredMean->name == $availableMean->name && $requiredMean->getsUsedUpInProduction) {
                    $availableMean->quantity -= $requiredMean->quantity;
                }
            }
        }

        return true;
    }
}

$meansTime = new Means('Time', 10, 'hours');
$meansHammer = new Means('Hammer', 1, '');
$meansNail = new Means('Nail', 100, 'pcs');
$meansWoodenBoards = new Means('Wooden boards', 20, 'pcs');

$requiredMeansTime = new Means('Time', 5, 'hours', true);
$requiredMeansHammer = new Means('Hammer', 1, '', false);
$requiredMeansNail = new Means('Nail', 60, 'pcs', true);
$requiredMeansWoodenBoards = new Means('Wooden boards', 16, 'pcs', true);

$actionBuildTable = new Action('Build table');
$actionBuildTable->addRequiredMeans($requiredMeansTime);
$actionBuildTable->addRequiredMeans($requiredMeansHammer);
$actionBuildTable->addRequiredMeans($requiredMeansNail);
$actionBuildTable->addRequiredMeans($requiredMeansWoodenBoards);

$human1 = new Human();
$human1->addMeans($meansTime);
$human1->addMeans($meansHammer);
$human1->addMeans($meansNail);
$human1->addMeans($meansWoodenBoards);
$human1->showHuman();

$human1->takeAction($actionBuildTable);

$human1->showHuman();
