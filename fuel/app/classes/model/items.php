<?php

class Model_Items extends Orm\Model
{

    protected static $_table_name = 'items';
    protected static $_primary_key = array('id');

    protected static $_properties = array(

        'id',

        'id_personaje' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),

        'id_municion' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),

        'id_DLC' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),

        'id_granada' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),

        'id_mina' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),

        'id_buff' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),

        'id_vida' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),

        'cantidad' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),

    );
}
