
/**
 * @author Hernas <contact@hern.as>
 * @copyright 2008 Hernas.pl.
 * @version 2.1
 */

            function SearchWay() {
                var obj = new Object();

                obj.number = 0;
                obj.dest = new Array();
                obj.startPos = new Array();
                obj.Map = new Array();
                obj.Way = new Array();
                obj.find = function(start_x, start_y, dest_x, dest_y, map)
                {
                    obj.Map = map;
                    obj.regenerateMap();
                    obj.Way = new Array();
                    obj.number = 0;

                    obj.dest = new Array();
                    obj.dest[0] = dest_x; //x
                    obj.dest[1] = dest_y; //y

                    obj.startPos = new Array();
                    obj.startPos[0] = new Array();
                    obj.startPos[0][0] = start_x; //x
                    obj.startPos[0][1] = start_y; //y
                    obj.mark(obj.startPos);
                    obj.searchReverse(obj.dest);
                    return obj.Way;
                };
                obj.searchReverse = function(pos) {
                    x = pos[0];
                    y = pos[1];
                    new_x = new Array();
                    new_y = new Array();

                    new_x[0] = x+1;
                    new_y[0] = y;

                    new_x[1] = x-1;
                    new_y[1] = y;

                    new_x[2] = x;
                    new_y[2] = y+1;

                    new_x[3] = x+1;
                    new_y[3] = y+1;

                    new_x[4] = x-1;
                    new_y[4] = y+1;

                    new_x[5] = x;
                    new_y[5] = y-1;

                    new_x[6] = x+1;
                    new_y[6] = y-1;

                    new_x[7] = x-1;
                    new_y[7] = y-1;

                    for(ii in new_x)
                    {
                        nx = new_x[ii];
                        ny = new_y[ii];
                        if(obj.Map[ny]!=undefined && obj.Map[ny][nx]!=undefined && obj.Map[ny][nx]==(obj.Map[y][x]-1) && obj.Map[ny][nx]>-1)
                        {
                            obj.Way[(obj.Map[y][x]-1)] = new Array();
                            obj.Way[(obj.Map[y][x]-1)][0] = nx;
                            obj.Way[(obj.Map[y][x]-1)][1] = ny;
                            obj.searchReverse(new Array(nx, ny));
                        }
                    }
                };
                obj.mark = function(searching)
                {

                    for(i in searching)
                    {
                        x = searching[i][0];
                        y = searching[i][1];
                        if(obj.Map[y]!=undefined && obj.Map[y][x]!=undefined)
                        {
                            obj.Map[y][x] = obj.number;
                        }
                        if(obj.dest[0]==x && obj.dest[1]==y)
                        {
                            return;
                        }
                    }

                    nextMark = false;
                    new_map = new Array();
                    ii_ = 0;
                    for(i in searching)
                    {
                        nextMark = true;
                        x = searching[i][0];
                        y = searching[i][1];

                        new_x = new Array();
                        new_y = new Array();

                        new_x[0] = x+1;
                        new_y[0] = y;

                        new_x[1] = x+1;
                        new_y[1] = y+1;

                        new_x[2] = x+1;
                        new_y[2] = y-1;

                        new_x[3] = x-1;
                        new_y[3] = y;

                        new_x[4] = x-1;
                        new_y[4] = y+1;

                        new_x[5] = x-1;
                        new_y[5] = y-1;

                        new_x[6] = x;
                        new_y[6] = y+1;

                        new_x[7] = x;
                        new_y[7] = y-1;
                        for(ii in new_x)
                        {
                            nx = new_x[ii];
                            ny = new_y[ii];
                            if((obj.Map[ny]!=undefined && obj.Map[ny][nx]!=undefined) && obj.Map[ny][nx]==-1)
                            {
                                new_map[ii_] = new Array();
                                new_map[ii_][0] = nx;
                                new_map[ii_][1] = ny;
                                ii_++;
                            }
                        }
                    }
                    obj.number++;
                    if(nextMark)
                    {
                        obj.mark(new_map);
                    }
                };

                obj.regenerateMap = function() {
                    for(i = 0; i < obj.Map.length; i++) {
                        for(ii = 0; ii < obj.Map[0].length; ii++) {
                            var v = obj.Map[i][ii];
                            //obj.Map[i][ii] = -2;
                            if(v == 1) {
                                obj.Map[i][ii] = -2;
                            }
                            if(v == 0) {
                                obj.Map[i][ii] = -1;
                            }
                        }
                    }
                }
                return obj;
            }


            Object.prototype.clone = function() {
              var newObj = (this instanceof Array) ? [] : {};
              for (i in this) {
                if (i == 'clone') continue;
                if (this[i] && typeof this[i] == "object") {
                  newObj[i] = this[i].clone();
                } else newObj[i] = this[i]
              } return newObj;
            };
