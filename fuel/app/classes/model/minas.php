<?php

class Model_minas extends Orm\Model
{

    protected static $_table_name = 'minas';
    protected static $_primary_key = array('id');

    protected static $_properties = array(
        'id',

        'name' => array(
            'data_type' => 'varchar',
            'validation' => array('required'),

        ),

        'daño' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),
        'radio' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),
    );

}
