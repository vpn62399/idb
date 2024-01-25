<?php
// 接続テスト成功
// sys.pcrework に接続する

class mainapi
{
    protected $mysqluser = '';
    protected $mysqlpassword = '';
    protected $mysqldb_name = '';
    protected $dbh = null;
    protected $mysqldb_table_ng = '';


    function __construct()
    {
        date_default_timezone_set('Asia/Tokyo');
        $this->mysqluser = 'root';
        $this->mysqlpassword = 'toor';
        $this->mysqldb_name = 'mysql:dbname=sys;host=localhost';
        $this->mysqldb_table_ng = 'sys.pcrework_ng';
    }

    public function myPdo()
    {
        try {
            $this->dbh = new pdo($this->mysqldb_name, $this->mysqluser, $this->mysqlpassword);
        } catch (PDOException $e) {
            $this->myErrorPrint('mysqlaccFN-myPdo-error', $e);
        }
    }

    private function myGet($sqlcmd, $opt = null)
    {

        try {
            $this->myPdo();
            $this->dbh->beginTransaction();
            $pr = $this->dbh->prepare($sqlcmd);
            $pr->execute($opt);
            $temp =  $pr->fetchAll();
            $this->dbh->commit();
            return $temp;
        } catch (PDOException $e) {
            $this->dbh->rollBack();
            $this->myErrorPrint('mysqlaccFN-myPdo-error', $e);
        }
    }

    public function myErrorPrint($errortatle, $errorMSG)
    {
        $printError = [];
        $printError = ['orgError' => 'thisAPP', $errortatle => $errorMSG];
        echo json_encode($printError);
    }
}






// テストFunction

class show extends mainapi
{
    function t1()
    {
        $this->mypdo();
        $cmd = 'select * from sys.pcrework';
        $pre = $this->dbh->prepare($cmd);
        $pre->execute();
        $temp = $pre->fetchAll();
        echo json_encode($temp);
        $this->dbh = null;
    }

    function t2()
    {
        $cmd = 'show grants for \'root\'@\'localhost\'';
        $cmd = 'select * from sys.pcrework';

        try {
            $this->mypdo();
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
    function t3()
    {
        $this->myErrorPrint("test", "dekiru");
    }
}

// $t = new show();
// $t->myGetNG();
