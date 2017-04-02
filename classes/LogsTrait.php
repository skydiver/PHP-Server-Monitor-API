<?php

    use Illuminate\Database\Capsule\Manager as DB;

    trait LogsTrait {

        /**
         * Get Server's Logs by Server ID
         * @param type $server_id
         * @param type $days
         * @return boolean
         */
        public function getServerLogs($server_id, $days) {
            return Log::select('type', 'message', 'datetime')
                ->where(DB::raw('DATE(datetime)'), '>', DB::raw('(NOW() - INTERVAL ' . $days . ' DAY)'))
                ->where('server_id', $server_id)
                ->get();            
        }

    }

?>