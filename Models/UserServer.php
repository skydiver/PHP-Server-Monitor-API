<?php

    use Illuminate\Database\Eloquent\Model as Eloquent;

    class UserServer extends Eloquent {

        protected $table = 'users_servers';

        public $timestamps = false;

    }

?>