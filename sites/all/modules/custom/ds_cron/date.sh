today=$(date +"%Y%m%d");

date='20170801';
post_date=`date '+%Y%m%d' -d "$date+28 days"`;

echo $date;
echo $post_date;


while true; do
  echo '---';
  post_date=`date '+%Y%m%d' -d "$date+28 days"`;
  wget "http://sobreruedaschevrolet.com/ds_cron/purchases/test?date_start=$date&date_end=$post_date"
  date=$post_date;
  echo '---';
done
