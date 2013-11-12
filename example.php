<?php
/**
 * License
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * */

/**
 * @author Hernas <kontakt@hernas.pl>
 * @copyright 2008 Hernas.pl.
 * @version 1.2
 */

require_once 'searchWay.class.php';

$aMap = array(
    array(0, 0, 0, 0, 1, 0, 1, 0),
    array(1, 0, 1, 1, 1, 1, 0, 0),
    array(1, 0, 1, 0, 0, 1, 0, 1),
    array(0, 0, 0, 0, 0, 0, 0, 1),
    array(0, 0, 0, 1, 1, 1, 1, 1),
    array(0, 1, 0, 0, 0, 0, 0, 0),
    array(1, 1, 0, 0, 0, 1, 0, 0),
    array(1, 1, 0, 1, 1, 1, 0, 0),
);

$oWay = new Way(7, 7, $aMap);
$way = $oWay->findWay(7, 0);
echo '<pre>';
print_r($way);
echo '</pre>';
$oWay->createMap(); // View of map and way
?>
