.mode csv 
.header on
.once test.csv
select rowid as 'No.', "So-net SN" as 'SN',"Wi-Fi SSID-2G" as '2g',"Wi-Fi SSID-5G" as '5g',"Wi-Fi Password" as 'pw' from F660A  order by rowid ;
.once F660A_Total.csv
select * from F660A;
.quit
