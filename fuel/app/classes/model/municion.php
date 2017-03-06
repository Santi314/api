<?php

Class Model_municion extends Orm\Model
{

    protected static $_table_name = 'municion';
    protected static $_primary_key = array('id'); // ESTABLECEMOS CUAL ES SU ID PRIMARIA

    protected static $_properties = array(

        'id',

        'velocidad' => array(

            'data_type' => 'varchar',
            'validation' => array('required')

         ),


        'recarga' => array(

            'data_type' => 'int',
            'validation' => array('required')


        ),

        'daño' => array(

            'data_type' => 'int',
            'validation' => array('required')

            ),



     );




}
