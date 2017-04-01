<?php

    trait UptimeTrait {

        /**
         * Get Server's Uptime by Server ID
         * @param type $server_id
         * @param type $HoursUnit
         * @return boolean
         */
        public function getServerUptime($server_id, $HoursUnit) {

            if($HoursUnit <= 1){
                $SQL = "SELECT servers_uptime_id, server_id, date, status, latency
                        FROM " . PSM_DB_PREFIX . "servers_uptime
                        WHERE date >=(NOW() - INTERVAL '" . $HoursUnit . "' HOUR) AND (server_id='" . $server_id . "')";
            } else {               
                $SQL = "SELECT servers_uptime_id, server_id, date, status, AVG(latency) as latency
                        FROM " . PSM_DB_PREFIX . "servers_uptime
                        WHERE date >=(NOW() - INTERVAL '" . $HoursUnit . "' HOUR) AND (server_id='" . $server_id . "')
                        GROUP BY DATE(date), HOUR(date)";
            }

            $res  = $this->db->prepare($SQL);
            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);

        }

    }

?>