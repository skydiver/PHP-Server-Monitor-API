<?php

    use Illuminate\Database\Capsule\Manager as DB;

    trait ServersTrait {
    
        /**
         * Get User's Servers List by User ID
         * @param type $user_id
         * @return boolean
         */
        public function getServerlistbyUserID($user_id) {
            $servers = DB::table('servers AS a')
                ->select(['a.server_id', 'a.ip', 'a.port', 'a.label', 'a.type', 'a.status', 'a.last_online', 'a.last_check', 'a.active','a.email', 'a.pushover', 'a.warning_threshold', 'a.warning_threshold_counter', 'b.user_id'])
                ->join('users_servers AS b', 'b.server_id', '=', 'a.server_id')
                ->get();
            return $servers;
        }

        /**
         * Get Monitoring Dashboard
         * @param type $user_id
         * @return boolean
         */
        public function getMonitorStatusByUserID($user_id) {
            return DB::table('servers AS a')
                ->select('b.server_id', 'b.user_id')
                ->selectRaw(sprintf('COUNT(%sa.server_id) as servercount', DB::getTablePrefix()))
                ->selectRaw(sprintf('COUNT(if(%1$sa.status = "on" , %1$sa.status, NULL)) AS statusoncount'  , DB::getTablePrefix()))
                ->selectRaw(sprintf('COUNT(if(%1$sa.status = "off", %1$sa.status, NULL)) AS statusoffcount' , DB::getTablePrefix()))
                ->selectRaw(sprintf('COUNT(if(%1$sa.active = "no" , %1$sa.active, NULL)) AS activecount'    , DB::getTablePrefix()))
                ->selectRaw(sprintf('COUNT(if(%1$sa.email  = "yes", %1$sa.email , NULL)) AS emailalertcount', DB::getTablePrefix()))
                ->join('users_servers AS b', 'b.server_id', '=', 'a.server_id')
                ->where('b.user_id', $user_id)
                ->get();
        }

        /**
         *  Get Server's Details
         * @param type $server_id
         * @return boolean
         */
        public function getServer($server_id) {
            return Server::find($server_id);
        }

        /**
         * Add Server to Monitor
         * @param type $user_id
         * @param type $ip
         * @param type $port
         * @param type $label
         * @param type $type
         * @param type $status
         * @param type $active
         * @param type $emailalert
         * @param type $warning_threshold
         * @param type $timeout
         * @return boolean
         */
        public function addservertoMonitor($user_id, $ip, $port, $label, $type, $status, $active, $emailalert, $warning_threshold, $timeout) {

            $server = new Server;
            $server->ip                = $ip;
            $server->port              = $port;
            $server->label             = $label;
            $server->type              = $type;
            $server->status            = $status;
            $server->active            = $active;
            $server->email             = $emailalert;
            $server->warning_threshold = $warning_threshold;
            $server->timeout           = $timeout;
            $server->save();
             
            $user_server = new UserServer;
            $user_server->user_id    = $user_id;
            $user_server->server_id = $server->id;
            $user_server->save();
            
            return $user_server;
            
        }

        /**
         * Update Server to Monitor
         * @param type $user_id
         * @param type $ip
         * @param type $port
         * @param type $label
         * @param type $type
         * @param type $status
         * @param type $active
         * @param type $emailalert
         * @param type $warning_threshold
         * @param type $timeout
         * @param type $server_id
         * @return boolean
         */
         public function updateservertoMonitor($user_id, $ip, $port, $label, $type, $status, $active, $emailalert, $warning_threshold, $timeout, $server_id) {
            $server = Server::find($server_id);
            $server->ip                = $ip;
            $server->port              = $port;
            $server->label             = $label;
            $server->type              = $type;
            $server->status            = $status;
            $server->active            = $active;
            $server->email             = $emailalert;
            $server->warning_threshold = $warning_threshold;
            $server->timeout           = $timeout;
            $server->save();
            return $server;
        }

        /**
         * Delete Server to Monitor
         * @param type $server_id
         * @return boolean
         */
        public function deleteservertoMonitor($server_id) {
            $server = Server::find($server_id);
            if($server) {
                $server->delete();
                return true;
            }
            return false;
        }

        /**
         * Check Server ID existed or not*
         * @param type $server_id
         * @return boolean
         */
        public function isServerIDExisted($server_id) {
            return Server::select('server_id')->where('server_id', $server_id)->first();
        }

    }

?>