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
            $SQL = "SELECT COUNT(a.server_id) as servercount, count(if(a.status = 'on', a.status, NULL))
                    AS statusoncount, count(if(a.status = 'off', a.status, NULL))
                    AS statusoffcount, count(if(a.active = 'no', a.active, NULL))
                    AS activecount, count(if(a.email = 'yes', a.email, NULL))
                    AS emailalertcount, b.server_id, b.user_id
                    FROM " . PSM_DB_PREFIX . "servers a, " . PSM_DB_PREFIX . "users_servers b
                    WHERE b.user_id='" . $user_id . "' AND a.server_id=b.server_id";
            $res  = $this->db->prepare($SQL);
            $res->execute();
            return $res->fetch(PDO::FETCH_ASSOC);
        }

        /**
         *  Get Server's Details
         * @param type $server_id
         * @return boolean
         */
        public function getServer($server_id) {
            $SQL  = "SELECT * FROM " . PSM_DB_PREFIX . "servers WHERE server_id = '" . $server_id . "'";
            $res  = $this->db->prepare($SQL);
            $res->execute();
            return $res->fetch(PDO::FETCH_ASSOC);
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

            $SQL = "DELETE FROM " . PSM_DB_PREFIX . "servers WHERE server_id = '" . $server_id . "'";
            $res  = $this->db->prepare($SQL);
            $res->execute();

            if($res->rowCount() > 0) {
                $SQL2  = "DELETE FROM " . PSM_DB_PREFIX . "users_servers  WHERE server_id = '" . $server_id . "';";
                $SQL2 .= "DELETE FROM " . PSM_DB_PREFIX . "servers_uptime WHERE server_id = '" . $server_id . "';";
                $SQL2 .= "DELETE FROM " . PSM_DB_PREFIX . "log            WHERE server_id = '" . $server_id . "';";
                $res2  = $this->db->prepare($SQL2);
                return $res2->execute();
            }

             return false;

        }

         /*
         * Check Server ID existed or not*
         * @param type $server_id
         * @return boolean
         */
        public function isServerIDExisted($server_id) {
            return Server::select('server_id')->where('server_id', $server_id)->first();
        }

    }

?>