<?php

class Controller_users2 extends Controller_token
{

    //Funcion para registrar usuarios
    public function post_create()
    {

        $username = Input::post('username');
        $password = Input::post('password');
        $email = Input::post('email');
        $foto = Input::post('foto');

        // Si estan vacios se envia un código de error
        if (empty($username) or empty($password) )
        {
            return $this->codeInfo($code = 400, $mensaje = 'Faltan campos por enviar');
        }
        else
        {

            $userBD = Model_users2::find('all', array(
                'where' => array(
                    array('username', Input::post('username')),
                    )
                ));

                    foreach ($userBD as $verif => $value)
                    {
                        $usernameBD = $userBD[$verif]->username;
                        //$emailBD = $userBD[$verif]->email;
                    }

                    //Si el usuario ya esta registrado...
                    if ( Isset($usernameBD) == $username ) // Isset determina si una variable no está definida y es null!!
                    {

                        return $this->codeInfo($code = 402, $mensaje = 'Error, user ya registrado');
                    }

                    else
                    {

                        $jugadores = Model_player::find('all');
                        $alias = input::post ("alias");
                        foreach ($jugadores as $jugador)
                        {
                            if ($alias == null || $alias == $jugador['alias'] )
                            {
                                return $this->codeInfo($code = 402, $mensaje = 'Error, jugador ya registrado');
                            }
                        }


                        $user = new Model_users2();
                        $user->username = Input::post('username');
                        $user->email = Input::post('email');
                        $user->password = Input::post('password');
                        $user->foto = Input::post('foto');


                        $player = new Model_player();
                        $player->alias = $alias;
                        $player->score = 0;


                        $player->save();
                        var_dump($player->id);
                        $jugadores = Model_player::find('all');
                        foreach ($jugadores as $jugador)
                        {
                            var_dump($jugador['id']);
                            if ($player->id == $jugador['id'] )
                            {
                                $user->id_jugador = $jugador['id'];
                            }
                        }


                        $user->save();



                        return $this->codeInfo($code = 200, $mensaje = 'Exito, usuario registrado');
                    }
        }
    }




    public function get_player($user,$players)
    {
        if($user['id_jugador'] != null)
        {
            foreach ($players as $player )
            {
                if($user['id_jugador'] == $player['id'] )
                {
                 //eturn $this->response(array($user,$player));
                    var_dump($user['id']);
                    var_dump($user['username']);
                    var_dump($user['password']);
                    var_dump($user['email']);
                    var_dump($player['id']);
                    var_dump($player['alias']);
                    var_dump($player['score']);

                }
                else
                {
                    print('nop');
                }
            }
        }
        else
        {
            //return $this->response(array($user));
            var_dump($user['id']);
            var_dump($user['username']);
            var_dump($user['password']);
            var_dump($user['email']);
        }
    }



    //Funcion de ADMIN para listar todos los usuarios
    public function get_users()
    {

        $verificacion = $this->get_userVerify();
        $array = [];
        $usuario = [];
        $jugador = [];
        $otro = [];


        if ($verificacion == true )
        {

            $users = Model_users2::find('all');
            $players = Model_player::find('all');
            $buys = Model_items::find('all');
            //$users = Model_users2::find('all', array(array()))


            foreach ($users as $user )
            {
                 foreach ($players as $player )
                {
                    if($user['id_jugador']==$player['id']){
                     
                        $otro = [];
                        array_push($otro, $user);
                        
                        array_push($array, $otro);

                        
                    }
                }


            }
             return $this->response($array);

        }
        else
        {
            //return $this->errorAuth();
            return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');  //ERROR VERIFICACION DE SESION
        }


    }

    //Funcion para listar los datos de un user a partir de su ID

    public function post_user($id) //Recibo mandando datos con el id de la funcion que es el id que introducimos en postman

    {

        $verificacion = $this->get_userVerify();


        if ($verificacion == true )
        {

            $user = Model_users2::find('all');
            $players = Model_player::find('all');

            foreach ($user as $users)
            {

                if ($users['id_jugador'] != null){
                    foreach ($players as $player)
                    {
                        if ( $users['id'] == $id && $users['id_jugador'] == $player['id'] )
                        {

                                return $this->response(array($users,$player));


                        }
                     }
                 }
                 else
                 {

                    if ( $users['id'] == $id )
                        {

                                return $this->response(array($users));
                        }

                 }
             }
             // SI EL ID NO CORRESPONDE A NINGÚN JUGADOR O USUARIO DEVUELVE ESTE MENSAJE:
            return $this->codeInfo($code = 404, $mensaje = 'No existe user con la ID seleccionada... ELIJA MEJOR LA PROXIMA VEZ!');

        }

        else // Este else es la auteficacion del token que verifica si lo envias o no
        {

            return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
        }

    }

    public function post_userItems($id) //Recibo mandando datos con el id de la funcion que es el id que introducimos en postman

