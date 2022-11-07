<?php

declare(strict_types=1);

namespace dmyers\orange;

use dmyers\orange\Input;
use dmyers\orange\Config;
use dmyers\orange\Output;
use dmyers\orange\interfaces\ControllerInterface;

class Controller implements ControllerInterface
{
	protected $output = null;
	protected $input = null;
	protected $config = null;

	public function __construct(Input &$input, Output &$output, Config &$config)
	{
		$this->input = $input;
		$this->output = $output;
		$this->config = $config;

		$this->_construct();
	}

	protected function _construct()
	{
		/* to be overridden by child class */
	}
} /* end class */
