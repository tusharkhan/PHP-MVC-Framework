<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/17/2018
 * Time : 6:08 PM
 * File : Database.php
 */


    class Database
    {
        //Database Class Private Fields
        private static $_instance = null;
        private $_pdo;
        private $_query;
        private $_error = false;
        private $_result;
        private $_count = 0;
        private $_lastInsertID = null;


        /**
         * Database constructor.
         */
        private function __construct()
        {
            try
            {
                $this->_pdo = new PDO('mysql:host='. DB_HOST .';dbname=' . DB_NAME  , DB_USER, DB_PASS);
            }
            catch (PDOException $PDOException)
            {
                die("Error Found " . $PDOException->getMessage() . "<br/> At File " . $PDOException->getFile() . "<br/> Line Number : " . $PDOException->getLine() );
            }
        }


        /**
         * @return Database|null
         */
        public static function getInstance()
        {
            if ( ! isset(self::$_instance) ) self::$_instance = new Database();
            return self::$_instance;
        }


        /**
         * @param $sql
         * @param array $param
         * @return $this
         */
        public function query($sql, $param = [])
        {
            $this->_error = false;

            if ( $this->_query = $this->_pdo->prepare($sql) )
            {
                $x = 1;
                if ( count($param) )
                {
                    foreach ( $param as $item )
                    {
                        $this->_query->bindValue($x, $item);
                        $x++;
                    }
                }

                if ( $this->_query->execute() )
                {
                    $this->_result = $this->_query->fetchAll(5);
                    $this->_count = $this->_query->rowCount();
                    $this->_lastInsertID = $this->_pdo->lastInsertId();
                }
                else $this->_error = true;
            }
            return $this;
        }


        /**
         * @param $table
         * @param array $dates
         * @return bool
         */
        public function insert($table, $dates = [])
        {
            $dataString = '';
            $dataValue = '';
            $values = [];

            foreach ($dates as $data => $value)
            {
                $dataString .= '`' . $data . '`,';
                $dataValue .= '?,';
                $values[] = $value;
            }
            $dataString = rtrim($dataString, ',');
            $dataValue = rtrim($dataValue, ',');
            $sql = "INSERT INTO {$table} ({$dataString}) VALUES ({$dataValue}) ";

            if ( ! $this->query($sql, $values)->error() ) return true;
            else return false;
        }


        /**
         * @param $table
         * @param array $fields
         * @param $uniqueKey
         * @param $keyValue
         * @return bool
         */
        public function update($table, $fields = [], $uniqueKey, $keyValue)
        {
            $dataString = '';
            $values = [];

            foreach ($fields as $field => $value)
            {
                $dataString .= ' ' .$field . ' = ? ,' ;
                $values[] = $value;
            }
            $dataString = rtrim($dataString);
            $dataString = rtrim($dataString, ',');

            $query = "UPDATE {$table} SET  {$dataString} WHERE {$uniqueKey} = ";
            if ( is_int($keyValue) ) $query .= $keyValue;
            else $query .= " '{$keyValue}' ";
//            dnd($query);
            if ( ! $this->query($query, $values)->error() ) return true;
            else return false;
        }


        /**
         * @param $table
         * @param $uniqueKey
         * @param $keyID
         * @return bool
         */
        public function delete($table, $uniqueKey, $keyID)
        {
            $sql = "DELETE FROM {$table} WHERE {$uniqueKey} = ";
            if ( is_int($keyID) ) $sql .= $keyID;
            else $sql .= " '{$keyID}' ";

            if ( ! $this->query($sql)->error() ) return true;
            else return false;
        }


        /**
         * @param $table
         * @param array $params
         * @return bool
         */
        protected function _read($table, $params = [])
        {
            $conditionString = '';
            $bind = '';
            $order = '';
            $limit = '';

            if ( isset( $params['conditions'] ) )
            {
                if ( is_array($params['conditions']) )
                {
                    foreach ($params['conditions'] as $condition) $conditionString .= ' ' . $condition . ' AND ';

                    $conditionString = trim($conditionString);
                    $conditionString = rtrim($conditionString, ' AND ');
                }
                else $conditionString = $params['conditions'];

                if ( ! empty( $conditionString ) ) $conditionString = ' WHERE ' . $conditionString;
            }

            if ( array_key_exists('bind', $params) ) $bind = $params['bind'];
            if ( array_key_exists('order', $params) ) $order .= ' ORDER BY ' . $params['order'];
            if ( array_key_exists('limit', $params) ) $limit .= ' LIMIT ' . $params['limit'];

            $sql = "SELECT * FROM {$table} {$conditionString} {$order} {$limit}";

            if ( $this->query($sql, $bind) )
                if ( ! count($this->_result) ) return false;
                else return true;
            else return false;
        }


        /**
         * @param $table
         * @param array $params
         * @return bool
         */
        public function find($table, $params = [])
        {
            if ( $this->_read($table, $params) ) return $this->result();
            return false;
        }


        /**
         * @param $table
         * @param array $params
         * @return array|bool
         */
        public function findFirst($table, $params = [])
        {
            if ( $this->_read($table, $params) ) return $this->firstResult();
            return false;
        }


        /**
         * @return mixed
         */
        public function result() { return $this->_result; }


        /**
         * @return array
         */
        public function firstResult(){ return ( ! empty( $this->_result ) ) ? $this->_result[0] : []; }


        /**
         * @return array|mixed
         */
        public function lastResult() { return ( ! empty( $this->_result ) ) ? end($this->_result) : []; }



        /**
         * @return int
         */
        public function count() { return $this->_count; }


        /**
         * @return null
         */
        public function lastId() { return $this->_lastInsertID; }


        /**
         * @param $table
         * @return Database
         */
        public function getColumns($table) { return $this->query("SHOW COLUMNS FROM {$table} ")->result(); }

        /**
         * @return bool
         */
        public function error(){ return $this->_error; }

    }//Main Class
?>