<?php

declare(strict_types=1);

namespace dmyers\orange\interfaces;

interface ConfigInterface
{
	public function __set($name, $value);
	public function set(string $name, $value): void;
	public function __get($name);
	public function get(string $name);
	public function __isset($name);
	public function isset(string $name): bool;
	public function __unset($name);
	public function unset(string $name);
	public function __toString();
	public function toString(): string;
	public function __debugInfo();
}
