<?php

namespace mdr\parser\hoalua;

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

	protected static function loadHoaLua()
	{
		require __DIR__ . '/../../../vendor/autoload.php';

		from('Hoa')
			->import('File.Read')
			->import('Compiler.Llk.~')
			->import('Compiler.Visitor.Dump');

		from('Hoathis')
			->import('Lua.Visitor.Interpreter');
	}

	/**
	 * Parse the content in Lua language
	 * @param	string	$content
	 * @return	\Hoa\Compiler\Llk\TreeNode
	 */
	public function parse($content)
	{
		if (false === isset($this->compiler)) {
			self::loadHoaLua();
			$this->compiler = \Hoa\Compiler\Llk::load(
					new \Hoa\File\Read('hoa://Library/Lua/Grammar.pp')
			);
		}
		return $this->compiler->parse($content);
	}

	/**
	 * Execute a previously parsed content with a dictionnary of input
	 * @param	\Hoa\Compiler\Llk\TreeNode $ast	The result of a \Lua\Parser::parse()
	 * @param	array	$dictionnary
	 */
	public function execute($ast, &$dictionnary = array())
	{
		$this->visitor = new \Hoathis\Lua\Visitor\Interpreter();
		$environment = $this->visitor->getRoot();
		$environment['print'] = new \Hoathis\Lua\Model\Closure('print', $environment, array('text'), function () {
				$args = func_get_args();
				foreach ($args as $arg) {
					echo $arg;
				}
			});

		// Assigning values from dictionnary to Lua context
		foreach ($dictionnary as $var_name => $var_value) {
			$environment[$var_name] = new \Hoathis\Lua\Model\Variable($var_name, $environment);
			$environment[$var_name]->setValue($var_value);
		}

		return $this->visitor->visit($ast);
	}

}