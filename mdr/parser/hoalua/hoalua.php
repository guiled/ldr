<?php

namespace mdr\parser\hoalua;

require '../../../vendor/Hoa/Core/Core.php';

from('Hoa')
	->import('File.Read')
	->import('Compiler.Llk.~')
	->import('Compiler.Visitor.Dump');

from('Hoathis')
	->import('Lua.Visitor.Interpreter');

/**
 *
 */
class parser
{

	/**
	 *
	 * @var \Hoa\Compiler\Llk
	 */
	protected $compiler;

	/**
	 *
	 * @var \Hoa\Lua\Visitor\Interpreter
	 */
	protected $visitor;

	/**
	 *
	 * @var \Hoathis\Lua\Visitor\Interpreter
	 */
	protected $visitor;

	/**
	 * Parse the content in Lua language
	 * @param	string	$content
	 * @return	\Hoa\Compiler\Llk\TreeNode
	 */
	public function parse($content)
	{
		if (false === isset($this->compiler)) {
			$this->compiler = \Hoa\Compiler\Llk::load(
					new \Hoa\File\Read('hoa://Library/Lua/Grammar.pp')
			);
		}
		return $this->compiler->parse($content);
	}

	/**
	 *
	 * @param	\Hoa\Compiler\Llk\TreeNode $ast	The result of a \Lua\Parser::parse()
	 * @param	array	$dictionnary
	 */
	public function execute($ast, $dictionnary)
	{
		if (false === isset($this->visitor)) {
			$visitor = new \Hoathis\Lua\Visitor\Interpreter();
		}

		return $visitor->visit($ast);
	}

}