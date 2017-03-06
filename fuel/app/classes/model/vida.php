<?php

class Model_vida extends Orm\Model
{

    protected static $_table_name = 'vidas';
    protected static $_primary_key = array('id');

    protected static $_properties = array(

        'id',

        'cantidad' => array(
            'data_type' => 'int',
            'validation' => array('required'))


    );
}
