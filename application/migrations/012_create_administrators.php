<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_administrators extends CI_Migration {

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
            'city' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'province' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'country' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'active_account' => array(
                'type' => 'BOOLEAN'
            ),
            'last_session' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            )
        );

        $this->dbforge->add_field($table);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('administrators', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('administrators', TRUE);
    }
}
