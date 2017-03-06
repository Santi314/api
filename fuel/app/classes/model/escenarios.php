<?php

class Model_escenarios extends Orm\Model
{

    protected static $_table_name = 'escena';
    protected static $_primary_key = array('id');

    protected static $_properties = array(

        'id',

        'nombre' => array(

            'data_type' => 'varchar',
            'validation' => array('required')

         ),

        'descripcion' => array(

            'data_type' => 'varchar',
            

         ),

        'imagen' => array(

            'data_type' => 'varchar',
           

         ),

     );


}