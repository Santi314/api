<?php

class Model_users2 extends Orm\Model //Este modelo coge la información directamente de la base de datos la tabla usuarios
{

    protected static $_table_name = 'usuarios';
    protected static $_primary_key = array('id');

    protected static $_properties = array(
        'id', // both validation & typing observers will ignore the PK

        'username' => array(
            'data_type' => 'varchar',
            'validation' => array('required'), // ESTO REQUIERE QUE SEA OBLIGATORIO LLENAR ESTE CAMPO, EN CASO DE NO LLENARLO DA ERROR

        ),

        'password' => array(
            'data_type' => 'varchar',
            'validation' => array('required')

        ),

        'email' => array(
            'data_type' => 'varchar',
            'validation' => array('required')

        ),

        'foto' => array(
            'data_type' => 'varchar',
            'validation' => array('required')

        ),
        'id_jugador' => array(
            'data_type' => 'int',
            'validation' => array('required')

        ),
        'id_admin' => array(
            'data_type' => 'varchar',
            'validation' => array('required')

        ),

    );


}
