<?php 

	class Nivel {
		var $id;
		var $desc;
		var $obs;

		public function getId() {
			return $this->id;
		}

		public function getDesc() {
			return $this->desc;
		}

		public function getObs() {
			return $this->obs;
		}
		// SET

		public function setId($value) {
			$this->id = $value;
		}

		public function setDesc($value) {
			$this->desc = $value;
		}

		public function setObs($value) {
			$this->obs = $value;
		}
	}
