<?php

Class Model_granadas extends Orm\Model
{

    protected static $_table_name = 'granadas';
    protected static $_primary_key = array('id');

    protected static $_properties = array(

        'id',

        'name' => array(

            'data_type' => 'varchar',
            'validation' => array('required')

         ),


        'daño' => array(

            'data_type' => 'int',
            'validation' => array('required')


        ),

        'alcance' => array(

            'data_type' => 'int',
            'validation' => array('required')

            ),



     );




}
