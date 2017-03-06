<?php

Class Controller_player extends Controller_token
{

// Funcion para Postear Score individualmente a través de id
       public function post_score($id)
       {

        $puntuacion =  Model_player::Find('all');

        $verificacion = $this->get_userVerify(); //Mandamos verificación

        if ($verificacion == true ) // Si la verificacion es correcta
        {

         foreach ($puntuacion as $puntos) // Recorremos la tabla de jugadores...
          {
            if ($puntos['id'] == $id)
            {

            $puntos->score = Input::post ('score');// -> significa acceso a la propiedad o método o atributos de un objeto de la clase que estoy usando y posteamos la score
            $puntos->save(); // guardamos la puntuación

              return $this->response(['score' => 'guardada',]); // => Asginamos valores para arrays con eso
           }
          }
        }
          else
          {
            return $this->codeInfo($code = 402, $mensaje = 'Error, no se ha podido establecer la nueva Score');
         }

      }

    // FUNCION PARA RECIBIR LA SCORE
    public function get_score()
    {


        $verificacion = $this->get_userVerify();
        $player_score = Model_player::find('all');  # Buscamos los campos de la base de datos a traves del modelo en este caso todos los campos de las tablas.

        if ($verificacion == true )
        {

            foreach ($player_score as  $player)
            {
              var_dump ($player['alias']); // MOSTRAMOS SOLAMENTE EL SCORE Y EL ALIAS DEL LOS JUGADORES
              var_dump ($player['score']);

            }
              //return $player_score; // SI QUIERO QUE SE MUESTREN TODOS LOS DATOS INCLUYENDO EL ID SOLO TENEMOS QUE QUITAR EL FOREACH Y TODO LO QUE LLEVA DENTRO Y SUSTITUIRLO POR ESTE RETURN

        }
        else
        {

            return $this->codeInfo($code = 404, $mensaje = 'No se encuentra la Score');
        }
    }









}
