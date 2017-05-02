<?php

	class View
	{
		private $viewPath;
		private $data;
		private $template;
		private $extension;

		public function __construct($viewPath, $data = [], $template = 'default', $extension = 'phtml')
		{
			$this->viewPath = $viewPath;
			$this->data = $data;
			$this->template = $template;
			$this->extension = $extension;

			$this->generate();
		}

		private function generate()
		{
			extract($this->data);

			if($this->template === null)
			{
				require 'views/'.$this->viewPath.'.'.$this->extension;
			}
			else
			{
				ob_start();
				require 'views/'.$this->viewPath.'.'.$this->extension;
				$content = ob_get_clean();
				require 'views/templates/'.$this->template.'.phtml';
			}
		}
	}