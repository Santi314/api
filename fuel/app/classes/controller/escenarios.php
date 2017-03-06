<?php

use \Firebase\JWT\JWT;

class Controller_escenarios extends Controller_token
{

	public function post_create(){
		// /print('create');
		$escena = new Model_escenarios();
		$escenas = Model_escenarios::find('all');

		$name = input::post ('name');
		$descr = input::post ('descr');
		$foto = input::post ('foto');
		
		foreach ($escenas as $key) {

			if($key['nombre'] == $name){
				
				return $this->codeInfo($code = 402, $mensaje = 'Error, escena ya existe');
			}
		}

		if ($this->get_userVerify()){
			if(isset($name) && $name != null){
				$escena->nombre = $name;
				$escena->descripcion = $descr;
				$escena->imagen = $foto;
				$escena->save();
				return $this->codeInfo($code = 200, $mensaje = 'Exito al crear escena');
			}else{
				return $this->codeInfo($code = 401, $mensaje = 'Error en create campos vacios');
			}
		}else{
			return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
		}

	}

	public  function post_delete($id){
		
		$escenas = Model_escenarios::find('all');
		if ($this->get_userVerify()){
			if ($id != null && isset($id)){
				foreach ($escenas as $key) {

					if($key['id'] == $id){
						$key->delete();
						return $this->codeInfo($code = 200, $mensaje = 'Exito al borrar escena');
					}
				}
				return $this->codeInfo($code = 402, $mensaje = 'usuario no existe');
			}else{
				return $this->codeInfo($code = 401, $mensaje = 'Error en create campos vacios ');
			}
			
		}else{
			return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
		
		}


	}

	public  function post_update($id){
		
		$escenas = Model_escenarios::find('all');

		$name = input::post ('name');
		$descr = input::post ('descr');
		$foto = input::post ('foto');


		foreach ($escenas as $key) {

			if($key['id'] == $id){
				if (input::post ('descr') == null){
					$descr = $key->descripcion;
				}

				if (input::post ('foto') == null){
					$foto = $key->imagen;
				}
			}
		}
		


		
		if ($this->get_userVerify()){
			if ($id != null && isset($id)){
				foreach ($escenas as $key) {

					if($key['id'] == $id){
						$key->nombre = $name;
						$key->descripcion = $descr;
						$key->imagen = $foto;
						$key->save();
						$key->save();
						return $this->codeInfo($code = 200, $mensaje = 'Exito al modigicar escena');
					}
				}
			}else{
				return $this->codeInfo($code = 401, $mensaje = 'Error en create campos vacios');
			}
			
		}else{
			return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
		
		}


	}

	/*public  function post_desbloquear(){
		
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


	}*/

	public function post_desbloqueo()
    {

       $desbloqueo = new Model_desbloqueados();
       $escenas = Model_escenarios::find('all');
       $users =  Model_player::find('all');

       $player = input::post ('userid');
       $escens = input::post ('escenid');

       foreach ($users as $user)
       { 
           if ($user['id'] == $player)
           {
				
                $desbloqueo->id_jugador = $player;
           }
       }
       foreach ($escenas as $escena){
			
           if ($escena['id'] == $escens)
           {
           		
                $desbloqueo->id_nivel = $escens;
           }
       }
       
		
	    
       if ($desbloqueo->id_nivel != null && $desbloqueo->id_jugador !=null)
       {

            $desbloqueo->save();
            return $this->response('desbloqueo con exito');
        }
        else
        {

            return $this->response('desbloqueo fallida');

        }

    }

    public function get_scenes()
    {

        $verificacion = $this->get_userVerify();

            if ($verificacion == true ) // Si verificiación es positiva
            {

                $scene_data = Model_desbloqueados::find('all'); // Hacemos return a todos los Items
                return $scene_data;

            }
            else
            {

               return $this->codeInfo($code = 404, $mensaje = 'Nada encontrado, revise los datos introducidos o vuelva a intentarlo');

            }
    }

     public function post_usersceneById($id) //Recibo mandando datos con el id de la funcion que es el id que introducimos en postman
    {

        $verificacion = $this->get_userVerify();


        if ($verificacion == true )
        {

            $user = Model_users2::find('all');
            $players = Model_player::find('all');
            $desbloqueo =  Model_desbloqueados::find('all');
       		$escenas = Model_escenarios::find('all');

            $array = [];
            $name = "";

            foreach ($user as $users)
            {

                if ($users['id'] != null && $users['id'] == $id)
                {
                	$name = $users;
                	foreach ($desbloqueo as $desbloqueado) {
                		                	
	                    if($desbloqueado['id_jugador'] != null && $desbloqueado['id_jugador'] == $id)
	                    {
	                        foreach ($escenas as $escena)
	                        {
	                            if($escena['id'] == $desbloqueado['id_nivel'])
	                            {
	                                //return $this->response(array($logros,$users));
	                                array_push($array,$escena);
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
                'users' => $name,
                'escenarios'=>$array));
            
        }

        else // Este else es la auteficacion del token que verifica si lo envias o no
        {

            return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
        }

    }





}