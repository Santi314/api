<?php

Class Model_conseguidos extends Orm\Model
{

    protected static $_table_name = 'logros_conseguidos';
    protected static $_primary_key = array('id');

    protected static $_properties = array(

        'id',

        'id_logro' => array(

            'data_type' => 'int',
            'validation' => array('required')

         ),


        'id_jugador' => array(

            'data_type' => 'int',
            'validation' => array('required')


        ),

        

     );




}
