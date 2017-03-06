<?php

class Model_personaje extends Orm\Model
{

    protected static $_table_name = 'personaje';
    protected static $_primary_key = array('id');

    protected static $_properties = array(

        'id',

        'name' => array(
            'data_type' => 'varchar',
            'validation' => array('required'),

        ),

        'color' => array(
            'data_type' => 'varchar',
            'validation' => array('required'),

        ),

        'resistencia' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),
        'vida' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),
    );

}
