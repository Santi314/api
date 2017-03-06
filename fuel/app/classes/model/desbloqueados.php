<?php

class Model_desbloqueados extends Orm\Model
{

    protected static $_table_name = 'desbloquea';
    protected static $_primary_key = array('id_jugador','id_nivel');

    protected static $_properties = array(

       

        'id_jugador' => array(

            'data_type' => 'int',
            'validation' => array('required')

         ),
        'id_nivel' => array(

            'data_type' => 'int',
            'validation' => array('required')

         ),

     );


}