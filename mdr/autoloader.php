<?php

namespace mdr;

/**
 * Autoloader
 *
 * @author Guile
 */
class autoloader
{

	protected $namespace = array();

	public function registerNamespace($namespace, $directory)
	{
		$namespace = \trim($namespace, '\\');
		if (false === \is_dir($directory)) {
			require_once('exception.php');
			throw new exception('Directory not found : ' . $directory . \PHP_EOL . 'Try with an absolute path.');
		}
		$this->namespace[$namespace] = $directory;
	}

	public function getNamespacedPath($namespace, $className)
	{
		foreach ($this->namespace as $ns => $ns_path) {
			if (0 === \strpos($namespace, $ns)) {
				$path = \str_replace(array('\\', $ns), array(\DIRECTORY_SEPARATOR, ''), $namespace) . \DIRECTORY_SEPARATOR;
				$fileName = $ns_path . \DIRECTORY_SEPARATOR . $path . \str_replace('_', \DIRECTORY_SEPARATOR, $className) . '.php';
				if (true === \file_exists($fileName)) {
					return $fileName;
				}
			}
		}
	}

	public function autoload($className)
	{
		$className = \ltrim($className, '\\');
		$fileName = '';
		$namespace = '';
		$path = '';

		$lastNsPos = \strripos($className, '\\');
		if ($lastNsPos) {
			$namespace = \substr($className, 0, $lastNsPos);
			$className = \substr($className, $lastNsPos + 1);
			$path = \str_replace('\\', \DIRECTORY_SEPARATOR, $namespace) . \DIRECTORY_SEPARATOR;
		}

		$fileName = $path . \str_replace('_', \DIRECTORY_SEPARATOR, $className) . '.php';
		if (false === \file_exists($fileName)) {
			$fileName = $this->getNamespacedPath($namespace, $className);
		}
		if (false === empty($fileName)) {
			require $fileName;
//		} else {
//			echo 'Class Name : ', $namespace, ' ', $className, PHP_EOL, 'Path : ', $path, PHP_EOL, 'Filename : ', $fileName, PHP_EOL;
		}
	}

}
