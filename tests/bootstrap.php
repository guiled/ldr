<?php
require_once 'atoum.atoum.phar';

require_once '../mdr/autoloader.php';

$autoloader = new mdr\autoloader();
$autoloader->registerNamespace('mdr', realpath('../mdr'));
spl_autoload_register(array($autoloader, 'autoload'));