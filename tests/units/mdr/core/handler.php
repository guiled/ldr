<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tests\unit\mdr\core;

use atoum;
use \mdr\core;

/**
 * Test class for handler.
 *
 * @author Guile
 */
class handler extends atoum
{

	// put your code here

	public function testUseOfParser()
	{
		$this
			->if($parser = new \mock\mdr\parser\parser())
				->and($code = 'echo 1;')
				// Le mock de parser reçoit des arguments en référence et les traite par leur référence
				->and($this->calling($parser)->execute = function ($a, &$args) use (&$code) {
						extract($args, EXTR_REFS);
						eval($code);
					})
				->and($args = array())
				->and($handler = new core\handler('uselessparameternow', $args, $parser))
				->and($callHandler = function () use($handler, &$args) {
						$handler($args);
					})
			->assert('Execution du code par Handler')
				->when($callHandler)
					->mock($parser)->call('execute')->once()
					->output->isEqualTo('1')


			->if($code = 'echo $a;')
				->and($initVal = 42)
				->and($a = $initVal)
				->and($args = array('a' => &$a))
			->assert('Execution du code par Handler')
				->output($callHandler)->isEqualTo(strval($args['a']))

			->if($code = '$a++;echo $a;')
			->assert('Récupération des modifications sur les variables via le Handler')
				->output($callHandler)->isEqualTo(strval($initVal+1))
				->integer($a)->isEqualTo($initVal+1);
		;
	}

}
