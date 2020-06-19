<?php

interface OutputInterface {
    public function load($data);
}

class serializedArrayOutput implements OutputInterface {
    function load($data) {
        return serialize($data);
    }
}

class jsonStringOutput implements OutputInterface {
    function load($data) {
        return json_encode($data);
    }
}

class arrayOutput implements OutputInterface {
    function load($data) {
        return $data;
    }
}

class Client {
    private $output;

    public function setOutput(OutputInterface $outputType) {
        $this->output = $outputType;
    }

    public function loadOutput($inputData) {
        return $this->output->load($inputData);
    }

}

$client = new Client();

$inputData = [
    'id' => 123,
    'name' => 'Charlie',
    'age' => 45,
    'gender' => 'male'
];

$client->setOutput(new serializedArrayOutput());
$data = $client->loadOutput($inputData);

print_r($data);
echo "<br>";
echo "<br>";

$client->setOutput(new jsonStringOutput());
$data = $client->loadOutput($inputData);

print_r($data);
