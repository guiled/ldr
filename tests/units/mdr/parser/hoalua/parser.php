<?php


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
			->output(function() use ($parser, $code) {$parser->execute($code);})->isEqualTo('12')
		;
	}

}