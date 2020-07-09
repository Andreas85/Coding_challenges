<?php
$database = "20200705_simulation";
include '../config/coding_challenges_database.php';

$sql = "select * from simulation_data order by datetime desc";
$result = $conn->query($sql);

$commands = [];

$_POST['command'] = 'giveIdeaWalkToTreeCreature0';

if (isset($_POST['command']) && $_POST['command'] === 'giveIdeaWalkToTreeCreature0') {
    //echo json_encode('giveIdeaWalkToTreeCreature0');
    $commands[] = 'giveIdeaWalkToTreeCreature0';
}

if (isset($_GET['fetch'])) {
    while ($row = $result->fetch_assoc()) {
        echo $row['data'];
    }

    exit;
}

class Land {
    public static $grid;

    public static function initialize() {
        $land = new self;
        $width = 80;
        $height = 60;

        $grid = [];

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                self::$grid[$y][$x] = 'W'; }
        }

        $dryLand = [
            6 => [40, 46],
            7 => [40, 48],
            8 => [40, 50],
            9 => [40, 54],
            10 => [37, 58],
            11 => [34, 60],
            12 => [31, 63],
            13 => [29, 66],
            14 => [26, 69],
            15 => [25, 70],
            16 => [21, 68],
            17 => [17, 67],
            18 => [15, 69],
            19 => [13, 68],
            20 => [15, 68],
            21 => [18, 64],
            22 => [20, 60],
            23 => [23, 63],
            24 => [25, 66],
            25 => [28, 65],
            26 => [25, 69],
            27 => [20, 70],
            28 => [16, 71],
            29 => [11, 69],
            30 => [9, 67],
            31 => [5, 67],
            32 => [5, 64],
            33 => [5, 69],
            34 => [7, 69],
            35 => [9, 71],
            36 => [10, 72],
            37 => [10, 70],
            38 => [15, 72],
            39 => [13, 76],
            40 => [19, 76],
            41 => [20, 75],
            42 => [23, 68],
            43 => [16, 69],
            44 => [17, 67],
            45 => [16, 66],
            46 => [17, 66],
            47 => [16, 64],
            48 => [17, 62],
            49 => [17, 53],
            50 => [35, 45],
            51 => [37, 44],
            52 => [39, 43],
            53 => [40, 42],
            54 => [41, 42]
        ];

        foreach ($dryLand as $y => $val) {
            for ($x = $val[0]; $x < $val[1]; $x++) {
                self::$grid[$y][$x] = 'G';
            }
        }

        $lake = [
            34 => [46, 50],
            35 => [44, 52],
            36 => [42, 55],
            37 => [44, 55],
            38 => [46, 52],
        ];

        foreach ($lake as $y => $val) {
            for ($x = $val[0]; $x < $val[1]; $x++) {
                self::$grid[$y][$x] = 'L';
            }
        }

    }

    public static function getGrid() {
        return self::$grid;
    }
}

class Creature {
    public $positionX;
    public $positionY;
    public $mind;

    public function __construct($positionX, $positionY, $thought = null) {
        $this->positionX = $positionX;
        $this->positionY = $positionY;
        if (is_object($thought)) {
            $this->mind[] = $thought;
        }
    }

    public function getPosition() {
        return [
            'x' => $this->positionX,
            'y' => $this->positionY,
        ];
    }

    public function getIdea($idea) {
        $this->mind[] = $idea;
    }

    public function moveTo($x, $y) {
        echo "monving";
echo $x. " ".$y;
    }

    public function stepRight() {
        $this->positionX++;
    }
}





class Thought {
    public $components;

    public function __construct($components) {
        $this->components = $components; 
    }

}

class Objects {

    public function __construct() {

    }

}

class Tree extends Objects {
    public $positionX;
    public $positionY;

    public function __construct($positionX, $positionY) {
        $this->positionX = $positionX;
        $this->positionY = $positionY;
    }

    public function getPosition() {
        return [
            'x' => $this->positionX,
            'y' => $this->positionY,
        ];
    }
}

Land::initialize();

$grid = Land::getGrid();

$creatures = [];
$trees = [];

if (!$result->num_rows) {
    $creatures = [
        new Creature(30,40),
        new Creature(50,48)
    ];

    $trees = [
        new Tree(21,19),
        new Tree(20,35),
        new Tree(50,20),
        new Tree(28,42),
        new Tree(36,20),
        new Tree(37,28),
        new Tree(44,32),
    ];
} else {
    $row = $result->fetch_assoc();
    $data = json_decode($row['data']);

    foreach ($data->objects->trees as $tree) {
        $trees[] = new Tree($tree->x, $tree->y);
    }

    foreach ($data->creatures as $creature) {
        $creatures[] = new Creature($creature->x, $creature->y);
    }
}

//$creatures[0]->stepRight();


if (in_array('giveIdeaWalkToTreeCreature0', $commands)) {
    echo json_encode('yes');
    $idea = new Thought(['walk to', 'tree', 21, 19]);
    $creatures[0]->getIdea($idea);

}

echo "<pre>";
print_r($creatures);

foreach ($creatures as $creature) {
    if (in_array('walk to', $creature->mind[0]->components) && in_array('tree', $creature->mind[0]->components)) {
        $creature->moveTo($creature->mind[0]->components[2], $creature->mind[0]->components[3]);
    }
}


echo "\n\nexit";
exit;

// ---------
// Output

$outputCreatures = [];
foreach ($creatures as $creature) {
    $outputCreatures[] = $creature->getPosition();
}

$outputTrees = [];
foreach ($trees as $tree) {
    $outputTrees[] = $tree->getPosition();
}

$output = [
    'creatures' => $outputCreatures,
    'objects' => [
        'trees' => $outputTrees
    ]
];

$sql = "insert into simulation_data (data) values ('" . json_encode($output) . "')";
$result = $conn->query($sql);

$output['grid'] = $grid;
echo json_encode($output);
