<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_items extends CI_Migration {

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
            'letter' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => FALSE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            )
        );

        $this->dbforge->add_field($table);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('items', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('items', TRUE);
    }
}
