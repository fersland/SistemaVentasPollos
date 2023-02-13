<?php
    
    @session_start();
    
	require 'config.php';

	class DBSTART extends CONFIG{
	   
		public static function abrirDB() {
			try {
				if ( 'Desarrollo'  == self::AMBIENTE ) {
					$db = new PDO(self::SERVER, self::USUARIO, self::PASSW,
								array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::FETCH_OBJ));
				//echo 'Conectado';
				}
			} catch (Exception $e) {
				echo 'Error en la conexion'. $e->getMessage();
			}

			return $db;
		}
        
        public static function cerrarDB(){
            
        }
	}