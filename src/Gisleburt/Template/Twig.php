<?php

	namespace Gisleburt\Template;

	/**
	 * Smarty Template Engine wrapper
	 */
	class Twig implements Template
	{

		/**
		 * What to stick on the end of the template name
		 * @var string
		 */
		protected $defaultSuffix = 'html';

		/**
		 * Twig Environment object
		 * @var \Twig_Environment
		 */
		protected $twig;

		/**
		 * Twig Loader
		 * @var Twig_Loader_Filesystem
		 */
		protected $loader;

		/**
		 * The template to use unless otherwise stated
		 * @var string
		 */
		protected $template;

		/**
		 * Variables that will be passed to the displayed template
		 * @var array
		 */
		protected $templateVariables = array();

		/**
		 * Configuration
		 * @var array
		 */
		protected $config;


		public function __construct(array $config = array()) {
			if($config)
				$this->initialise($config);
		}

		/**
		 * Any initialisation should be done here
		 * @param $config array
		 */
		public function initialise(array $config) {
			require_once $config['twigDir'].'/Autoloader.php';
			\Twig_Autoloader::register();

			$loader = new \Twig_Loader_Filesystem($config['templateDirs']);
			$this->twig = new \Twig_Environment($loader, array(
				'cache' => $config['compileDir'],
				'debug' => $config['devmode'],
			));
			return $this;
		}

		/**
		 * Assign a variable to the template with a given value
		 * @param $name string|array The name of the variable to assign
		 * @param $value mixed The value of the variable to assign
		 */
		public function assign($name, $value = null) {
			$this->templateVariables[$name] = $value;
			return $this;
		}

		/**
		 * Display the chosen template.
		 * @param $template string (optional) Override previously set template for this action only
		 */
		public function display($template) {
			if(!strpos($template, '.'))
				$template = "$template.$this->defaultSuffix";
			echo $this->twig->render($template, $this->templateVariables);
			return $this;
		}

		/**
		 * Compiles the template and returns the result as a string
		 * @param $template string (optional) Override previously set template for this action only
		 * @return string
		 */
		public function fetch($template) {
			if(!strpos($template, '.'))
				$template = "$template.$this->defaultSuffix";
			return $this->twig->render($template, $this->templateVariables);
		}


	}
