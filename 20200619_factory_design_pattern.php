<?php
echo "<pre>";

interface CarFactoryInterface {
    public static function create($brand, $model): Car;
}

class CarFactory implements CarFactoryInterface {
    
    public static function create($brand, $model): Car {
        $car = new Car($brand, $model);
        return $car;
    }
}

interface CarInterface {
    public function print();
}

class Car implements CarInterface {
    public $brand;
    public $model;

    public function __construct($brand, $model) {
        echo "Car created\n";
        $this->brand = $brand;
        $this->model = $model;
    }

    public function print() {
        echo $this->brand . " " . $this->model . "\n";
    }
}

$volvoV70 = CarFactory::create('Volvo', 'V70');
$ferrariF50 = CarFactory::create('Ferrari', 'F50');

$volvoV70->print();
$ferrariF50->print();
