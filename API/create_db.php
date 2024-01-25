        create table partslist.mainlist(
            indexkey int AUTO_INCREMENT PRIMARY KEY comment 'IndexKEY',
            INDEX(indexkey),
            indate date NOT NULL comment '登録日付',
            inperson TINYINT NOT NULL comment '担当者 indexkey   users.table',
            upstream TINYINT NOT NULL comment '仕入れ先 indexkey upstream.table',
            status TINYINT NOT NULL comment '状態 indexkey  status.table',
            outdate date comment '登録日付',
            outperson TINYINT comment '担当者 indexkey  users.table',
            category TINYINT NOT NULL comment '製品カテゴリ indexkey  category.table',
            pmodel int NOT NULL comment '製品モデル indexkey  pmodel.table',
            modexsn VARCHAR(20) UNIQUE comment 'シリアル番号',
            comment VARCHAR(500) comment 'コメント文字数250',
            killl TINYINT(1) NULL comment '殺す',
            acount int comment 'アクセスの回数を記録する'
        );

        例
        insert into partslist.mainlist(indate,inperson,upstream,status,category,pmodel,modexsn,comment,killl) values('2022/12/08',1,1,1,1,128,'N7M0CS00D664VKD','comment',1);

        create table idb.main(
            id int AUTO_INCREMENT PRIMARY KEY comment 'IndexKEY',
            INDEX(id),
            palletNo VARCHAR(100) comment 'palletNo',
            cartonNo VARCHAR(100) comment 'cartonNo',
            SerialNo VARCHAR(100) UNIQUE comment 'SerialNo',
            inDate date not null comment 'inDate',
            inTime time not null comment 'inTime',
            NG_reason VARCHAR(100) comment 'NG_reason',
            NG_etc VARCHAR(100) comment 'NG_etc',
            NG_date date comment 'NG_date',
            NG_time time comment 'NG_time',
            NG_etc2 VARCHAR(100) comment 'NG_etc2',
            NG_date2 date comment 'NG_date2',
            NG_time2 time comment 'NG_time2',
            OutCheck VARCHAR(100) comment 'OutCheck',
            OutTime time comment 'OutTime',
            OutDate date comment 'OutDate',
            OutFlag VARCHAR(100) comment 'OutFlag',
            Out_FlagDate date comment 'Out_FlagDate'
        )