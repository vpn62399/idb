<?php
// 接続テスト成功
class mainapi
{
    protected $mysqluser = '';
    protected $mysqlpassword = '';
    protected $mysqldb_name = '';
    protected $dbh = null;

    function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
        $this->mysqluser = 'root';
        $this->mysqlpassword = 'toor';
        $this->mysqldb_name = 'mysql:dbname=mysql;host=localhost';
    }

    public function myPDO()
    {
        try {
            $this->dbh = new pdo($this->mysqldb_name, $this->mysqluser, $this->mysqlpassword);
        } catch (PDOException $e) {
            printf('{"error_MSG1":"%s"}', $e);
        }
    }

    public function myErrorPrint($errortatle, $errorMSG)
    {
        $printError = [];
        $printError = ['orgError' => 'thisAPP', $errortatle => $errorMSG];
        echo json_encode($printError);
    }
}

// テスト ファンクション
class show extends mainapi
{
    function t1()
    {
        $this->myPDO();
        $cmd = 'select user,host from mysql.user ';
        $pre = $this->dbh->prepare($cmd);
        $pre->execute();
        $temp = $pre->fetchAll();
        echo json_encode($temp);
        $this->dbh = null;
    }

    function t2()
    {
        $cmd = 'show grants for \'root\'@\'localhost\'';
        $cmd = 'select user,host from mysql.user ';

        try {
            $this->myPDO();
            $this->dbh->beginTransaction();
            $df = $this->dbh->prepare($cmd);
            $df->execute();
            $temp = $df->fetchAll();
            echo json_encode($temp, JSON_UNESCAPED_UNICODE);
            $this->dbh->commit();
        } catch (PDOException $e) {
            $this->dbh->rollback();
        }
    }
}

$t = new show();
$t->t2();
