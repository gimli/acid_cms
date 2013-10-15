<?php
/*
 Mysql Class inner class
*/
class db_mysql
{
        var $cms;

        var $link;
        var $recent_link = null;
        var $sql = '';
        var $query_count = 0;
        var $error = '';
        var $errno = '';
        var $is_locked = false;
        var $show_errors = false;

        function db_mysql(&$cms)
        {
           $this->cms = &$cms;

           $h = $this->cms->Config->GetDBInfo('db_host');
           $u = $this->cms->Config->GetDBInfo('db_user');
           $p = $this->cms->Config->GetDBInfo('db_pass');
           $n = $this->cms->Config->GetDBInfo('db_name');

           $this->connect($h,$u,$p,$n);
        }

        function connect($db_host, $db_user, $db_pass, $db_name)
        {

                $this->link = @mysql_connect($db_host, $db_user, $db_pass);

                if ($this->link)
                {
                        if (@mysql_select_db($db_name, $this->link))
                        {
                                $this->recent_link =& $this->link;
                                return $this->link;
                        }
                }
                $this->raise_error("Could not select and/or connect to database: $db_name");
        }

        function query($sql, $only_first = false)
        {
                $this->recent_link =& $this->link;
                $this->sql =& $sql;
                $result = @mysql_query($sql, $this->link);

                $this->query_count++;

                if ($only_first)
                {
                        $return = $this->fetch_array($result);
                        $this->free_result($result);
                        return $return;
                }
                return $result;
        }

        function fetch_array($result)
        {
                return  @mysql_fetch_assoc($result);
        }

        function is_object($obj)
        {
           $object = new ArrayObject($obj, ArrayObject::ARRAY_AS_PROPS);
           return $object;
        }

        function num_rows($result)
        {
                return @mysql_num_rows($result);
        }

        function affected_rows()
        {
                return @mysql_affected_rows($this->recent_link);
        }

        function num_queries()
        {
                return $this->query_count;
        }

        function lock($tables)
        {
                if (is_array($tables) AND count($tables))
                {
                        $sql = '';

                        foreach ($tables AS $name => $type)
                        {
                                $sql .= (!empty($sql) ? ', ' : '') . "$name $type";
                        }

                        $this->query("LOCK TABLES $sql");
                        $this->is_locked = true;
                }
        }

        function unlock()
        {
                if ($this->is_locked)
                {
                        $this->query("UNLOCK TABLES");
                }
        }

        function insert_id()
        {
                return @mysql_insert_id($this->link);
        }

        function prepare($value, $do_like = false)
        {
                $value = stripslashes($value);

                if ($do_like)
                {
                        $value = str_replace(array('%', '_'), array('\%', '\_'), $value);
                }

                if (function_exists('mysql_real_escape_string'))
                {
                        return mysql_real_escape_string($value, $this->link);
                }
                else
                {
                        return mysql_escape_string($value);
                }
        }

        function free_result($result)
        {
                return @mysql_free_result($result);
        }

        function show_errors()
        {
                $this->show_errors = true;
        }

        function hide_errors()
        {
                $this->show_errors = false;
        }

        function close()
        {
                $this->sql = '';
                return @mysql_close($this->link);
        }

        function sdb($database)
        {
                return mysql_select_db($database,$this->link);
        }

        function error()
        {
                $this->error = (is_null($this->recent_link)) ? '' : mysql_error($this->recent_link);
                return $this->error;
        }

        function errno()
        {
                $this->errno = (is_null($this->recent_link)) ? 0 : mysql_errno($this->recent_link);
                return $this->errno;
        }

        function _get_error_path()
        {
                if ($_SERVER['REQUEST_URI'])
                {
                        $errorpath = $_SERVER['REQUEST_URI'];
                }
                else
                {
                        if ($_SERVER['PATH_INFO'])
                        {
                                $errorpath = $_SERVER['PATH_INFO'];
                        }
                        else
                        {
                                $errorpath = $_SERVER['PHP_SELF'];
                        }

                        if ($_SERVER['QUERY_STRING'])
                        {
                                $errorpath .= '?' . $_SERVER['QUERY_STRING'];
                        }
                }

                if (($pos = strpos($errorpath, '?')) !== false)
                {
                        $errorpath = urldecode(substr($errorpath, 0, $pos)) . substr($errorpath, $pos);
                }
                else
                {
                        $errorpath = urldecode($errorpath);
                }
                return $_SERVER['HTTP_HOST'] . $errorpath;
        }

        function raise_error($error_message = '')
        {
                if ($this->recent_link)
                {
                        $this->error = $this->error($this->recent_link);
                        $this->errno = $this->errno($this->recent_link);
                }

                if ($error_message == '')
                {
                        $this->sql = "Error in SQL query:\n\n" . rtrim($this->sql) . ';';
                        $error_message =& $this->sql;
                }
                else
                {
                        $error_message = $error_message . ($this->sql != '' ? "\n\nSQL:" . rtrim($this->sql) . ';' : '');
                }

                $message = "<textarea rows=\"10\" cols=\"80\">MySQL Error:\n\n\n$error_message\n\nError: {$this->error}\nError #: {$this->errno}\nFilename: " . $this->_get_error_path() . "\n</textarea>";

                if (!$this->show_errors)
                {
                        $message = "<!--\n\n$message\n\n-->";
                }
                die("There seems to have been a slight problem with our database, please try again later. ($db_host)<br /><br />\n$message");
        }
}
?>
