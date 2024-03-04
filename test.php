<?php
echo ("Hello World");

$arr = array(1,"bobik",190,"\n");
foreach ($arr as $element){
    echo $element;
}
echo($arr[0]);

class Bobik{
    public function bark()
    {
        echo "BARK\n";
    }
}

$dog = new Bobik();

$dog -> bark();
$dog -> bark();
$dog -> bark();

?>