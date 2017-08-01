<?php declare(strict_types = 1);


function createContainer(Nette\DI\Compiler $source): Nette\DI\Container
{
	$class = 'Container' . md5((string) lcg_value());
	$code = $source->addConfig([])->setClassName($class)->compile();
	eval($code);

	return new $class;
}

return call_user_func(function () {
	require_once __DIR__ . '/../vendor/autoload.php';

	if ( ! class_exists('Tester\Assert')) {
		echo 'Install Nette Tester using `composer install`';
		exit(1);
	}

	Tester\Environment::setup();

	date_default_timezone_set('Europe/Prague');
});
