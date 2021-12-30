<?php

// Autoload Spouse namespace classes
spl_autoload_register('spouse_class_autoloader');

function spouse_class_autoloader($class) {
  $baseDir = __DIR__ . '/../classes/';
  $namespace = 'Spouse\\';
	if (strpos($class, $namespace) !== 0) {
		return;
	}
  $class = str_replace($namespace, '', $class);

  $file = $baseDir . $class . '.php';

  if (file_exists($file)) {
      require $file;
  }
}