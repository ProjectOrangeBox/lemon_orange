<?php

declare(strict_types=1);

namespace dmyers\orange;

use dmyers\orange\Input;
use dmyers\orange\Config;
use dmyers\orange\Output;

class Controller
{
	protected $output = null;
	protected $input = null;
	protected $config = [];

	public function __construct(Input &$input, Output &$output, Config &$config)
	{
		$this->input = $input;
		$this->output = $output;
		$this->config = $config;

		$this->construct();
	}

	protected function construct()
	{
		/* to be overridden by child class */
	}
} /* end class */
