<?php

declare(strict_types=1);

namespace dmyers\orange;

class Controller
{
	protected $output = null;
	protected $input = null;
	protected $config = [];

	public function __construct(input $input, output $output, config $config)
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
