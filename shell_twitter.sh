#!/bin/sh

# 日時取得
LOG_DATE=`LANG=en_US.UTF-8 date -d '1 days ago' '+%d/%b/%Y'`
# アクセスログのパス
LOG_PASS='/var/log/httpd/vagrant-codeigniter-access_log'
# 取得ログのURL
GET_URL='index.php/login\|index.php/regist\|index.php/tweet\|/'
# 不必要なログのURL
TRUNCATE_URL='index.php/tweet/logout\|index.php/tweet/read*\|index.php/tweet/test\|index.php/tweet/insert\|index.php/login/index.*'

# 日時によるログの絞り込みを行い、アクセス解析に使用するログをfilter.txtに格納
sudo cat ${LOG_PASS}|grep ${LOG_DATE}|grep GET|cut -d " " -f7 > filter.txt
# ログアウト、ツイート投稿などの不必要なリクエストを削除してselection.txtに格納
grep -w ${GET_URL} filter.txt|grep -v ${TRUNCATE_URL}|cut -d "/" -f3|sed 's/^$/login/g' > selection.txt
# ランキング作成
sort selection.txt|uniq -c|sort -nr|sed -e 's/login/\tログインページ/g' -e 's/regist/\t会員登録ページ/g' -e 's/tweet/\tツイート投稿ページ/g' > ranking.txt

# ファイルに説明文の追加
sed -i '1s/^/\n訪問回数\tページ名\n/' ranking.txt

#mail設定
ADDRESS='niwa@realworld.jp'
SUBJECT="Twitterアクセス解析${LOG_DATE}"

mail -s ${SUBJECT} ${ADDRESS} << HONBUN
${LOG_DATE}　アクセス解析(ログイン、新規登録、ツイート)のランキングです
`cat ranking.txt`
HONBUN

# 作成したファイルの削除
rm filter.txt
rm selection.txt
rm ranking.txt

exit