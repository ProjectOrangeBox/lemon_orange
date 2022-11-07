<?php

declare(strict_types=1);

namespace dmyers\orange;

use Exception;
use dmyers\orange\interfaces\InputInterface;
use dmyers\orange\exceptions\InvalidConfigurationValue;

class Input implements InputInterface
{
	protected $input = [];
	protected $requestType = '';
	protected $requestMethod = '';
	protected $case = CASE_LOWER; /* CASE_LOWER, CASE_UPPER, NULL */

	public function __construct(array $config)
	{
		$case = $config['case'] ?? $this->case;

		if ($case != CASE_LOWER || $case != CASE_UPPER) {
			throw new InvalidConfigurationValue($case);
		}

		$this->input['raw'] = $config['raw'];

		foreach (['post', 'get', 'request', 'server', 'env', 'cookie'] as $key) {
			if ($case !== null) {
				$this->input[$key] = array_change_key_case($config[$key], $case);
			} else {
				$this->input[$key] = $config[$key];
			}
		}

		/* setup the request type based on a few things */
		$isAjax = (!empty($this->input['server']['http_x_requested_with']) && strtolower($this->input['server']['http_x_requested_with']) == 'xmlhttprequest');
		$isJson = (!empty($this->input['server']['http_accept']) && strpos(strtolower($this->input['server']['http_accept']), 'application/json') !== false);
		$isCli = (strtoupper(PHP_SAPI) === 'CLI' || defined('STDIN'));

		if ($isAjax || $isJson) {
			$this->requestType = 'AJAX';
		} elseif ($isCli) {
			$this->requestType = 'CLI';
		} else {
			$this->requestType = 'HTML';
		}

		/* get the http request method or default to cli */
		$this->requestMethod = $this->input['server']['request_method'] ?? 'CLI';
	}

	public function requestUri(): string
	{
		return $this->input['server']['request_uri'];
	}

	public function requestMethod(): string
	{
		return strtoupper($this->requestMethod);
	}

	public function requestType(): string
	{
		return strtoupper($this->requestType);
	}

	public function isAjaxRequest(): bool
	{
		return ($this->requestType == 'AJAX');
	}

	public function isCliRequest(): bool
	{
		return ($this->requestType == 'CLI');
	}

	public function isHttpsRequest(): bool
	{
		if (!empty($this->input['server']['https']) && $this->input['server']['https'] !== 'off') {
			$isHttps = true;
		} elseif (isset($this->input['server']['http_x_forwarded_proto']) && $this->input['server']['http_x_forwarded_proto'] === 'https') {
			$isHttps = true;
		} elseif (!empty($this->input['server']['http_front_end_https']) && $this->input['server']['http_front_end_https'] !== 'off') {
			$isHttps = true;
		} else {
			$isHttps = false;
		}

		return $isHttps;
	}

	public function raw()
	{
		return $this->pick('raw');
	}

	public function post(string $name = null, $default = null)
	{
		return $this->pick('post', $name, $default);
	}

	public function get(string $name = null, $default = null)
	{
		return $this->pick('get', $name, $default);
	}

	public function request(string $name = null, $default = null)
	{
		return $this->pick('request', $name, $default);
	}

	public function server(string $name = null, $default = null)
	{
		return $this->pick('server', $name, $default);
	}

	public function env(string $name = null, $default = null)
	{
		return $this->pick('env', $name, $default);
	}

	public function cookie(string $name = null, $default = null)
	{
		return $this->pick('cookie', $name, $default);
	}

	protected function pick(string $type, ?string $name = null, $default = null)
	{
		if ($name === null) {
			$value = $this->input[$type];
		} elseif (isset($this->input[$type][strtolower($name)])) {
			$value = $this->input[$type][strtolower($name)];
		} else {
			$value = $default;
		}

		return $value;
	}
} /* end class */
