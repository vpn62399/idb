<?php
include '../API/mysqlaccFN.php';
date_default_timezone_set('Asia/Tokyo');
echo json_encode($_REQUEST);


class checksn extends mainapi
{
    protected $useTable = 'checksn.sn';
    protected $send_json = array();

    function __construct()
    {
        parent::__construct();
    }

    function PDOreq($qlcmd)
    {
        try {
            $this->myPdo();
            $this->dbh->beginTransaction();
            $pr = $this->dbh->prepare($qlcmd);
            $pr->execute();
            $temp = $pr->fetchAll();
            $this->dbh->commit();
            return $temp;
        } catch (PDOException $e) {
            $this->dbh->rollback();
            $this->send_json['PDOerror'] = $e;
        }
    }

    function showSN($sn)
    {

        return;
    }

    function insertDB($sn)
    {
    }
}
