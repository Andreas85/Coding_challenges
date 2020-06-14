<?php

class Deck {
    private $deck;

    public function __construct() {
        $this->deck = [
            ['hearts', 1],
            ['hearts', 2],
            ['hearts', 3],
            ['hearts', 4],
            ['hearts', 5],
            ['hearts', 6],
            ['hearts', 7],
            ['hearts', 8],
            ['hearts', 9],
            ['hearts', 10],
            ['hearts', 11],
            ['hearts', 12],
            ['hearts', 13],
            ['spades', 1],
            ['spades', 2],
            ['spades', 3],
            ['spades', 4],
            ['spades', 5],
            ['spades', 6],
            ['spades', 7],
            ['spades', 8],
            ['spades', 9],
            ['spades', 10],
            ['spades', 11],
            ['spades', 12],
            ['spades', 13],
            ['diamonds', 1],
            ['diamonds', 2],
            ['diamonds', 3],
            ['diamonds', 4],
            ['diamonds', 5],
            ['diamonds', 6],
            ['diamonds', 7],
            ['diamonds', 8],
            ['diamonds', 9],
            ['diamonds', 10],
            ['diamonds', 11],
            ['diamonds', 12],
            ['diamonds', 13],
            ['clubs', 1],
            ['clubs', 2],
            ['clubs', 3],
            ['clubs', 4],
            ['clubs', 5],
            ['clubs', 6],
            ['clubs', 7],
            ['clubs', 8],
            ['clubs', 9],
            ['clubs', 10],
            ['clubs', 11],
            ['clubs', 12],
            ['clubs', 13]
        ];
    }

    public function printDeck() {
        echo "Deck\n";
        foreach ($this->deck as $card) {
            echo $card[1] . ' of ' . $card[0] . "\n";
        }
    }

    public function shuffleDeck() {
        shuffle($this->deck);
    }

    public function giveACard(int $numberOfCards = 1) {
        for ($a = 0; $a < $numberOfCards; $a++) {
            if (isset($this->deck[0])) {
                yield array_shift($this->deck);
            } else {
                break;
            }
        }
    }
}

class Hand {
    private $hand;
    private $name;

    public function __construct($name, $cards = null) {
        $this->hand = [];
        $this->name = $name;

        if (isset($cards) && !empty($cards)) {
            $this->drawCards($cards);
        }
    }

    public function printHand() {
        echo $this->name . "\n";
        foreach ($this->hand as $card) {
            echo $card[1] . ' of ' . $card[0] . "\n";
        }
    }

    public function sortHand() {
        array_multisort(array_column($this->hand, 0), SORT_ASC, array_column($this->hand, 1), SORT_ASC, $this->hand);
    }

    public function drawCards($cards) {
        foreach ($cards as $card) {
            $this->hand[] = $card;
        }
    }
}

echo "<pre>";

$deck = new Deck();
echo "* Deck shuffled\n\n";
$deck->shuffleDeck();

echo "* Player1 drawing 7 cards\n\n";
$player1 = new Hand('Player1', $deck->giveACard(7));
$player1->sortHand();
$player1->printHand();

echo "\n\n";

echo "* Player2 drawing 7 cards\n\n";
$player2 = new Hand('Player2', $deck->giveACard(7));
$player2->sortHand();
$player2->printHand();

echo "\n\n";

echo "* Remaining cards in deck\n\n";
$deck->printDeck();


?>
<pre style="background:gray">
<h1>Source code:</h1>
<code>
class Deck {
    private $deck;

    public function __construct() {
        $this->deck = [
            ['hearts', 1],
            ['hearts', 2],
            ['hearts', 3],
            ['hearts', 4],
            ['hearts', 5],
            ['hearts', 6],
            ['hearts', 7],
            ['hearts', 8],
            ['hearts', 9],
            ['hearts', 10],
            ['hearts', 11],
            ['hearts', 12],
            ['hearts', 13],
            ['spades', 1],
            ['spades', 2],
            ['spades', 3],
            ['spades', 4],
            ['spades', 5],
            ['spades', 6],
            ['spades', 7],
            ['spades', 8],
            ['spades', 9],
            ['spades', 10],
            ['spades', 11],
            ['spades', 12],
            ['spades', 13],
            ['diamonds', 1],
            ['diamonds', 2],
            ['diamonds', 3],
            ['diamonds', 4],
            ['diamonds', 5],
            ['diamonds', 6],
            ['diamonds', 7],
            ['diamonds', 8],
            ['diamonds', 9],
            ['diamonds', 10],
            ['diamonds', 11],
            ['diamonds', 12],
            ['diamonds', 13],
            ['clubs', 1],
            ['clubs', 2],
            ['clubs', 3],
            ['clubs', 4],
            ['clubs', 5],
            ['clubs', 6],
            ['clubs', 7],
            ['clubs', 8],
            ['clubs', 9],
            ['clubs', 10],
            ['clubs', 11],
            ['clubs', 12],
            ['clubs', 13]
        ];
    }

    public function printDeck() {
        echo "Deck\n";
        foreach ($this->deck as $card) {
            echo $card[1] . ' of ' . $card[0] . "\n";
        }
    }

    public function shuffleDeck() {
        shuffle($this->deck);
    }

    public function giveACard(int $numberOfCards = 1) {
        for ($a = 0; $a < $numberOfCards; $a++) {
            if (isset($this->deck[0])) {
                yield array_shift($this->deck);
            } else {
                break;
            }
        }
    }
}

class Hand {
    private $hand;
    private $name;

    public function __construct($name, $cards = null) {
        $this->hand = [];
        $this->name = $name;

        if (isset($cards) && !empty($cards)) {
            $this->drawCards($cards);
        }
    }

    public function printHand() {
        echo $this->name . "\n";
        foreach ($this->hand as $card) {
            echo $card[1] . ' of ' . $card[0] . "\n";
        }
    }

    public function sortHand() {
        array_multisort(array_column($this->hand, 0), SORT_ASC, array_column($this->hand, 1), SORT_ASC, $this->hand);
    }

    public function drawCards($cards) {
        foreach ($cards as $card) {
            $this->hand[] = $card;
        }
    }
}

$deck = new Deck();
echo "* Deck shuffled\n\n";
$deck->shuffleDeck();

echo "* Player1 drawing 7 cards\n\n";
$player1 = new Hand('Player1', $deck->giveACard(7));
$player1->sortHand();
$player1->printHand();

echo "\n\n";

echo "* Player2 drawing 7 cards\n\n";
$player2 = new Hand('Player2', $deck->giveACard(7));
$player2->sortHand();
$player2->printHand();

echo "\n\n";

echo "* Remaining cards in deck\n\n";
$deck->printDeck();
</code>
</pre>
