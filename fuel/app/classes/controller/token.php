 <?php

use \Firebase\JWT\JWT;

class Controller_token extends Controller_Rest
{

    private $key = "cev516";



    public function codeInfo($code, $mensaje)  // Con esta funcion se accede a los Errores y no con Error Auth!
    {

        return [ 'code' => $code,'mensaje' => $mensaje ];

    }


    /*
    public function codeInfo2($code) {    //1XX = ERRORES INTERNOS TOKEN
                                         //2XX = ERRORES ENVIO DE DATOS DEL CLIENTE
        if ( $code == 400 ) {

            $mensaje = "Faltan campos por rellenar";
        }
        else if ( $code == 401  ) {

            $mensaje = "Error en login (user/pass incorrectos) o campos vacios";
        }
        else if ( $code == 402 ) {

            $mensaje = "Error, user ya registrado";
        }
        else if ( $code == 403 ) {

            $mensaje = "Error en verificacion de sesion";
        }
        else if ( $code == 500 ) {

            $mensaje = "Error interno, parametro auth no enviado";
        }
        else if ( $code == 300 ) {

            $mensaje = "Exito, Usuario registrado";
        }
        else if ( $code == 404) {

            $mensaje = "ID no corresponde a ningun user";
        }
        else if  ($code == 11) {

            $mensaje = "Exito, token generado";
        }
        else if  ($code == 12) {

            $mensaje = "Exito, usuario borrado";
        }






        return [

        "Code: " => $code,
        "Mensaje: " => $mensaje ];


    }





    public function errorAuth() {

        $error = 'ERROR, usuario no introducido o datos incorrectos';

        return  [

        $error

        ];
    }
    */

    // Funcion que gestiona la verificacion de los datos de usuario, recibiendo el token del header

    public function get_userVerify() {




        $header = apache_request_headers();




                try{    //Evita que salte error en caso de no mandar niguna cabecera de Auth
                $jwt = $header["auth"];
                }catch(exception $e){

                     //return $this->codeInfo($code = 599, $mensaje = 'Parametro auth no pasado');


                     return false;  //AQUI HABRIA QUE PONER ERROR 500 PERO NO LO MUESTRA



                }


                //var_dump($jwt);
                try{
                $decoded = JWT::decode($jwt, $this->key, array('HS256'));
                }catch(exception $e){



                    return false;
                      //TOKEN INCORRECTO

                }
                $token = (array)$decoded;

                $verificacion = Model_Users2::find('all');
                foreach ($verificacion as $user) {
                    if($user['username'] == $token['username'] && $user['password'] == $token['password']){
                        print($user['username']);
                        return true;
                    }
                }

                return false;





    }


    // FUNCION QUE COMPRUEBA DATOS DE ACCESO CON LOS DE LA BBDD Y GENERA TOKEN
    public function post_login()
    {

        //Var que guarda una clave necesaria para que funcione el encode
        //$key = 'cev516';

        //Variable que guarda el username extraido de la BBDD segun los datos pasados por post
        $user = Model_users2::find('all', array(
                'where' => array(
                    array('username', Input::post('username')),
                    )
                ));

        //VERIFICACION DE DE ENVIO DE DATOS: Si mediante post mandamos usuario, con foreach recorremos los campoos de id, username y pass y los guardamos en variables.

        if ( ! empty($user) )
        {

            foreach ($user as $verif => $value)
            {
                $id = $user[$verif]->id;
                $username = $user[$verif]->username;
                $password = $user[$verif]->password;
            }

        }
        //Si no enviamos ningun dato de usuario, generamos error
        else
        {
            return $this->codeInfo($code = 401, $mensaje = 'Error en login (user/pass incorrectos) o campos vacios');  //ERROR INTERNO
        }


        //VERIFICACION DE DATOS VALIDOS:

        //Si user y pass son iguales a los introducidos por el cliente mediante post
        if ($username == Input::post('username') and $password == Input::post('password'))
        {
            //Generamos el token que sera un array con los 3 datos
            $token = array(
                "id" => $id,
                "username" => $username,
                "password" => $password
            );
            //Codificacion del token utilizando dependencia JWT

            $jwt = JWT::encode($token, $this->key);

            //Return de codigo 200 y del token generado con el encode:
            return [

                $this->codeInfo($code = 11, $mensaje = 'Exito, token generado'),
                'token' => $jwt

            ];
        }

        //Si user y pass enviados por el cliente no coinciden con BBDD:
        else {

            return $this->codeInfo($code = 401, $mensaje = 'Error en login (user/pass incorrectos) o campos vacios'); //ERROR USER o PASS ERRONEOS
        }
    }

}
