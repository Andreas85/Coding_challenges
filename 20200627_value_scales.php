<?php
echo "<pre>";

class Human {
    public $scaleOfValues;

    public function addValue(Fruit $value) {
        $this->scaleOfValues[] = $value;
    }

    public function takeFruitFromBasket(FruitBasket &$fruitBasket) {
        foreach ($this->scaleOfValues as $value) {
            echo "Looking for " . get_class($value) . " in basket\n";
            foreach ($fruitBasket->fruits as $key => &$fruitInBasket) {
                if (get_class($value) == get_class($fruitInBasket)) {
                    echo "Found " . get_class($value) . " in basket and took one\n";
                    unset($fruitBasket->fruits[$key]);
                    break;
                }
                if ($key == count($fruitBasket->fruits) - 1) {
                    echo "Couldn't find " . get_class($value) . " in basket\n";
                }
            }
            echo "\n";
        }
    }

    public function printValues() {
        echo "Humans value scale:\n";
        foreach ($this->scaleOfValues as $value) {
            echo get_class($value) . "\n";
        }
    }
}


class Fruit {
}

class Apple extends Fruit {
}

class Banana extends Fruit {
}

class Orange extends Fruit {
}

class FruitBasket {
    public $fruits;

    public function __construct() {
        echo "Spawning fruit basket\n";
    }

    public function addFruit(Fruit $fruit) {
        $this->fruits[] = $fruit;
    }

    public function printBasket() {
        echo "Fruit basket contains:\n";
        foreach ($this->fruits as $fruit) {
            echo get_class($fruit) . "\n";
        }
    }
}

$fruitBasket = new FruitBasket();

$fruitBasket->addFruit(new Apple());
$fruitBasket->addFruit(new Apple());
$fruitBasket->addFruit(new Banana());
$fruitBasket->addFruit(new Banana());
$fruitBasket->addFruit(new Banana());
$fruitBasket->addFruit(new Orange());

echo "\n";
$fruitBasket->printBasket();

echo "\n";
$human1 = new Human();
$human1->addValue(new Orange());
$human1->addValue(new Orange());
$human1->addValue(new Orange());
$human1->addValue(new Apple());
$human1->addValue(new Banana());

$human1->printValues();
echo "\n";

$human1->takeFruitFromBasket($fruitBasket);
