<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_favorites extends CI_Migration {

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
            'user' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'commerce_id' => array(
                'type' => 'INT',
                'constraint' => 12,
                'null' => FALSE
            )
        );

        $this->dbforge->add_field($table);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('favorites', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('favorites', TRUE);
    }
}
