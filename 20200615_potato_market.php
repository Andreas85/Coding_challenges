<?php
$database = "20200615_db";
include '../config/coding_challenges_database.php';

abstract class Person {
    protected $inventory;
    protected $databaseConnection;
    protected $personId;

    public function __construct(mysqli $databaseConnection, int $personId) {
        $this->databaseConnection = $databaseConnection;
        $this->personId = $personId;
    }

    public function getAllFromDatabase() {
        $sql = "SELECT * FROM inventory WHERE person_id = " . $this->personId;
        $result = $this->databaseConnection->query($sql);

        while ($row = $result->fetch_assoc()) {
            $this->inventory[$row['name']]['quantity'] = $row['quantity'];
        }
    }

    public function storeAllInDatabase() {
        $updateString = '';
        foreach ($this->inventory as $key => $item) {
            $sql = "UPDATE inventory SET quantity = " . $item['quantity'] . " WHERE person_id = " . $this->personId . " AND name = '" . $key . "'";
            $result = $this->databaseConnection->query($sql);
        }
    }

    public function printInventory() {
        print_r($this->inventory);
    }
}

class Producer extends Person {
    public function producePotatoes($quantity) {
        echo "Producing potatoes\n";
        $this->inventory['potatoes']['quantity'] += $quantity;

    }

    public function sellPotatoes($quantity) {
        echo "Selling potatoes\n";
        $this->inventory['potatoes']['quantity'] -= $quantity;
        $this->storeAllInDatabase();
    }
}


class Consumer extends Person {
    public function buyPotatoes($quantity, Producer $producer) {
        echo "Buying potatoes\n";

        $producer->sellPotatoes($quantity);
        $this->inventory['potatoes']['quantity'] += $quantity;
    }
}

echo "<pre>";

$farmer1 = new Producer($conn, 1);
$farmer1->getAllFromDatabase();
$farmer1->producePotatoes(100);
$farmer1->printInventory();
$farmer1->storeAllInDatabase();

$vegetableBuyer1 = new Consumer($conn, 2);
$vegetableBuyer1->getAllFromDatabase();
$vegetableBuyer1->BuyPotatoes(64, $farmer1);
$vegetableBuyer1->printInventory();
$vegetableBuyer1->storeAllInDatabase();


