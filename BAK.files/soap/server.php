<?php

require_once('IXR_Library.inc.php');

/* Functions defining the behaviour of the server */

function getTime($args) {
    return date('H:i:s');
}

function add($args) {
    return $args[0] + $args[1];
}

function addArray($array) {
    $total = 0;
    foreach ($array as $number) {
        $total += $number;
    }
    return implode(' + ', $array).' = '.$total;
}

/* Create the server and map the XML-RPC method names to the relevant functions */

$server = new IXR_Server(array(
    'test.getTime' => 'getTime',
    'test.add' => 'add',
    'test.addArray' => 'addArray'
));

?>