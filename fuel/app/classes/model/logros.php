<?php

class Model_logros extends Orm\Model
{

    protected static $_table_name = 'logro';
    protected static $_primary_key = array('id');

    protected static $_properties = array(

        'id',

        'nombre' => array(

            'data_type' => 'varchar',
            'validation' => array('required')

         ),

     );


}
