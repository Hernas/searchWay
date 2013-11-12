<?php

/**
 * @author Hernas <contact@hern.as>
 * @copyright 2008 Hern.as.
 * @version 1.2
 */
class Way {
    /* Starting X point */

    private $start_x;

    /* Starting Y point */
    private $start_y;

    /* Map given by user */
    private $aMap;

    /* Map generated by class */
    private $aMap_;

    /* Destination X point */
    private $destination_x;

    /* Destination Y point */
    private $destination_y;

    /* Array of ways to search */
    private $aWay = array();

    /* Arrat with final found way */
    private $aWays = array();

    /* Number of next searching step */
    private $fillNumber = 0;

    public function __construct($x, $y, $aMap) {
        $this->aMap = $aMap;

        $this->aWays[] = array($x, $y);
        $this->start_x = $x;
        $this->start_y = $y;

        $this->regenerateMap();
    }

    public function findWay($x, $y, $withAlongSide = true) {
        $this->destination_x = $x;
        $this->destination_y = $y;

        $this->startFinding();
        $this->aWay[] = array($y, $x);
        $this->mirrorFinding($x, $y);
        if ($withAlongSide) {
            $ways = $this->aWay;
            foreach ($ways AS $i => $v) {
                if (isset($ways[$i + 1]) AND $this->checkSidelong($v[1], $v[0], $ways[$i + 1][1], $ways[$i + 1][0])) {
                    $this->researchWay($ways, $i);
                }
            }
        }
        return array_reverse($this->aWay);
    }

    private function checkSidelong($x, $y, $x1, $y1) {
        if (abs($x1 - $x) == 1 AND abs($y1 - $y) == 1) {
            return true;
        }
    }

    private function researchWay($ways, $ii) {
        list($y, $x) = $ways[$ii];
        $new_x[] = $x + 1;
        $new_y[] = $y;

        $new_x[] = $x + 1;
        $new_y[] = $y + 1;

        $new_x[] = $x + 1;
        $new_y[] = $y - 1;

        $new_x[] = $x - 1;
        $new_y[] = $y;

        $new_x[] = $x - 1;
        $new_y[] = $y + 1;

        $new_x[] = $x - 1;
        $new_y[] = $y - 1;

        $new_x[] = $x;
        $new_y[] = $y + 1;

        $new_x[] = $x;
        $new_y[] = $y - 1;

        foreach ($new_x AS $i => $v) {
            list($nextY, $nextX) = $ways[$ii + 1];
            if (isset($this->aMap_[$new_y[$i]][$v]) && $this->aMap_[$new_y[$i]][$v] > 0 && !($new_y[$i] == $nextY && $v == $nextX) && ($this->aMap_[$new_y[$i]][$v] == $this->aMap_[$y][$x] || $this->aMap_[$new_y[$i]][$v] == ($this->aMap_[$y][$x] - 1)) && (abs($v - $nextX) == 1 || abs($v - $nextX) == 0) && (abs($new_y[$i] - $nextY) == 1 || abs($new_y[$i] - $nextY) == 0)) {

                $this->fillArray(array($y, $x), array($new_y[$i], $v));
                break;
            }
        }
    }

    private function mirrorFinding($x, $y) {
        $new_x[] = $x + 1;
        $new_y[] = $y;

        $new_x[] = $x + 1;
        $new_y[] = $y + 1;

        $new_x[] = $x + 1;
        $new_y[] = $y - 1;

        $new_x[] = $x - 1;
        $new_y[] = $y;

        $new_x[] = $x - 1;
        $new_y[] = $y + 1;

        $new_x[] = $x - 1;
        $new_y[] = $y - 1;

        $new_x[] = $x;
        $new_y[] = $y + 1;

        $new_x[] = $x;
        $new_y[] = $y - 1;
        foreach ($new_x AS $i => $v) {
            if (isset($this->aMap_[$new_y[$i]][$v]) AND $this->aMap_[$new_y[$i]][$v] == ($this->aMap_[$y][$x] - 1)) {
                $this->aWay[] = array($new_y[$i], $v);
                $this->mirrorFinding($v, $new_y[$i]);
                break;
            }
        }
    }

