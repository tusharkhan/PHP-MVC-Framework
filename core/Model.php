<?php
/**
 * Created by PhpStorm.
 * User : Tushar Khan
 * Year : 2018
 * Date : 2/18/2018
 * Time : 8:34 PM
 * File : Model.php
 */

    class Model
    {
        //Model Class Protected Fields
        protected $_db;
        protected $_table;
        protected $_modelName;
        protected $_softDelete = false;
        protected $_columnNames = array();
        //Model Class Public Fields
        public $id;

        /**
         * Model constructor.
         * @param $table
         */
        public function __construct($table)
        {
            $this->_db = Database::getInstance();
            $this->_table = $table;
            $this->_setTableColumns();
            $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', ' ', $this->_table)));
        }


        /**
         *
         */
        protected function _setTableColumns()
        {
            $columns = $this->getColumns();

            foreach ($columns as $column)
            {
                $columnName = $column->Field;
                $this->_columnNames[] = $column->Field;
                $this->{$columnName} = null;
            }
        }


        /**
         * @return Database
         */
        public function getColumns() { return $this->_db->getColumns($this->_table); }


        /**
         * @param array $params
         * @return array
         */
        public function find($params = array())
        {
            $results = array();
            $resultsQuery = $this->_db->find($this->_table, $params);

            foreach ($resultsQuery as $result)
            {
                $obj = new $this->_modelName($this->_table);
                $obj->populateData($result);
                $results[] = $obj;
            }
            return $results;
        }


        /**
         * @param array $param
         * @return mixed
         */
        public function findFirst($param = array())
        {
            $resultQuery = $this->_db->findFirst($this->_table, $param);
            $result = new $this->_modelName($this->_table);

            if ( $resultQuery ) $result->populateData($resultQuery);

            return $result;
        }


        /**
         * @param $result
         */
        protected function populateData($result) { foreach ($result as $key => $value) $this->$key = $value; }


        /**
         * @param $uniqueKey
         * @param $key
         * @return array|bool
         */
        public function findByUniqueKey($uniqueKey, $key) { return $this->_db->findFirst(['conditions' => $uniqueKey . '= ?', 'bind' => $key]); }


        /**
         * @param array $fields
         * @return bool
         */
        public function insert($fields = array())
        {
            if ( empty($fields) ) return false;
            return $this->_db->insert($this->_table, $fields);
        }


        /**
         * @param $uniqueKey
         * @param $key
         * @param array $fields
         * @return bool
         */
        public function update($uniqueKey, $key, $fields = array())
        {
            if ( empty( $uniqueKey ) || empty( $key ) || empty( $fields ) ) return false;
            else return $this->_db->update($this->_table, $fields, $uniqueKey, $key);
        }


        /**
         * @param $uniqueKey
         * @param $key
         * @return bool
         */
        public function delete($uniqueKey, $key)
        {
            if ( empty($this->id) || empty($uniqueKey) || empty($key) ) return false;
            else
            {
                $key = ( empty( $key ) ) ? $this->id : $key;
                return $this->_db->delete($this->_table, $uniqueKey, $key);
            }
        }


        /**
         * @param $uniqueKey
         * @param $key
         * @return bool
         */
        public function save($uniqueKey, $key)
        {
            $fields = array();
            foreach ($this->_columnNames as $column) $fields[$column] = $this->$column;

            if ( property_exists($this, 'id') ) return $this->update($uniqueKey, $key, $fields);
            else $this->insert($fields);
        }


        /**
         * @return stdClass
         */
        public function data()
        {
            $data = new stdClass();

            foreach ($this->_columnNames as $column) $data->column = $this->column;
            return $data;
        }


        /**
         * @param $params
         * @return bool
         */
        public function assign($params)
        {
            if ( ! empty( $params ) )
            {
                foreach ($params as $key => $value)
                {
                    if ( in_array($key, $this->_columnNames) )
                    {
                        $this->$key = sanitize($value);
                    }
                }
                return true;
            }
            return false;
        }


        /**
         * @param $sql
         * @param $bind
         * @return $this|bool
         */
        public function query($sql, $bind)
        {
            if ( empty( $sql ) || empty( $bind ) ) return false;
            else return $this->_db->query($sql, $bind);
        }
    }//Main Class
?>