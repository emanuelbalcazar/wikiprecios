<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_categories extends CI_Migration {

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
            'item_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'null' => FALSE
            ),
            'category' => array(
                'type' => 'VARCHAR',
                'constraint' => 50
            ),
            'special_product_code' => array(
                'type' => 'VARCHAR',
                'constraint' => 30
            ),
            'unit' => array(
                'type' => 'VARCHAR',
                'constraint' => 10
            )
        );

        $this->dbforge->add_field($table);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('categories', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('categories', TRUE);
    }
}
