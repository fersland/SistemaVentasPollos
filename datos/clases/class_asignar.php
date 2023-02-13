<?php 

	class Asignar {
		var $nivel;
		var $modulo;
		var $item;

		public function getNivel() {
			return $this->nivel;
		}

		public function getModulo() {
			return $this->modulo;
		}

		public function getItem() {
			return $this->item;
		}

		// SET

		public function setNivel($value) {
			$this->nivel = $value;
		}

		public function setModulo($value) {
			$this->modulo = $value;
		}

		public function setItem($value) {
			$this->item = $value;
		}
	}
