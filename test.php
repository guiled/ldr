<?php

function test(&$args) {
	$args['a']->a++;
	$args['b']++;
}

class A {
	public $a = 0;
}
$a = new A();
$b = 0;
$args = array('a' => $a, 'b' => $b);
test($args);
var_dump($a, $b, $args);