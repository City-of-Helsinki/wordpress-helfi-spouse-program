<?php

// Autoload Spouse namespace classes
spl_autoload_register('spouse_class_autoloader');

function spouse_class_autoloader($class) {
  $baseDir = get_template_directory() . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR;
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

function spouse_require($file){
	$theme_path = untrailingslashit( get_template_directory() );
	$file_path = $theme_path . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . $file . '.php';
	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	}
}

function spouse_program_init(){
	$files = array();
	if (! function_exists('spouse_program_core_init')){
		$files = array(
			'cf7-custom',
			'event-previewbox',
			'newsletters',
			'spouse-emailfrom',
			'spouse-notice',
			'shortcode',
			'static-pages' . DIRECTORY_SEPARATOR . 'config',
			'static-pages' . DIRECTORY_SEPARATOR . 'settings',
			'static-pages' . DIRECTORY_SEPARATOR . 'admin-action',
			'static-pages' . DIRECTORY_SEPARATOR . 'admin-notice',
			'static-pages' . DIRECTORY_SEPARATOR . 'post-state',
			'static-pages' . DIRECTORY_SEPARATOR . 'handlers',
			'static-pages' . DIRECTORY_SEPARATOR . 'init',
		);
	}
	$files = array_merge($files, array(
		'main-menu'
	));

	foreach ($files as $file) {
		spouse_require($file);
	}
}
add_action('init', 'spouse_program_init');
