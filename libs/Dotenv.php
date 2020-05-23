<?php 

class Dotenv {

	private string $nameFile;
	private	array $env = [];

	public function __construct(string $nameFile) {
		$this->nameFile = $nameFile;
	}

	private function setEnv(string $name, string $env) {
		$this->env[$name] = $env;
	}

	private function checkFile() {

		if(empty($this->nameFile) ) {
			echo 'Define una ruta del archivo .env';
			die();
			return false;
	
		}

		if(file_exists($this->nameFile) ) {
			return file($this->nameFile);
		}
	}

	public function env() {
		
		$env = $this->checkFile();

		if($env){

			foreach ($env as $line) {
				
				$separate = explode('=', $line);
				
				$nameEnv = $separate[0];
				$credentials = trim(str_replace('"','',$separate[1]) );
				
				$this->setEnv($nameEnv, $credentials);
			}
			
			return $this->env;
		}

	}

}

?>