    private function getDirFormXY($x, $y, $x1, $y1) {
        if (($x1 - $x) == 1 AND abs($y1 - $y) != 1) {
            return 'right';
        }
        if (($x1 - $x) == -1 AND abs($y1 - $y) != 1) {
            return 'left';
        }
        if (abs($x1 - $x) != 1 AND ($y1 - $y) == -1) {
            return 'up';
        }
        if (abs($x1 - $x) != 1 AND ($y1 - $y) == 1) {
            return 'down';
        }
        if (($x1 - $x) == 1 AND ($y1 - $y) == -1) {
            return 'upright';
        }
        if (($x1 - $x) == 1 AND ($y1 - $y) == 1) {
            return 'downright';
        }
        if (($x1 - $x) == -1 AND ($y1 - $y) == -1) {
            return 'upleft';
        }
        if (($x1 - $x) == -1 AND ($y1 - $y) == 1) {
            return 'downleft';
        }
    }

    private function startFinding() {
        foreach ($this->aWays AS $v) {
            list($x, $y) = $v;
            $this->aMap_[$y][$x] = $this->fillNumber;
            $new_x[] = $x + 1;
            $new_y[] = $y;

            $new_x[] = $x + 1;
            $new_y[] = $y + 1;

            $new_x[] = $x + 1;
            $new_y[] = $y - 1;

            $new_x[] = $x - 1;
            $new_y[] = $y;

            $new_x[] = $x - 1;
            $new_y[] = $y + 1;

            $new_x[] = $x - 1;
            $new_y[] = $y - 1;

            $new_x[] = $x;
            $new_y[] = $y + 1;

            $new_x[] = $x;
            $new_y[] = $y - 1;
            $paths = array();
            foreach ($new_x AS $i => $v) {
                if (isset($this->aMap_[$new_y[$i]][$v]) AND $this->aMap_[$new_y[$i]][$v] == -1) {
                    if ($v == $this->destination_x AND $new_y[$i] == $this->destination_y) {
                        $paths[] = array($v, $new_y[$i]);
                        break;
                    }
                    $paths[] = array($v, $new_y[$i]);
                }
            }
        }

        $this->fillNumber++;
        if (isset($paths)) {
            $this->aWays = $paths;
            $this->startFinding();
        }
    }

    private function regenerateMap() {
        foreach ($this->aMap AS $y => $v_) {
            foreach ($v_ AS $x => $v) {
                if ($v == 1) {
                    $this->aMap_[$y][$x] = -2;
                } elseif ($v == 0) {
                    $this->aMap_[$y][$x] = -1;
                } else {
                    $this->aMap_[$y][$x] = -2;
                }
            }
        }
    }

    private function fillArray($punkt_przed, $nowy_punkt) {
        $pozycja_przed = array_search($punkt_przed, $this->aWay);

        $a = array_slice($this->aWay, 0, $pozycja_przed + 1);
        $b = array_slice($this->aWay, $pozycja_przed + 1);

        $a[] = $nowy_punkt;
        $this->aWay = array_merge($a, $b);
    }

    public function createMap() {
        echo '<style>

            .map_9 {
                width: 40px;
                height: 40px;
                background: #666666;
                color: white;
                font-weight: bold;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
            .map_3 {
                width: 40px;
                height: 40px;
                background: #9AD9EA;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
            .map_2 {
                width: 40px;
                height: 40px;
                background: #D5F9BC;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
            .map_1 {
                width: 40px;
                height: 40px;
                background: #FF7D00;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
            .map_0 {
                width: 40px;
                height: 40px;
                background: #fff;
                float: left;
                border-left: 1px solid black; border-top: 1px solid black;
            }
        ';
        foreach ($this->aWay AS $v) {
            list($y, $x) = $v;
            echo '.x' . $x . 'y' . $y . ' { background: #9AD9EA !important; }';
        }
        echo '</style>';
        echo '<div style="clear: both;"> </div>';
        for ($i = 0; $i < 9; $i++) {
            echo '<div class="map_9">' . $i . '</div>';
        }
        echo '<div style="clear: both;"> </div>';
        foreach ($this->aMap_ AS $y => $v_) {
            echo '<div class="map_9">' . ($y + 1) . '</div>';
            foreach ($v_ AS $x => $v) {
                if ($v > 0) {
                    echo '<div class="map_0 x' . $x . 'y' . $y . '"></div>';
                } elseif ($v == 0) {
                    echo '<div class="map_2"></div>';
                } elseif ($v == -2) {
                    echo '<div class="map_1"></div>';
                } elseif ($v == -1) {
                    echo '<div class="map_0"></div>';
                }
            }
            echo '<div style="clear: both;"> </div>';
        }
    }

}

?>