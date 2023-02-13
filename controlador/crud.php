<?php
    
    require_once ('../datos/db/connect.php');
    
	class CRUD {
		public $insert_into;        public $insert_columns;
        public $insert_values;      public $select;
        public $from;               public $where;
        public $condicional;        public $rows;
        public $update;             public $set;
        public $deleteFrom;

	public function Create() {
        $insert_into        = $this->insert_into;
        $insert_columns     = $this->insert_columns;
        $insert_values      = $this->insert_values;

        $sql = "INSERT INTO $insert_into ($insert_columns) VALUES ($insert_values)";
        $consultaPreparada = DBSTART::abrirDB()->prepare($sql);

            if($consultaPreparada == FALSE){
                $this->mensaje = "Error";
                }else{
                    $consultaPreparada->execute();
                    $this->mensaje = 'Exito';
                }
	}
	public function Read() {
        $select         = $this->select;
        $from           = $this->from;
        $where          = $this->where;
        $condicional    = $this->condicional;

        if ($condicional == true) {
            $condicional = " WHERE ". $condicional;
        }

        $sql = "SELECT $select FROM $from $condicional";
        $seleccionPreparada = DBSTART::abrirDB()->prepare($sql);
        $seleccionPreparada->execute();

            while ($mostrado = $seleccionPreparada->fetch()) {
                $this->rows[] = $mostrado;
            }
	}
	public function Update() {
        $update     = $this->update;
        $set        = $this->set;

        $condicional = $this->condicional;

        if ($condicional != '') {
            $condicional = " WHERE " .$condicional;
        }

        $sql = "UPDATE $update SET $set $condicional";
        $actualiza = DBSTART::abrirDB()->prepare($sql);
        if (!$actualiza) {
            $this->mensaje = 'Datos NO actualizados!';
            }else{
                $actualiza->execute();
                $this->mensaje = 'Datos fueron actualizados';
            }
    }
	public function Delete() {
        $deleteFrom     = $this->deleteFrom;
        $condicional    = $this->condicional;

        if ($condicional != '') {
            $condicional = " WHERE " . $condicional;
        }
        $sql = "DELETE FROM $deleteFrom $condicional";
        $eliminar = DBSTART::abrirDB()->prepare($sql);

            if (!$eliminar) {
                $this->mensaje = 'Error al eliminar el registro';
            }else{
                $eliminar->execute();
                $this->mensaje = 'Publicación eliminada!';
            }
	}
}