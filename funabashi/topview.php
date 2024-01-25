<?php
include '../API/mysqlaccFN.php';
date_default_timezone_set('Asia/Tokyo');

class topview extends mainapi
{
    protected $send_json = array();
    protected $useTable = 'sys.pcrework';
    function __construct()
    {
        parent::__construct();
    }

    function PDOrequest($qlcmd)
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

    function PDOrequestArray($qlcmd, $sqlArray = null)
    {
        try {
            $this->myPdo();
            $this->dbh->beginTransaction();
            $pr = $this->dbh->prepare($qlcmd);
            $pr->execute($sqlArray);
            $temp = $pr->fetchAll();
            $this->dbh->commit();
            return $temp;
        } catch (PDOException $e) {
            $this->dbh->rollback();
            $this->send_json['PDOerror'] = $e;
        }
    }


    // function SQLcmd2($NG_etcs)
    // // 複数の不具合内容から数量を確認する
    // // PDO::prepare 形式 
    // {
    //     foreach ($NG_etcs as $NG_etc) {
    //         if ($_POST['inDate']) {
    //             $qlcmd = 'select count(*) from sys.pcrework where NG_etc like :c and inDate = :d';
    //             $sqlprepaer = [':c' => '%' . $NG_etc . '%', ':d' => $_POST['inDate']];
    //         } else {
    //             $qlcmd = "select count(*) from sys.pcrework where NG_etc like :c";
    //             $sqlprepaer = [':c' => '%' . $NG_etc . '%'];
    //         }
    //         $this->send_json['data'][$NG_etc] = $this->PDOrequestArray($qlcmd, $sqlprepaer);
    //         $this->send_json['sqlcmd'][$NG_etc] = $qlcmd;
    //     }
    // }


    function SQLcmd($cmds)
    // 複数の不具合内容から数量を確認する
    // PDO::prepare 利用しない
    {
        foreach ($cmds as $itemin) {
            if ($_POST['inDate']) {
                $qlcmd = sprintf("select '%s',count(*) from %s where NG_etc like '%%%s%%' and inDate = '%s'", $itemin, $this->useTable, $itemin, $_POST['inDate']);
            } else {
                $qlcmd = sprintf("select '%s',count(*) from %s where NG_etc like '%%%s%%'", $itemin, $this->useTable, $itemin);
            }
            $this->send_json['NG_etc_val'][$itemin] = $this->PDOrequest($qlcmd);
            $this->send_json['req_sql_cmd'][$itemin] = $qlcmd;
        }
    }

    function SQLTotalday()
    // 指定日の合計NG数、OK数、トータル数
    // データ‐ペース変更後にSQLコマンドの変更が必要です。
    // 
    {
        $sql = [];
        if (!$_POST['inDate']) {
            array_push($sql, ['request_date' =>  'select now()']);
            array_push($sql, ['1st_AllOK' => 'select count(*) from ' . $this->useTable . " where (NG_etc is null or NG_etc like 'SIM tray無法推出  交換後OK')"]);
            array_push($sql, ['1st_AllNG' => 'select count(*) from ' . $this->useTable . " where (NG_etc != '' and NG_etc not like 'SIM tray無法推出  交換後OK')"]);
            array_push($sql, ['1st_AllTotal' => 'select count(*) from ' . $this->useTable]);
            // array_push($sql, ['byPallentNo' => 'select palletNo,count(*) from ' . $this->useTable . " group by palletNo"]);
        } else {
            array_push($sql, ['request_date' =>  'select now() from ' . $this->useTable . " where inDate <= :d limit 1"]);
            array_push($sql, ['1st_DayOK' => 'select count(*) from ' . $this->useTable . " where inDate = :d and (NG_etc is null or NG_etc like 'SIM tray無法推出  交換後OK')"]);
            array_push($sql, ['1st_DayNG' => 'select count(*) from ' . $this->useTable . " where inDate = :d and (NG_etc != '' and NG_etc not like 'SIM tray無法推出  交換後OK')"]);
            array_push($sql, ['1st_DayTotal' => 'select count(*) from ' . $this->useTable . " where inDate= :d"]);
            // array_push($sql, ['byPallentNo' => 'select palletNo,count(*) from  ' . $this->useTable . " where inDate = :d group by palletNo"]);
        }
        foreach ($sql as $cmd) {
            foreach ($cmd as $key => $val) {
                if (!$_POST['inDate']) {
                    $this->send_json['totaltoday'][$key] = $this->PDOrequestArray($val);
                } else {
                    $this->send_json['totaltoday'][$key] = $this->PDOrequestArray($val, [':d' => $_POST['inDate']]);
                }
            }
        }
    }

    // 不良内容項目のarray
    public function myGetNG()
    {
        try {
            $cmd = 'select * from sys.pcrework_ng where no in (1,2,3,4,5,6,7,8,9,10,11,12,72) order by no';
            $this->send_json['NG_etc_item'] = $this->PDOrequest($cmd);
        } catch (PDOException $e) {
            $this->myErrorPrint('mysqlaccFN-myPdo-error', $e);
        }
    }

    function to_json()
    {
        $date = new DateTime('now', new DateTimeZone('Asia/Tokyo'));
        $this->send_json['$_POST'] = $_REQUEST;
        $this->send_json['request_date'] = $date->format('Y-m-d h:i:s');
        echo json_encode($this->send_json);
    }
}

$temp = new topview();
switch ($_GET['m']) {
    case 'pcrework_ng':
        $temp->myGetNG();
        break;
    case 'cr4':
        $temp->SQLcmd(json_decode($_POST['NG_etcs']));
        break;
    case 'bb':
        break;
}

$temp->SQLTotalday();
$temp->to_json();
