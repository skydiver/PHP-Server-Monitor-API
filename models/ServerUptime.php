<?php

    use Illuminate\Database\Eloquent\Model as Eloquent;

    class ServerUptime extends Eloquent {

        protected $table = 'servers_uptime';
        
        public $timestamps = false;

    }

?>