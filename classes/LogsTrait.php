<?php

    trait LogsTrait {

        /**
         * Get Server's Logs by Server ID
         * @param type $server_id
         * @param type $days
         * @return boolean
         */
        public function getServerLogs($server_id, $days) {
            $SQL  = "SELECT type, message, datetime
                     FROM " . PSM_DB_PREFIX . "log
                     WHERE DATE(datetime) > (NOW() - INTERVAL '" . $days . "' DAY) AND (server_id='" . $server_id . "' AND type='status')";
            $res  = $this->db->prepare($SQL);
            $res->execute();
            return $res->fetchAll(PDO::FETCH_ASSOC);
        }

    }

?>