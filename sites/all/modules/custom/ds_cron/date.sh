today=$(date +"%Y%m%d");

date='20170315';
post_date=`date '+%Y%m%d' -d "$date+1 days"`;

echo $date;
echo $post_date;


while true; do
  echo '---';
  post_date=`date '+%Y%m%d' -d "$date+1 days"`;
  wget "http://sobreruedaschevrolet.local/ds_cron/purchases/test?date_start=$date&date_end=$post_date"
  date=$post_date;
  echo '---';
done
