<?php

abstract class BaseModel {
    protected static $db;
    protected $table;
    protected $limit;

    public function __construct($args = array()) {
        if (self::$db == null) {
            self::$db = new mysqli(
                DB_HOST, DB_USER, DB_PASS, DB_NAME);
            self::$db->set_charset("utf8");
            if (self::$db->connect_errno) {
                die('Cannot connect to database');
            }
        }

        $defaults = array( 'limit' => 0 );
        $args = array_merge($defaults, $args);
        if (!isset($args['table'])) {
            die('Table not define.');
        }
        extract($args);
        $this->table = $table;
        $this->limit = $limit;
    }

    // mimic of the original mysql_real_escape_string which doesn't need an active mysql connection
    public static function mysql_escape_mimic($inp) {
        if(is_array($inp))
            return array_map(__METHOD__, $inp);

        if(!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }

        return $inp;
    }

    public function executeStatementWithResultArray($statement) {
        if($statement){
            $statement->execute();

            // if the MySQL Native Driver (mysqlnd) driver is available
            // $rows = $statement->get_result();
            // return $this->processResultSet($rows);
        }

        return $this->fetch($statement);
    }

    function fetch($result)
    {
        $array = array();

        if($result instanceof mysqli_stmt)
        {
            $result->store_result();

            $variables = array();
            $data = array();
            $meta = $result->result_metadata();

            while($field = $meta->fetch_field())
                $variables[] = &$data[$field->name]; // pass by reference

            call_user_func_array(array($result, 'bind_result'), $variables);

            $i=0;
            while($result->fetch())
            {
                $array[$i] = array();
                foreach($data as $k=>$v)
                    $array[$i][$k] = $v;
                $i++;
            }
        }
        elseif($result instanceof mysqli_result)
        {
            return $this->processResultSet($result);
        }

        return $array;
    }

    public function executeStatement($statement) {
        if ($statement->execute()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getById($id) {
        return $this->find(array('where' => "id = $id"));
    }

    public function update($args = array()) {
        $defaults = array(
            'table' => $this->table,
            'set' => '',
            'where' => ''
        );

        $args = array_merge($defaults, $args);
        extract($args);
        $query = "UPDATE {$table} SET {$set} WHERE {$where}";
        $resultSet = self::$db->query($query);
        if (gettype($resultSet) == 'boolean') {
            return $resultSet;
        }

        $results = $this->processResultSet($resultSet);
        return $results;
    }

    public function insert($args = array()) {
        $defaults = array(
            'table' => $this->table,
            'columns' => '',
            'values' => ''
        );

        $args = array_merge($defaults, $args);
        extract($args);
        $query = "INSERT IGNORE INTO {$table}({$columns}) VALUES({$values})";
        $resultSet = self::$db->query($query);
        if (gettype($resultSet) == 'boolean') {
            return $resultSet;
        }

        $results = $this->processResultSet($resultSet);
        return $results;
    }

    public function find($args = array()) {
        $defaults = array(
            'table' => $this->table,
            'limit' => $this->limit,
            'where' => '',
            'columns' => '*',
            'order' => ''
        );

        $args = array_merge($defaults, $args);
        extract($args);

        $query = "SELECT {$columns} FROM {$table}";

        if (!empty ($where)) {
            $query .= " WHERE $where";
        }

        if (!empty ($limit)) {
            $query .= " LIMIT $limit";
        }

        if (!empty($order)) {
            $query .= " ORDER BY $order";
        }

        $resultSet = self::$db->query($query);
        $results = $this->processResultSet($resultSet);
        return $results;
    }

    public function delete($args = array()) {
        $defaults = array(
            'table' => $this->table,
            'delete' => '',
            'where' => ''
        );

        $args = array_merge($defaults, $args);
        extract($args);
        $query = "DELETE FROM {$table} WHERE {$where}";
        $resultSet = self::$db->query($query);
        if (gettype($resultSet) == 'boolean') {
            return $resultSet;
        }

        $results = $this->processResultSet($resultSet);
        return $results;
    }

    protected function processResultSet($resultSet) {
        $result = array();
        if (!empty($resultSet) && $resultSet->num_rows > 0) {
            while ($row = $resultSet->fetch_assoc()){
                $result[] = $row;
            }
        }

        return $result;
    }
}