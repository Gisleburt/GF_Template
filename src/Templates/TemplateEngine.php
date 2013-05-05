<?php

	namespace Gisleburt\Templates;

	/**
	 * An interface to smooth out differences between various template engines
	 */
	interface TemplateEngine
	{

		/**
		 * Any initialisation should be done here
		 * @param $config array
		 */
		public function initialise(array $config);

		/**
		 * Assign a variable to the template with a given value
		 * @param $name string|array The name of the variable to assign
		 * @param $value mixed The value of the variable to assign
		 */
		public function assign($name, $value = null);

		/**
		 * Display the chosen template.
		 * @param $template string (optional) Override previously set template for this action only
		 */
		public function display($template);

		/**
		 * Compiles the template and returns the result as a string
		 * @param $template string (optional) Override previously set template for this action only
		 * @return string
		 */
		public function fetch($template);

	}
