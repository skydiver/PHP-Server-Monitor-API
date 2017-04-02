<?php

    use Illuminate\Database\Capsule\Manager as DB;

    trait UptimeTrait {

        /**
         * Get Server's Uptime by Server ID
         * @param type $server_id
         * @param type $HoursUnit
         * @return boolean
         */
        public function getServerUptime($server_id, $HoursUnit) {

            if($HoursUnit <= 1) {

                $uptime = ServerUptime::select('servers_uptime_id', 'server_id', 'date', 'status', 'latency')
                    ->where('date', '>=', DB::raw('(NOW() - INTERVAL ' . $HoursUnit . ' HOUR)'))
                    ->where('server_id', $server_id)
                    ->get();

            } else {

                $uptime = ServerUptime::select('servers_uptime_id', 'server_id', 'date', 'status', DB::raw('AVG(latency) as latency'))
                    ->where('date', '>=', DB::raw('(NOW() - INTERVAL ' . $HoursUnit . ' HOUR)'))
                    ->where('server_id', $server_id)
                    ->groupBy(DB::raw('DATE(date)'))
                    ->groupBy(DB::raw('HOUR(date)'))
                    ->get();

            }

            return $uptime;

        }

    }

?>