<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_businesses extends CI_Migration {

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
            'address' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'latitude' => array(
                'type' => 'DOUBLE',
                'null' => FALSE
            ),
            'longitude' => array(
                'type' => 'DOUBLE',
                'null' => FALSE
            ),
            'city' => array(
                'type' => 'VARCHAR',
                'constraint' => 80
            ),
            'province' => array(
                'type' => 'VARCHAR',
                'constraint' => 80
            ),
            'country' => array(
                'type' => 'VARCHAR',
                'constraint' => 80
            )
        );

        $this->dbforge->add_field($table);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('businesses', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('businesses', TRUE);
    }
}
