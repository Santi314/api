<?php

Class Controller_items extends Controller_token
{
    //Funcion para registrar ITEMS
    public function post_items()
    {

        // MODELO DE ITEMS
        $article = new Model_Items();



        switch (Input::post ('itemType'))
        {

            ///
            case 'granada':

                $grenade = new Model_granadas();
                $grenade->name = Input::Post ('name'); // Primero llamamos al name del modelo y en el input post establecemos como tenemos que llamarlo para introducir los datos
                $grenade->daño = Input::Post ('daño');
                $grenade->alcance = Input::Post ('alcance');
                $grenade->save();

                $article->id_granada = $grenade['id']; // RELACIONAMOS EL ID DE LA GRANDA CON EL ID_GRNADA QUE HAY EN LA TABLA DE ITEMS
                $article->cantidad = Input::Post ('cantidad');
                $article->save();
                return $this->response(array($grenade['name'] => 'cread@ con exito'));

                break;

            ///
            case 'mina':

                $mines = new Model_minas();
                $mines->name = Input::Post ('name');
                $mines->daño = Input::Post ('daño');
                $mines->radio = Input::Post ('radio');
                $mines->save();

                $article->id_mina = $mines['id']; //  ASÍ ESTABLECEMOS QUE LA ID_MINA DE LA TABLA ITEMS ES LA MISMA QUE LA ID DE MINA EN SU TABLA,  ES DECIR COPIA Y PEGA LA ID.
                $article->cantidad = Input::Post ('cantidad');
                $article->save();
                return $this->response(array($mines['name'] => 'cread@ con exito'));

                break;

            ///
            case 'personaje':

                $character = new Model_personaje();
                $character->name = Input::Post ('name');
                $character->color = Input::Post ('color');
                $character->resistencia = Input::Post ('resistencia');
                $character->vida = Input::Post ('vida');
                $character->save();

                $article->id_personaje = $character['id'];
                $article->cantidad = Input::Post ('cantidad');
                $article->save();
                return $this->response(array($character['name'] => 'cread@ con exito'));

                break;

            ///
            case 'municion':

                $ammo = new Model_municion();
                $ammo->velocidad = Input::Post ('velocidad');
                $ammo->recarga = Input::Post ('recarga');
                $ammo->daño = Input::Post ('daño');
                $ammo->save();

                $article->id_municion = $ammo['id'];
                $article->cantidad = Input::Post ('cantidad');
                $article->save();
                return $this->response('Municion adherida con exito');

                break;

            ///
            case 'vida':

                $life = new Model_vida();
                $life->cantidad = Input::Post ('cantidad');
                $life->save();

                $article->id_vida = $life['id'];
                $article->cantidad = Input::Post ('cantidad');
                $article->save();
                return $this->response('Vida adherida con exito');

                break;


            default:
                # code...
                break;
        }



    }

    //Funcion de ADMIN para listar todos los ITEMS que poseen todos los usuarios
    public function get_userItem()
    {

        $verificacion = $this->get_userVerify();

            if ($verificacion == true ) // Si verificiación es positiva
            {

                $item_data = Model_items::find('all'); // Hacemos return a todos los Items
                return $item_data;

            }
            else
            {

               return $this->codeInfo($code = 404, $mensaje = 'Nada encontrado, revise los datos introducidos o vuelva a intentarlo');

            }
    }


    // MOSTRAR ITEM POR ID AQUIIIIIIIIII HEMOS COPIADO MAL Y TENEMOS QUE HACERLO FUNCIONAAAAAAAAAAR!!!!!!!!!!!!!!!!!! ------- ////////
    public function post_userItemById($id) //Recibo mandando datos con el id de la funcion que es el id que introducimos en postman
    {

        $verificacion = $this->get_userVerify();


        if ($verificacion == true )
        {
            $compra = Model_compra::find('all');
            $user = Model_users2::find('all');
            $players = Model_player::find('all');
            $item = Model_items::find('all');
            $character = Model_personaje::find('all');
            $mina = Model_minas::find('all');
            $granada = Model_granadas::find('all');
            $vida = Model_vida::find('all');
            $muni = Model_municion::find('all');
            $dlc = Model_personaje::find('all');
            $array = [];
            $name = "";

            if ($id != null){
               
                foreach ($user as $key) {

                    if($key['id'] == $id)
                    {
                        
                         $name = $key;
                         $id = $key['id_jugador'];
                    }
                }
            }else{
                return $this->codeInfo($code = 404, $mensaje = 'No existe Item con la Id seleccionada, elije mejor...');

            }

            foreach ($compra as $key ) {
                
                if($id == $key['id_jugador']){
                    foreach ($item as $items)
                    {

                        if ($items['id'] != null && $items['id'] == $key['id_item'] )
                        {

                            if($items['id_personaje'] != null)
                            {
                                    foreach ($character as $characters)
                                    {
                                        if($items['id_personaje'] == $characters['id'])
                                        {
                                            array_push($array, $characters);
                                        }
                                    }
                            }
                            if($items['id_municion'] != null)
                            {
                                    foreach ($muni as $municion)
                                    {
                                        if($items['id_municion'] == $municion['id'])
                                        {
                                            array_push($array, $municion);
                                        }
                                    }
                            }
                            if($items['id_DLC'] != null)
                            {
                                    foreach ($dlc as $dl)
                                    {
                                        if($items['id_DLC'] == $dl['id'])
                                        {
                                            array_push($array, $dl);
                                        }
                                    }
                            }
                            if($items['id_granada'] != null)
                            {
                                    foreach ($granada as $grana)
                                    {
                                        if($items['id_granada'] == $grana['id'])
                                        {
                                            array_push($array, $grana);
                                        }
                                    }
                            }
                            if($items['id_mina'] != null)
                            {

                                    foreach ($mina as $min)
                                    { 
                                        if($items['id_mina'] == $min['id'])
                                        { 
                                            array_push($array, $min);
                                        }
                                    }
                            }
                            if($items['id_vida'] != null)
                            {
                                    foreach ($vida as $vid)
                                    {
                                        if($items['id_vida'] == $vid['id'])
                                        {
                                            array_push($array, $vid);
                                            
                                        }
                                    }
                            }


                         }
                         else
                         {

                            // if ( $items['id'] == $id )
                            //     {

                            //             return $this->response(array($users));
                            //     }

                         }
                     }

                 }
            }     

            
             // SI EL ID NO CORRESPONDE A NINGÚN JUGADOR O USUARIO DEVUELVE ESTE MENSAJE:
            //return $this->codeInfo($code = 404, $mensaje = 'No existe Item con la Id seleccionada, elije mejor...');

        }

        else // Este else es la auteficacion del token que verifica si lo envias o no
        {

            return $this->codeInfo($code = 403, $mensaje = 'Error en verificacion sesion');
        }
        return $this->response(array("User"=>$name,"items"=>$array));

    }


     // MODIFICAMOS UN USUARIO POR SU ID INDIVIDUALMENTE
    public function post_update($id)
    {

        $verificacion = $this->get_userVerify();


        if ($verificacion == true )
        {

            $guardarItem = Input::post("cantidad");
            $guardarType = Input::post("type");
            $guardarIDType = Input::post("id_type");



$item = Model_items::find('all', array(
            'where' => array(
                array('id', $id))));


            if ( $guardarItem == null or $guardarType == null or $guardarIDType == null )
            {

                return $this->codeInfo($code = 406, $mensaje = 'Error, algun campo esta vacio');

            }
            else
            {

                if($item!=null)
                {

                switch ($guardarType)
                {

            ///
                case 'granada':
                        $item[$id]->set(array(        // POR QUE EL EL INDEX DEL ARRAY ES EL 4?
                            'cantidad'  => $guardarItem,
                            'id_granada' => $guardarIDType,
                            'id_personaje'=> null,
                            'id_vida'=> null,
                            'id_municion'=> null,
                            'id_mina'=>null,

                         ));

                    $item[$id]->save();

                    break;

                ///
                case 'mina':
                        $item[$id]->set(array(        // POR QUE EL EL INDEX DEL ARRAY ES EL 4?
                            'cantidad'  => $guardarItem,
                            'id_mina' => $guardarIDType,
                            'id_personaje'=> null,
                            'id_vida'=> null,
                            'id_municion'=> null,
                            'id_granada'=>null,

                         ));

                    $item[$id]->save();

                    break;

                ///
                case 'personaje':

                        $item[$id]->set(array(        // POR QUE EL EL INDEX DEL ARRAY ES EL 4?
                            'cantidad'  => $guardarItem,
                            'id_personaje' => $guardarIDType,
                            'id_granada'=> null,
                            'id_vida'=> null,
                            'id_municion'=> null,
                            'id_mina'=>null,

                         ));

                    $item[$id]->save();

                    break;

                ///
                case 'municion':
                    $item[$id]->set(array(        // POR QUE EL EL INDEX DEL ARRAY ES EL 4?
                            'cantidad'  => $guardarItem,
                            'id_municion' => $guardarIDType,
                            'id_personaje'=> null,
                            'id_vida'=> null,
                            'id_granada'=> null,
                            'id_mina'=>null,

                         ));

                    $item[$id]->save();


                    break;

                ///
                case 'vida':
                    $item[$id]->set(array(        // POR QUE EL EL INDEX DEL ARRAY ES EL 4?
                            'cantidad'  => $guardarItem,
                            'id_vida' => $guardarIDType,
                            'id_personaje'=> null,
                            'id_granada'=> null,
                            'id_municion'=> null,
                            'id_mina'=>null,

                         ));

                    $item[$id]->save();

                    break;


                default:
                    # code...
                    break;
            }



                    return $this->codeInfo($code = 200, $mensaje = 'update con exito');;

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

    // Funcion para Borrar individualmente por Id un item
    public function post_delete($id)
    {

        $items = Model_Items::find('all', array('where' => array(array('id', $id))));
        $verificacion = $this->get_userVerify();
        //var_dump($verificacion);

        if ($verificacion == true )
        {

            if($items!=null)
            {

                $items[$id]->delete();


                return [$this->codeInfo($code = 200, $mensaje = 'Exito, item borrado')];

            }
            else
            {

                return $this->codeInfo($code = 404, $mensaje = 'No existe item con tal ID');
            }
        }
        else
        {

            return $this->codeInfo($code = 403, $mensaje = 'Error verificacion de sesion');
        }

    }

    // FUNCIÓN PARA COMPRAR ITEMS
    public function post_compra()
    {

       $compra = new Model_compra();
       $items =   Model_items::find('all');
       $users =  Model_player::find('all');

       $comprador = input::post ('userid');
       $objeto = input::post ('itemid');

       foreach ($users as $user)
       {
           if ($user['id'] == $comprador)
           {

                $compra->id_jugador = $comprador;
           }
       }
       foreach ($items as $item){

           if ($item['id'] == $objeto)
           {

                $compra->id_item = $objeto;
           }
       }

       if ($compra->id_item != null && $compra->id_jugador !=null)
       {

            $compra->save();
            return $this->response('compra con exito');
        }
        else
        {
            return $this->response('compra fallida');

        }

    }







}
