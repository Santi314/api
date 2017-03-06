<?php

// ACCEDEMOS A LA TABLA JUGADORES CON ESTE MODELO, SOLICITAMOS TRABAJAR CON SU ID ALIAS Y SCORE PARA LUEGO EN EL CONTROLADOR AHCER FUNCIONALIDADES
class Model_player extends Orm\Model
{

    protected static $_table_name = 'jugadores';
    protected static $_primary_key = array('id');

    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK

        'alias' => array(
            'data_type' => 'varchar',
            'validation' => array('required'),

        ),

        'score' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),


    );

}
