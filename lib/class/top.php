<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2013 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

/**
 * Top Class
 *
 * Static class to hold functions for getting top tracks, top artists etc
 *
 */

require_once Config::get('prefix') . '/modules/httpful/httpful.phar';
require_once Config::get('prefix') . '/lib/class/top_result.php';

class Top {

    public function __construct() {
    }

    private static function build_top_url($type, $count, $start_date, $end_date){
        $top_url = '';

        $base_url = Config::get('top50_rest_server');

        if (!empty($base_url)){
            //error_log('Top50 REST server: '.$base_url, 0);

            switch($type){
            case 'song':
                $ctx = '/top-songs';
                break;
            case 'artist':
                $ctx = '/top-artists';
                break;
            case 'album':
                $ctx = '/top-albums';
                break;
            }

            $format_str = "Y-n-j";

            $start_date_str = date($format_str, $start_date); 
            $end_date_str = date($format_str, $end_date); 

            //error_log("Start date: ".$start_date_str);
            //error_log("End date: ".$end_date_str);

            $top_url = $base_url.$ctx."?num=".$count."&start=".$start_date_str."&end=".$end_date_str;

            //error_log("Top URL: ".$top_url);
        }

        return $top_url;
    }

    public static function get_top_service_enabled(){
        $base_url = Config::get('top50_rest_server');

        return (!empty($base_url));
    }

    public static function get_top_results($type, $count, $start_date, $end_date){
        $results = array();

        $top50_url = Top::build_top_url($type, $count, $start_date, $end_date);

        $response = \Httpful\Request::get($top50_url)->send();
        //error_log('Response: '.$response);
        foreach($response->body->result as $result){
            $tresult = new TopResult($result->id, $type, $result->count);
            error_log("TResult: ".$tresult->object_id.",".$tresult->object_type.",".$tresult->count);
            $results[] = $tresult;
        }

        return $results;
    }

    public static function get_top($type, $count, $start_date, $end_date){
        $results = array();
        $tresults = Top::get_top_results($type, $count, $start_date, $end_date);

        foreach($tresults as $tresult){
            $results[] = $tresult->object_id;
        }

        return $results;
    }
}

?>
