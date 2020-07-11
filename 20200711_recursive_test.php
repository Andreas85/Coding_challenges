<?php 

echo "<pre>";

function recursiveTest($a) {
    echo "recursiveTest() $a\n";
    if ($a > 10) {
        return true;
    }

    recursiveTest(++$a);
}

recursiveTest(0);



$array = [0,1,2,3,4,5,6];

function recursiveTestArray($array) {
    if (count($array) == 0) {
        return true;
    }

    echo $array[count($array) - 1] . "\n";;
    
    array_pop($array);
    recursiveTestArray($array);
}

recursiveTestArray($array);



$menu = [
    ['mammal', null],
    ['dog', 0],
    ['cat', 0],
    ['golden', 1],
    ['maine', 2]
];

print_r($menu);

function lala($menu) {
    foreach ($menu as $item) {
        if ($item[1] === null) {
            print_r($item);
        }
        return;
    }
    


}

lala($menu);
?>
