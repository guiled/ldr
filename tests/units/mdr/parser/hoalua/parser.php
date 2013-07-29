<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace tests\unit\mdr\parser\hoalua;

use atoum;
use \mdr\parser\hoalua as hoaluans;

/**
 * Test class for parser.
 *
 * @author Guile
 */
class parser extends atoum
{

	public function testParse()
	{
		$this
			->if($parser = new hoaluans\parser())
			->then
			->assert
			->object($code = $parser->parse('print(12)'))->isInstanceOf('\Hoa\Compiler\Llk\TreeNode')
			->output($parser->execute($code))->isEqualTo('12')
		;
	}

}