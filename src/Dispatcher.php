<?php

declare(strict_types=1);

namespace dmyers\orange;

use dmyers\orange\Input;
use dmyers\orange\Config;
use dmyers\orange\Output;
use dmyers\orange\exceptions\MethodNotFound;
use dmyers\orange\exceptions\ControllerClassNotFound;

class Dispatcher
{
	protected $input = null;
	protected $output = null;

	public function __construct(Input &$input, Output &$output, Config &$config)
	{
		$this->input = $input;
		$this->output = $output;
		$this->config = $config;
	}

	public function call(array $route): Output
	{
		$controllerClass = $route['controller'];

		if (class_exists($controllerClass)) {
			$method = $route['method'];

			if (method_exists($controllerClass, $method)) {
				/* we found something */
				$matches = array_map(function ($value) {
					return urldecode($value);
				}, $route['argv']);

				$output = (new $controllerClass($this->input, $this->output, $this->config))->$method(...$matches);

				if (is_string($output)) {
					$this->output->appendOutput($output);
				}
			} else {
				throw new MethodNotFound($method);
			}
		} else {
			throw new ControllerClassNotFound($controllerClass);
		}

		return $this->output;
	}
} /* end class */
