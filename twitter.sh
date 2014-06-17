#!/bin/sh
sudo cat /var/log/httpd/vagrant-codeigniter-access_log > access_log.txt
LANG=en_US.UTF-8 date +"%d/%b/%Y" > date.txt
grep -f date.txt access_log.txt > date_access_log.txt

# ここでの処理にpostとgetを判断する処理を入れる
cut -d " " -f6-7 date_access_log.txt > analytics_log.txt

# "GET"のURLの絞り込み
grep GET analytics_log.txt > analytics1_log.txt
    
# urlのみの絞り込みを行う
cut -d " " -f2 analytics1_log.txt > analytics2_log.txt

# "index.php/login"と"index.php/regist"と"index.php/tweet"を含む行を取ってくる
grep -w "index.php/login\|index.php/regist\|index.php/tweet" analytics2_log.txt > analytics3_log.txt

# 弾く処理
grep -v "index.php/tweet/logout\|index.php/tweet/read*\|index.php/tweet/test\|index.php/tweet/insert\|index.php/login/index.*" analytics3_log.txt > analytics4_log.txt

cut -d "/" -f3 analytics4_log.txt > analytics5_log.txt


sort analytics5_log.txt > analytics6_log.txt
uniq -c analytics6_log.txt > analytics7_log.txt
sort -nr analytics7_log.txt > analytics8_log.txt

address="niwa@realworld.jp"
subject="Twitterサイトアクセス解析"

mail -s "$subject" $address << HONBUN
`cat analytics8_log.txt`
HONBUN

exit
