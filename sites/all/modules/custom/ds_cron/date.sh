today=$(date +"%Y%m%d");

#today='20170802';
echo $today;
date=`date '+%Y%m%d' -d "$today-2 days"`;
echo $date;
post_date=`date '+%Y%m%d' -d "$date+1 days"`;
echo $post_date;

#while true; do
  echo '---';
#  post_date=`date '+%Y%m%d' -d "$date+1 days"`;
  wget "http://sobreruedaschevrolet.com/ds_cron/purchases/test?date_start=$date&date_end=$today"
  date=$post_date;
  echo '---';
#done

