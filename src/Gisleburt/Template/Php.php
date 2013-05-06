<?php

	namespace Gisleburt\Template;

	/**
	 * Smarty Template Engine wrapper
	 */
	class Php implements Template
	{

		/**
		 * What to stick on the end of the template name
		 * @var string
		 */
		protected $defaultSuffix = 'php';

		/**
		 * The template to use unless otherwise stated
		 * @var string
		 */
		protected $template;

		/**
		 * Variables to be assigned to the template
		 * @var array
		 */
		protected $templateVars = array();

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
		 * @param array $config
		 * @return $this
		 */
		public function initialise(array $config) {
			$this->config = $config;
			return $this;
		}

		/**
		 * Assign a variable to the template with a given value
		 * @param $name string|array The name of the variable to assign
		 * @param $value mixed The value of the variable to assign
		 */
		public function assign($name, $value = null) {
			$this->templateVars[$name] = $value;
		}

		/**
		 * Set the template that will be used
		 * @param $template string Name of the template file
		 * @return $this
		 */
		public function setTemplate($template) {
			$this->template = $template;
			return $this;
		}

		/**
		 * Display the chosen template.
		 * @param string $template (optional) Override previously set template for this action only
		 * @return $this
		 */
		public function display($template) {
			if(!strpos($template, '.'))
				$template = "$template.$this->defaultSuffix";
			extract($this->templateVars);
			require $this->getTemplate($template);
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
			extract($this->templateVars);
			return $this->smarty->fetch($template);
		}

		/**
		 * Gets the template
		 * @param $template
		 * @return string
		 * @throws \Exception
		 */
		protected function getTemplate($template) {
			$failedDirs = array();
			foreach($this->config['templateDirs'] as $dir) {
				if(is_readable("$dir/$template"))
					return "$dir/$template";
				$failedDirs[] = $dir;
			}
			throw new \Exception("Template '$template' not found in: ".implode(', ', $failedDirs));
		}



	}
