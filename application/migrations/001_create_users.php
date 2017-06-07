<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_users extends CI_Migration {

    public function up()
    {
        $table = array (
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'constraint' => 12,
                'auto_increment' => TRUE,
                'null' => FALSE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'surname' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'mail' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => FALSE
            ),
            'qualification' => array(
                'type' => 'INT',
                'constraint' => 5,
                'null' => FALSE
            ),
            'accumulated' => array(
                'type' => 'INT',
                'constraint' => 5,
                'null' => FALSE
            ),
            'active_account' => array(
                'type' => 'BOOLEAN'
            )
        );

        $this->dbforge->add_field($table);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('users', TRUE);
    }
}
