<?php

class Migrate extends CI_Controller {
    
    /**
    * Ejecuta las migraciones de las clases ubicadas en /application/migrations
    *
    * Se puede configurar las migraciones en el archivo ubicado en
    *  /application/config/migration.php
    */
    public function run()
    {
        $this->load->library('migration');

        if (!$this->migration->current()) {
            show_error($this->migration->error_string());
        } else {
            $info["status"] = "La migracion se realizo correctamente";
            $info["latest"] = $this->migration->latest();
            echo json_encode($info);
        }
    }
}
