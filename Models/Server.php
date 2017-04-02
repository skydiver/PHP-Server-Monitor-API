<?php

    use Illuminate\Database\Eloquent\Model as Eloquent;

    class Server extends Eloquent {

        protected $primaryKey = 'server_id';

        public $timestamps = false;

    }

?>