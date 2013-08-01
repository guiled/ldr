<?php

namespace mdr\core;

class handler
{

	protected $compiledCode;
	protected $codeHash;
	protected $args;

	/**
	 *
	 * @var \mdr\parser\parser $parser
	 */
	protected $parser;

	public function __construct($code, $argsList, \mdr\parser\parser $parser)
	{
		$this->codeHash = md5($code);
		$this->args = $argsList;
		$this->parser = $parser;
		$this->compiledCode = $this->parser->parse($code);
	}

	public function __invoke(&$argsValues)
	{
		return $this->parser->execute($this->compiledCode, $argsValues);
	}

}