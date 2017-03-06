<?php 
namespace Fuel\Migrations;

class Usuarios
{

    function up()
    {
        \DBUtil::create_table('usuarios', array(

            'id' => array('type' => 'int', 'constraint' => 5, 'auto_increment' => true),
            'username' => array('type' => 'varchar', 'constraint' => 10),
            'email' => array('type' => 'varchar', 'constraint' => 30),
            'password' => array('type' => 'varchar', 'constraint' => 20),
            'foto' => array('type' => 'varchar', 'constraint' => 255),
            'id_jugador' => array('type' => 'int', 'constraint' => 10),
            'id_admin' => array('type' => 'int', 'constraint' => 10),
            ),
            array('id')


        );
        
        \DB::query("ALTER TABLE `usuarios` ADD UNIQUE( `email`);")->execute();


    }

    function down()
    {
       \DBUtil::drop_table('usuarios');
     

    }

}









