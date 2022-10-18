<?php

declare(strict_types=1);

namespace app\libraries;

use dmyers\orange\Container;

class Middleware
{
	public function before(Container &$container, array &$route)
	{
		if (substr($route['requestURI'], 0, 5) == '/test' && $route['requestMethod'] == 'GET' && $route['has']) {
			$route['args'][0] = '{{**}}' . $route['args'][0];
		}
	}

	public function after(Container &$container, ?string &$output)
	{
		$route = $container->router->route();

		if (substr($route['requestURI'], 0, 5) == '/test' && $route['requestMethod'] == 'GET' && $route['has']) {
			$output = str_replace('{{**}}', 'It\'s just bikes: ', $output);
		}
	}
} /* end class */