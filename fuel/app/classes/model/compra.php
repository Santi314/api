<?php

class Model_compra extends Orm\Model
{

    protected static $_table_name = 'compra';
    protected static $_primary_key = array('id');

    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK

        'id_jugador' => array(
            'data_type' => 'int',
            'validation' => array('required'),

        ),

        'id_item' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),
    );

}
