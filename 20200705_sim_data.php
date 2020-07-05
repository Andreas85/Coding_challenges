<?php
$database = "20200705_simulation";
include '../config/coding_challenges_database.php';

$sql = "select * from simulation_data";
$result = $conn->query($sql);


if (isset($_GET['fetch'])) {
    while ($row = $result->fetch_assoc()) {
        echo $row['data'];
    }

    exit;
}

class Land {
    public static $grid;

    public static function initialize() {
        //echo "Initializing Land object\n";
        $land = new self;
        //$land->$grid['width'] = 80;
        //$land->$grid['height'] = 60;
        //print_r($land->$grid);
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
    
        self::$grid[18][20] = 'T';
        self::$grid[20][40] = 'T';
        self::$grid[15][60] = 'T';
        self::$grid[28][54] = 'T';
        self::$grid[36][20] = 'T';
        self::$grid[37][28] = 'T';
        self::$grid[44][32] = 'T';

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

Land::initialize();

$grid = Land::getGrid();

echo json_encode([
    'grid' => $grid
]);
