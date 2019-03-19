<?php
/**
 * Created by PhpStorm.
 * User: liuyiwei@7659.com
 * Date: 2019/3/15
 * Time: 15:39
 */

namespace App\Services;

class Db_Mysql
{
    private $_options = array();
    private $db;
    private $statement;
    private $_fetchMode = 2;
    /**
     * 构造函数
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $dbname
     * @param string $charset
     */
    private function __construct($host, $username, $password, $dbname, $charset)
    {
        //初始化数据连接
        try {
            $dns = 'mysql:dbname=' . $dbname . ';host=' . $host;
            $this->db = new \PDO($dns, $username, $password, array(\PDO::ATTR_PERSISTENT => true, \PDO::ATTR_AUTOCOMMIT => 1));
            $this->db->query('SET NAMES ' . $charset);
        } catch (\PDOException $e) {
            echo header("Content-type: text/html; charset=utf-8");
            echo '<pre />';
            echo '<b>Connection failed:</b>' . $e->getMessage();
            die;
        }
    }
    /**
     * 调用初始化MYSQL连接
     *
     * @param string $config
     * @return Aomp_Db_Mysql
     */
    static public function getInstance($config = '')
    {
        $host = $config->host;
        $username = $config->username;
        $password = $config->password;
        $dbname = $config->dbname;
        $charset = $config->charset;
        $db = new self($host, $username, $password, $dbname, $charset);
        return $db;
    }
    /**
     * 获取多条数据
     *
     * @param string $sql
     * @param array $bind
     * @param string $fetchMode
     * @return multitype:
     */
    public function fetchAll($sql, $bind = array(), $fetchMode = null)
    {
        if($fetchMode === NULL){
            $fetchMode = $this->_fetchMode;
        }
        $stmt = $this->query($sql, $bind);
        $res = $stmt->fetchAll($fetchMode);
        return $res;
    }
    /**
     * 获取单条数据
     *
     * @param string $sql
     * @param array $bind
     * @param string $fetchMode
     * @return mixed
     */
    public function fetchRow($sql, array $bind = array(), $fetchMode = null)
    {
        if ($fetchMode === null) {
            $fetchMode = $this->_fetchMode;
        }
        $stmt = $this->query($sql, $bind);
        $result = $stmt->fetch($fetchMode);
        return $result;
    }
    /**
     * 获取统计或者ID
     *
     * @param string $sql
     * @param array $bind
     * @return string
     */
    public function fetchOne($sql, array $bind = array())
    {
        $stmt = $this->query($sql, $bind);
        $res = $stmt->fetchColumn(0);
        return $res;
    }
    /**
     * 增加
     *
     * @param string $table
     * @param array $bind
     * @return number
     */
    public function insert($table, array $bind)
    {
        $cols = array();
        $vals = array();
        foreach ($bind as $k => $v) {
            $cols[] = '`' . $k . '`';
            $vals[] = ':' . $k;
            unset($bind[$k]);
            $bind[':' . $k] = $v;
        }
        $sql = 'INSERT INTO '
            . $table
            . ' (' . implode(',', $cols) . ') '
            . 'VALUES (' . implode(',', $vals) . ')';
        $stmt = $this->query($sql, $bind);
        $res = $stmt->rowCount();
        return $res;
    }
    /**
     * 删除
     *
     * @param string $table
     * @param string $where
     * @return boolean
     */
    public function delete($table, $where = '')
    {
        $where = $this->_whereExpr($where);
        $sql = 'DELETE FROM '
            . $table
            . ($where ? ' WHERE ' .$where : '');
        $stmt = $this->query($sql);
        $res = $stmt->rowCount();
        return $res;
    }
    /**
     * 修改
     *
     * @param string $table
     * @param array $bind
     * @param string $where
     * @return boolean
     */
    public function update($table, array $bind, $where = '')
    {
        $set = array();
        foreach ($bind as $k => $v) {
            $bind[':' . $k] = $v;
            $v = ':' . $k;
            $set[] = $k . ' = ' . $v;
            unset($bind[$k]);
        }
        $where = $this->_whereExpr($where);
        $sql = 'UPDATE '
            . $table
            . ' SET ' . implode(',', $set)
            . (($where) ? ' WHERE ' . $where : '');
        $stmt = $this->query($sql, $bind);
        $res = $stmt->rowCount();
        return $res;
    }
    /**
     * 获取新增ID
     *
     * @param string $tableName
     * @param string $primaryKey
     * @return string
     */
    public function lastInsertId()
    {
        return (string) $this->db->lastInsertId();
    }
    public function query($sql, $bind = array())
    {
        if(!is_array($bind)){
            $bind = array($bind);
        }
        $stmt = $this->prepare($sql);
        $stmt->execute($bind);
        $stmt->setFetchMode($this->_fetchMode);
        return $stmt;
    }
    public function prepare($sql = '')
    {
        if(empty($sql)){
            return false;
        }
        $this->statement = $this->db->prepare($sql);
        return $this->statement;
    }
    public function execute($param = '')
    {
        if(is_array($param)){
            try {
                return $this->statement->execute($param);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }else {
            try {
                return $this->statement->execute();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
    /**
     *
     * @param string $where
     * @return null|string
     */
    protected function _whereExpr($where)
    {
        if(empty($where)){
            return $where;
        }
        if(!is_array($where)){
            $where = array($where);
        }
        $where = implode(' AND ', $where);
        return $where;
    }
    /**
     * 关闭数据库操作
     */
    public function close()
    {
        $this->_db = null;
    }
}