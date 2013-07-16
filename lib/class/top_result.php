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
 * TopResult Class
 *
 * Class to hold the result of a "top tracks" search
 * Consists of an object_id, an object_type and a count
 *
 */

class TopResult {
    var $object_id;
    var $object_type;
    var $count;

    public function __construct($object_id, $object_type, $count) {
        $this->object_id = $object_id;
        $this->object_type = $object_type;
        $this->count = $count;
    }

}

?>
