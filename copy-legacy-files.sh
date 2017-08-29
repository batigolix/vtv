#!/bin/sh

LOGFILE=$HOME/cp-legacy-files-log.txt
if [ ! -f $LOGFILE ]; then
  touch $LOGFILE
fi

DOWNLOADS=$HOME/Downloads
LOCAL_LEGACY_FILE_LIST=$HOME/Sites/vtv/cp-legacy-files-list.txt
LOCAL_LEGACY_SOURCE=$HOME/Sites/drupal6_a2h/sites/default/files
LOCAL_LEGACY_DESTINATION=$HOME/Sites/vtv/web/sites/default/files/images/legacy
REMOTE_LEGACY_SOURCE=/home/doesborg/www/drupal6/sites/www.volkstheater-venlo.nl/files
REMOTE_LEGACY_DESTINATION=/home/doesborg/www/vtv/web/sites/default/files/images/legacy

TIME=$(date +%s)

while read F  ; do
        echo $F
        cp "$LOCAL_LEGACY_SOURCE/$F" $LOCAL_LEGACY_DESTINATION
done < $LOCAL_LEGACY_FILE_LIST

#        scp -P 7822 "$LOCAL_LEGACY_SOURCE/$F" doesborg@doesb.org:$REMOTE_LEGACY_DESTINATION

#rsync -avz -e 'ssh -p 7822' --progress $LOCAL_LEGACY_DESTINATION $REMOTE_LEGACY_DESTINATION
rsync -avz -e 'ssh -p 7822' --progress "/home/boris/Sites/vtv/web/sites/default/files/images/legacy"   "doesborg@doesb.org:/home/doesborg/public_html/vtv/web/sites/default/files/images/"

# if scp $DOWNLOADS/*.torrent boris@luque:/home/boris/Torrents ; then
##    echo "Command succeeded"
#    echo "$TIME torrents moved" >> $LOGFILE
# rm -rf $DOWNLOADS/*.torrent

# scp -p 7822 docroot/mac.sql doesborg@doesb.org:/tmp

# else
#    echo "Command failed"
#    echo "$TIME torrents move failed" >> $LOGFILE
# fi

# scp ~/Downloads/*.torrent boris@luque:/home/boris/Torrents
