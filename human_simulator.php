<pre>
<?php
$database = "human_simulator";
include '../config/coding_challenges_database.php';

class Sun {
    public static $sunlightAtTime;

    public static function spawnSun() {
        self::$sunlightAtTime = [
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 1,
            6 => 3,
            7 => 5,
            8 => 7,
            9 => 9,
            10 => 10,
            11 => 10,
            12 => 10,
            13 => 10,
            14 => 10,
            15 => 10,
            16 => 10,
            17 => 9,
            18 => 8,
            19 => 6,
            20 => 3,
            21 => 1,
            22 => 1,
            23 => 0
        ];
    }

    public static function getSunlightAt($hour) {
        return self::$sunlightAtTime[$hour];
    }
    
}

class Human {
    public $motivations;
    protected $databaseConnection;

    public function __construct(mysqli $databaseConnection, $humanId) {
        echo "Spawning human\n";
        
        $this->databaseConnection = $databaseConnection;
        $sql = "SELECT * FROM human WHERE human_id = " . $humanId . " ORDER BY id DESC LIMIT 1";
        $result = $this->databaseConnection->query($sql);
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }

        $this->motivations['energy'] = Sun::getSunlightAt(date('H'));
    }

    public function getHumanEmotionalState() {
        if ($this->motivations['energy'] >= 8) {
            echo "Human is wide awake\n";
        } else if ($this->motivations['energy'] >= 5) {
            echo "Human is awake\n";
        } else if ($this->motivations['energy'] >= 3) {
            echo "Human is tired\n";
        } else if ($this->motivations['energy'] >= 0) {
            echo "Human is very sleepy\n";
        }
    }
}

Sun::spawnSun();

$human1 = new Human($conn, 1);
$human1->getHumanEmotionalState();



