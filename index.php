<?php
// phpinfo();
// Mysql接続テスト
class mainapi
{
    protected $mysqluser = '';
    protected $mysqlpassword = '';
    protected $mysqldb_name = '';
    protected $dbh = null;

    function __construct()
    {
        $this->mysqluser = 'root';
        $this->mysqlpassword = 'toor';
        $this->mysqldb_name = 'mysql:dbname=mysql;host=localhost';
    }

    public function mypdo()
    {
        try {
            $this->dbh = new pdo($this->mysqldb_name, $this->mysqluser, $this->mysqlpassword);
        } catch (PDOException $e) {
            echo json_encode(sprintf('{"error_MSG1":"%s"}', $e));
        }
    }
}

$test = new mainapi();
$test->mypdo();


phpinfo();
