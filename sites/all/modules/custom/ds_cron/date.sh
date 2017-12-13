today=$(date +"%Y%m%d");

#today='20170802';
echo $today;
date=`date '+%Y%m%d' -d "$today-2 days"`;
echo $date;
post_date=`date '+%Y%m%d' -d "$date+1 days"`;
echo $post_date;

#while true; do
  echo '---';
<<<<<<< HEAD
#  post_date=`date '+%Y%m%d' -d "$date+1 days"`;
  wget "http://sobreruedaschevrolet.com/ds_cron/purchases/test?date_start=$date&date_end=$today"
=======
  post_date=`date '+%Y%m%d' -d "$date+1 days"`;
  wget "http://sobreruedaschevrolet.com/ds_cron/purchases/test?date_start=$date&date_end=$post_date"
>>>>>>> c7f8f7a66552d0469f66fddaa15861e0f8b22947
  date=$post_date;
  echo '---';
#done

