<?php


function SQLTotalday()
// 指定日の合計
{
    $useTable = 'sys.pcrework';

    $sql = [];
    array_push($sql, ['NG_etcOK' => "select count(*) from" . $useTable . "where inDate = :d and NG_etc = ''"]);
    array_push($sql, ['NG_etcNG' => "select count(*) from" . $useTable . "where inDate = :d and NG_etc != ''"]);

    foreach ($sql as $val) {
        foreach ($val as $k => $v) {
            echo $k;
            echo $v;
            echo '<br>';
        }
    }
}

SQLTotalday();
