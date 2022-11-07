<?php

declare(strict_types=1);

namespace dmyers\orange\interfaces;

interface InputInterface
{
	public function requestUri(): string;
	public function requestMethod(): string;
	public function requestType(): string;
	public function isAjaxRequest(): bool;
	public function isCliRequest(): bool;
	public function isHttpsRequest(): bool;
	public function raw();
	public function post(string $name = null, $default = null);
	public function get(string $name = null, $default = null);
	public function request(string $name = null, $default = null);
	public function server(string $name = null, $default = null);
	public function env(string $name = null, $default = null);
	public function cookie(string $name = null, $default = null);
}
