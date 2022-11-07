<?php

declare(strict_types=1);

namespace dmyers\orange\interfaces;

interface ContainerInterface
{
	public function __get(string $serviceName);
	public function get(string $serviceName);

	public function __set(string $serviceName, $option): void;
	public function set(string $serviceName, $option): void;

	public function __isset(string $serviceName): bool;
	public function isset(string $serviceName): bool;

	public function __unset(string $serviceName): void;
	public function unset(string $serviceName): void;

	public function __debugInfo(): array;
}
