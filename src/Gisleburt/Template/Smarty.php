<?php

	namespace Gisleburt\Template;

	/**
	 * Smarty Template Engine wrapper
	 */
	class Smarty implements Template
	{

		/**
		 * What to stick on the end of the template name
		 * @var string
		 */
		protected $defaultSuffix = 'tpl';

		/**
		 * Smarty object
		 * @var \Smarty
		 */
		protected $smarty;

		/**
		 * The template to use unless otherwise stated
		 * @var string
		 */
		protected $template;

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

			require_once "{$config['includeDir']}/Smarty.class.php";

			$this->smarty = new \Smarty();

			if(array_key_exists('configDir', $config))
				$config['configDirs'][] = $config['configDir'];

			if(array_key_exists('pluginDir', $config))
				$config['pluginDirs'][] = $config['pluginDir'];

			if(array_key_exists('templateDir', $config))
				$config['templateDirs'][] = $config['templateDir'];

			foreach($config['configDirs'] as $dir)
				$this->smarty->addConfigDir($dir);

			foreach($config['pluginsDirs'] as $dir)
				$this->smarty->addPluginsDir($dir);

			foreach($config['templateDirs'] as $dir)
				$this->smarty->addTemplateDir($dir);

			$this->smarty->setCacheDir($config['cacheDir']);

			$this->smarty->setCompileDir($config['compileDir']);

			$this->smarty->error_reporting = E_ERROR;

			$this->smarty->muteExpectedErrors();

			$this->config = $config;

			return $this;

		}

		/**
		 * Assign a variable to the template with a given value
		 * @param $name string|array The name of the variable to assign
		 * @param $value mixed The value of the variable to assign
		 */
		public function assign($name, $value = null) {
			$this->smarty->assign($name, $value);
			return $this;
		}

		/**
		 * Display the chosen template.
		 * @param $template string (optional) Override previously set template for this action only
		 */
		public function display($template) {
			if(!strpos($template, '.'))
				$template = "$template.$this->defaultSuffix";
			$this->smarty->display($template);
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
			return $this->smarty->fetch($template);
		}

	}
