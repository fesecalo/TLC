<?php 

	class csrf {

		// genera un token random
		public function get_token_id() {
	        if(isset($_SESSION['token_id'])) {
	        	unset($_SESSION['token_id']); 
	        }
	        
            $token_id = $this->random(10);
            $_SESSION['token_id'] = $token_id;
            return $token_id;
		}

		// enchipra el token generado
		public function get_token() {
	        if(isset($_SESSION['token_value'])) {
	        	unset($_SESSION['token_value']);
	        }
            $token = hash('sha256', $this->random(500));
            $_SESSION['token_value'] = $token;
            return $token;
	        
		}

		// devuelve el token actual
		public function get_token_actual() {
	        return $_SESSION['token_value'];
		}

		// valida que el metodo sea post y el token sean correctos
		public function check_valid($token) {
			// verifica si el token creado es igual al recivido
            if($token==$this->get_token_actual()) {
            	// si los token son iguales los destruye para no volver a utilizarlos
            	unset($_SESSION['token_id']);
            	unset($_SESSION['token_value']);
            	// devuelve valor 1
                return 1;
            } else {
            	// si los token son diferentes devuelve 2
                return 2;   
            }
		}

		// genera un token de manera random
		private function random($len) {
	        if (@is_readable('/dev/urandom')) {
	                $f=fopen('/dev/urandom', 'r');
	                $urandom=fread($f, $len);
	                fclose($f);
	        }
	 
	        $return='';
	        for ($i=0;$i<$len;++$i) {
	                if (!isset($urandom)) {
	                        if ($i%2==0) mt_srand(time()%2147 * 1000000 + (double)microtime() * 1000000);
	                        $rand=48+mt_rand()%64;
	                } else $rand=48+ord($urandom[$i])%64;
	 
	                if ($rand>57)
	                        $rand+=7;
	                if ($rand>90)
	                        $rand+=6;
	 
	                if ($rand==123) $rand=52;
	                if ($rand==124) $rand=53;
	                $return.=chr($rand);
	        }
	        return $return;
		}

	}
?>