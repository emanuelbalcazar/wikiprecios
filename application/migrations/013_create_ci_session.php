<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_ci_session extends CI_Migration {

    public function up()
    {
        $table = array (
            'id' => array(
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => FALSE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'timestamp' => array(
                'type' => 'INT',
                'constraint' => 15,
                'null' => FALSE
            ),
            'user_agent' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ),
            'last_activity' => array(
                'type' => 'INT',
                'constraint' => 30,
                'null' => FALSE
            ),
            'data' => array(
                'type' => 'BLOB',
                'null' => FALSE
            )
        );

        $this->dbforge->add_field($table);
        $this->dbforge->add_key('session_id', TRUE);
        $this->dbforge->create_table('ci_sessions', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('ci_sessions', TRUE);
    }
}
