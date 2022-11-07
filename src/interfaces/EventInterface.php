<?php

declare(strict_types=1);

namespace dmyers\orange\interfaces;

interface EventInterface
{
	const PRIORITY_LOWEST = 10;
	const PRIORITY_LOW = 20;
	const PRIORITY_NORMAL = 50;
	const PRIORITY_HIGH = 80;
	const PRIORITY_HIGHEST = 90;

	const SORTED = 0;
	const PRIORITY = 1;
	const CALLABLE = 2;

	public function register($name, $callable, int $priority = self::PRIORITY_NORMAL): self;
	public function trigger(string $name, &...$arguments): self;
	public function has(string $name): bool;
	public function events(): array;
	public function count(string $name): int;
	public function unregister(string $name, $matches = null): bool;
	public function unregisterAll(): self;
}
