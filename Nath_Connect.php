<?php
/**
 * PHP Server Monitor API for Web, IOS or Android 
 * Monitor your servers and websites.
 *
 * This file is part of PHP Server Monitor API.
 * PHP Server Monitor is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP Server Monitor is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP Server Monitor.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     ServerAlarmsAPI
 * @author      Asuk Nath <support@serveralarms.com>
 * @copyright   Copyright (c) 2016 Asuk Nath <support@serveralarms.com>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v1.0
 * @link        https://www.serveralarms.com/
 **/
 
    class DB_Connect {

        public function connect() {
            require_once ('../config.php');
            $con = new PDO('mysql:host='.PSM_DB_HOST.';dbname='.PSM_DB_NAME, PSM_DB_USER, PSM_DB_PASS);
            return $con;
        }

    }

?>