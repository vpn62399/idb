
csv ファイルからインポートするコマンド

drop table F660A;
CREATE TABLE IF NOT EXISTS "F660A"(
"PON SN" TEXT,
"So-net SN" TEXT UNIQUE NOT NULL,
"MAC Address" TEXT NOT NULL,
"Wi-Fi SSID-2G" TEXT NOT NULL,
"Wi-Fi SSID-5G" TEXT NOT NULL,
"Wi-Fi Password" TEXT NOT NULL,
"Product Number" TEXT NOT NULL,
"Manufacture Date" TEXT,
"EN" TEXT NOT NULL);

.mode csv
.import F660A_Total.csv F660A
.mode table

update F660A set "Manufacture Date" = '2020/02/02' where "Manufacture Date" = '';

F660A_Total.db からデータをCSVにエクスポートするコマンド

.mode csv
.once export-F660A_Total.csv
select * from F660A;
.mode table



F660A_Total.db からテストCSVをエクスポートするコマンド

WifiTestcsvExport.sql
.mode csv 
.header on
.once test.csv
select rowid as 'No.', "So-net SN" as 'SN',"Wi-Fi SSID-2G" as '2g',"Wi-Fi SSID-5G" as '5g',"Wi-Fi Password" as 'pw' from F660A  order by rowid ;
.quit

sqlite3.exe F660A_Total.db ".read WifiTestcsvExport.sql"


