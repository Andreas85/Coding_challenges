<?php
$database = "20200709_ocreature";
include '../config/coding_challenges_database.php';

$sql = "select * from ocreature order by datetime desc limit 1";
$result = $conn->query($sql);

$oCreatureLastPos = $result->fetch_assoc();

echo "<pre>";


class Emotion {
    public $intensity;
}

class FearOfEdgeOfTheWorld extends Emotion{
    public function __construct() {
        $this->intensity = 2;
    }

    public function motivate() {
        
    }
}

class JoyOfExploring extends Emotion {
    public function __construct() {
        $this->intensity = 10;
    }

    public function motivate() {
        
    }
}

class oCreature {
    public $posX;
    public $posY;
    public $directionX;
    public $directionY;

    public $emotions;

    public function __construct($posX, $posY) {
        $this->posX = $posX;
        $this->posY = $posY;
        $this->directionX = 1;
        $this->directionY = 0;

        $this->emotions[] = new FearOfEdgeOfTheWorld();
        $this->emotions[] = new JoyOfExploring();
    }

    public function action() {
        $this->sortEmotionsByIntensity();
        
        if ($this->emotions[0]->motivate() == 'movement') {

        }
        
    }

    private function sortEmotionsByIntensity() {
        usort($this->emotions, function ($object1, $object2) {
            return $object1->intensity < $object2->intensity;
        });
    }
    public function move() {
        $this->posX++;
    }
}

if (!$result->num_rows) {
    $oCreature = new oCreature(9, 9);
} else {
    $oCreature = new oCreature($oCreatureLastPos['pos_x'], $oCreatureLastPos['pos_y']);
}


$oCreature->action();


$sql = "insert into ocreature (pos_x, pos_y) values ('" . $oCreature->posX. "', '" . $oCreature->posY . "')";
$result = $conn->query($sql);



$xWorld = [
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
    ['X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X', 'X'], 
];


for ($y = 0; $y < count($xWorld[0]); $y++) {
    for ($x = 0; $x < count($xWorld); $x++) {
        if ($oCreature->posX == $x && $oCreature->posY == $y) {
            echo "O ";
        } else {
            echo $xWorld[$y][$x] . " ";
        }
    }
    echo "\n";
}
