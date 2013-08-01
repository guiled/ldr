<?php

namespace mdr\parser;


interface parser
{
	public function parse($content);

	public function execute($ast, &$dictionnary = array());
}