    {

        $verificacion = $this->get_userVerify();


        if ($verificacion == true )
        {
            $items = Model_items::find('all');
            $buy = Model_compra::find('all');
            $user = Model_users2::find('all');
            $players = Model_player::find('all');
            $array = [];
            $name = "";

            foreach ($user as $users)
            {
                if ($users['id_jugador'] != null)
                {

                        if ( $users['id'] == $id)
                        {
                            //array_push($array,$users['username']);
                            $name = $users['username'];

                            foreach ($buy as $buys)
                            {
                               if($users['id_jugador'] == $buys['id_jugador'])
                               {
                                    array_push($array, $buys);
                               }


                            }

                        }
                 }

                 else
                 {

                    var_dump('Este usuario no ha hecho compras y no tiene items');

                 }
             }
                 //var_dump($array);
            //return $this->codeInfo($code = 404, $mensaje = 'No existe user con la ID seleccionada... ELIJA MEJOR LA PROXIMA VEZ!');if()
                return $this->response(array(
                'name' => $name,
                'items'=>$array));

             // SI EL ID NO CORRESPONDE A NINGÚN JUGADOR O USUARIO DEVUELVE ESTE MENSAJE:
            return $this->codeInfo($code = 404, $mensaje = 'No existe user con la ID seleccionada... ELIJA MEJOR LA PROXIMA VEZ!');

        }

        else // Este else es la auteficacion del token que verifica si lo envias o no
        {

            return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
        }

    }


    // MODIFICAMOS UN USUARIO POR SU ID INDIVIDUALMENTE
    public function post_update($id)
    {

        $verificacion = $this->get_userVerify();


        if ($verificacion == true )
        {

            $guardarUser = Input::post("username");
            $guardarEmail = Input::post("email");
            $guardarPass = Input::post("password");
            $guardarFoto = Input::post("foto");


            $user = Model_users2::find('all', array(
            'where' => array(
                array('id', $id))));


            if ( $guardarUser == null or $guardarEmail == null or $guardarPass == null or $guardarFoto == null)
            {

                return $this->codeInfo($code = 406, $mensaje = 'Error, algun campo esta vacio');

            }
            else
            {

                if($user!=null)
                {

                    $user[$id]->set(array(        // POR QUE EL EL INDEX DEL ARRAY ES EL 4?
                    'username'  => $guardarUser,
                    'password' => $guardarPass,
                    'email' => $guardarEmail,
                    'foto' => $guardarFoto
                ));

                $user[$id]->save();


                return $user;

                }

                else
                {

                return $this->codeInfo($code = 404, $mensaje = 'No existe user con tal ID');
                }

            }
        }
        else
        {

            return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
        }

    }

    // Funcion para Borrar individualmente por Id
    public function post_delete($id)
    {

        $verificacion = $this->get_userVerify();
        //var_dump($verificacion);

        if ($verificacion == true )
        {




            $user = Model_users2::find('all', array(
            'where' => array(
                array('id', $id))));



            if($user!=null)
            {

                $user[$id]->delete();


                return [
                $this->codeInfo($code = 200, $mensaje = 'Exito, usuario borrado'),
                $user ];

            } else{

                return $this->codeInfo($code = 404, $mensaje = 'No existe user con tal ID');
            }
        }
        else
        {

            return $this->codeInfo($code = 403, $mensaje = 'Error verificacion de sesion');
        }

    }


    //Funcion para listar los datos de un user a partir de su ID

    public function post_username($username) //Recibo mandando datos con el id de la funcion que es el id que introducimos en postman

    {

        $verificacion = $this->get_userVerify();


        if ($verificacion == true )
        {

            $user = Model_users2::find('all');
            $players = Model_player::find('all');

            foreach ($user as $users)
            {

                if ($users['username'] != null && $users['username'] == $username)
                {

                        return $this->response(array($users));


                }

                                 else
                 {

                    if ( $users['username'] == $username )
                        {

                                return $this->response(array($users));
                        }

                 }
            }


        }
             // SI EL ID NO CORRESPONDE A NINGÚN JUGADOR O USUARIO DEVUELVE ESTE MENSAJE:
            return $this->codeInfo($code = 404, $mensaje = 'No existe user con el nombre seleccionado... ELIJA MEJOR LA PROXIMA VEZ!');



        // else // Este else es la auteficacion del token que verifica si lo envias o no
        // {

        //     return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
        // }

    }

    public function post_score($id)
    {

        $verificacion = $this->get_userVerify();


        if ($verificacion == true )
        {

            $score = Input::post("score");
            $usuario = Model_users2::find('all');

            foreach ($usuario as $user) {

                if ($user['id'] == $id){
                    $player = Model_player::find('all', array(
                    'where' => array(
                     array('id', $user['id_jugador']))));
                    $num = $user['id_jugador'];
                    var_dump($id);
                }
            }
            

            // $user = Model_users2::find('all', array(
            // 'where' => array(
            //     array('id', $id))));


            if ( $score == null     )
            {

                return $this->codeInfo($code = 406, $mensaje = 'Error, algun campo esta vacio');

            }
            else
            {

                if($player!=null )
                {

                    $player[$num]->set(array(        // POR QUE EL EL INDEX DEL ARRAY ES EL 4?
                    'score' => $score
                    ));

                $player[$num]->save();


                return $player;

                }

                else
                {

                return $this->codeInfo($code = 404, $mensaje = 'No existe user con tal ID');
                }

            }
        }
        else
        {

            return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
        }

    }
    



}


