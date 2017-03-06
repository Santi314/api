 <?php

use \Firebase\JWT\JWT;

class Controller_logros extends Controller_token
{

	public function post_create(){
		// /print('create');
		$logro = new Model_logros();
		$logros = Model_logros::find('all');

		$name = input::post ('name');
		
		foreach ($logros as $key) {

			if($key['nombre'] == $name){
				
				return $this->codeInfo($code = 402, $mensaje = 'Error, logro ya existe');
			}
		}

		if ($this->get_userVerify()){
			if(isset($name) && $name != null){
				$logro->nombre = $name;
				$logro->save();
				return $this->codeInfo($code = 200, $mensaje = 'Exito al crear logro');
			}else{
				return $this->codeInfo($code = 401, $mensaje = 'Error en create campos vacios');
			}
		}else{
			return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
		}

	}

	public  function post_delete($id){
		
		$logros = Model_logros::find('all');
		if ($this->get_userVerify()){
			if ($id != null && isset($id)){
				foreach ($logros as $key) {

					if($key['id'] == $id){
						$key->delete();
						return $this->codeInfo($code = 200, $mensaje = 'Exito al borrar logro');
					}
				}
			}else{
				return $this->codeInfo($code = 401, $mensaje = 'Error en create campos vacios');
			}
			
		}else{
			return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
		
		}


	}

	public  function post_update($id){
		
		$logros = Model_logros::find('all');

		$name = input::post ('name');
		
		if ($this->get_userVerify()){
			if ($id != null && isset($id)){
				foreach ($logros as $key) {

					if($key['id'] == $id){
						$key->nombre = $name;
						$key->save();
						return $this->codeInfo($code = 200, $mensaje = 'Exito al modigicar logro');
					}
				}
			}else{
				return $this->codeInfo($code = 401, $mensaje = 'Error en create campos vacios');
			}
			
		}else{
			return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
		
		}


	}

	public  function post_desbloquear(){
		
		$logros = Model_logros::find('all');

		$user = input::post ('user');
		$logro = input::post ('logro');
		
		if ($this->get_userVerify()){
			if ($id != null && isset($id)){
				

			}else{
				return $this->codeInfo($code = 401, $mensaje = 'Error en create campos vacios');
			}
			
		}else{
			return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
		
		}


	}

	public function post_desbloqueo()
    {

       $desbloqueo = new Model_conseguidos();
       $logros =   Model_logros::find('all');
       $users =  Model_player::find('all');

       $player = input::post ('userid');
       $logroid = input::post ('logroid');

       foreach ($users as $user)
       {
           if ($user['id'] == $player)
           {

                $desbloqueo->id_jugador = $player;
           }
       }
       foreach ($logros as $logro){

           if ($logro['id'] == $logroid)
           {

                $desbloqueo->id_logro = $logroid;
           }
       }
       

       if ($desbloqueo->id_logro != null && $desbloqueo->id_jugador !=null)
       {

            $desbloqueo->save();
            return $this->response('desbloqueo con exito');
        }
        else
        {
            return $this->response('desbloqueo fallida');

        }

    }

    public function get_logros()
    {

        $verificacion = $this->get_userVerify();

            if ($verificacion == true ) // Si verificiación es positiva
            {

                $logo_data = Model_logros::find('all'); // Hacemos return a todos los Items
                return $logo_data;

            }
            else
            {

               return $this->codeInfo($code = 404, $mensaje = 'Nada encontrado, revise los datos introducidos o vuelva a intentarlo');

            }
    }

     public function post_userlogroById($id) //Recibo mandando datos con el id de la funcion que es el id que introducimos en postman
    {

        $verificacion = $this->get_userVerify();


        if ($verificacion == true )
        {

            $user = Model_users2::find('all');
            $players = Model_player::find('all');
            $logro = Model_logros::find('all');
            $desbloqueados = Model_conseguidos::find('all');
            $array = [];
            $name = "";

            foreach ($user as $users)
            {

                if ($users['id'] != null && $users['id'] == $id)
                {
                	$name = $users;
                	foreach ($desbloqueados as $desbloqueado) {
                		                	
	                    if($desbloqueado['id_jugador'] != null && $desbloqueado['id_jugador'] == $id)
	                    {
	                        foreach ($logro as $logros)
	                        {
	                            if($logros['id'] == $desbloqueado['id_logro'])
	                            {
	                                //return $this->response(array($logros,$users));
	                                array_push($array,$logros);
	                            }
	                        }
	                    }
	                }
                 }
                 else
                 {
                 	//return $this->codeInfo($code = 404, $mensaje = 'No existe Item con la Id seleccionada, elije mejor...');

                    // if ( $logro['id'] == $id )
                    //     {

                    //             return $this->response(array($users));
                    //     }

                 }
             }
             // SI EL ID NO CORRESPONDE A NINGÚN JUGADOR O USUARIO DEVUELVE ESTE MENSAJE:
             return $this->response(array(
                'user' => $name,
                'logros'=>$array));
            
        }

        else // Este else es la auteficacion del token que verifica si lo envias o no
        {

            return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
        }

    }





}