#!/bin/bash

##################################################
# Ce script effectue une sauvegarde des bases de
# données et du dossier des sites et transfert
# cette sauvegarde sur un serveur FTP
##################################################

##############################################
# Variables à modifier
##############################################

#hote FTP
                                  
#Utilisateur MySQL
MUSER="tounsianet"   
#pass MySQL                                                 
MPASS="jnzcjen654ec"
#hote MySQL                                           
MHOST="127.0.0.1"
#Dossier à sauvergarder (dossier dans lequel les sites sont placés)
DIRSITES="/var/www/tounsia/web/uploads /var/www/tounsia/src"

##############################################
# dossiers temporaires crées (laissez comme ça, ou pas)
##############################################

#Dossier de sauvegarde temporaire des dumps sql
DIRSAVESQL="backups/sql"
#Dossier de sauvegarde temporaire des sites
DIRSAVESITES="backups/sites"

##############################################
#
##############################################
MYSQL="$(which mysql)"
MYSQLDUMP="$(which mysqldump)"
GZIP="$(which gzip)"
TAR="$(which tar)"
DBS="base1 base2 base3"
DATE_FORMAT=`date +%Y-%m-%d`  

if [ ! -d $DIRSAVESITES ]; then
  mkdir -p $DIRSAVESITES
else
 :
fi
if [ ! -d $DIRSAVESQL ]; then
  mkdir -p $DIRSAVESQL
else
 :
fi

echo "Sauvegarde des bases de donnees :"
for db in $DBS
do
    echo "Database : $db"
	FILE=$DIRSAVESQL/mysql-$db-$DATE_FORMAT.gz
	$MYSQLDUMP -u $MUSER -h $MHOST -p$MPASS $db | $GZIP -9 > $FILE
done

echo "Creation de l'archive des dumps"
$TAR -cf base-$DATE_FORMAT.tar $DIRSAVESQL/*$DATE_FORMAT*

echo "Creation de l'archive des sites"
$TAR --exclude=.svn  -czf sites-$DATE_FORMAT.tar.gz $DIRSITES

#echo "Connexion au serveur FTP et envoi des donnees"
#ftp -nv $FTP_SERVER <<END
#        user $FTP_LOGIN $FTP_PASS
#        put base-$DATE_FORMAT.tar /base-$DATE_FORMAT.tar
#        put sites-$DATE_FORMAT.tar.gz /sites-$DATE_FORMAT.tar.gz
#		ls
#        quit
#END

#echo "Suppression de l'archive de sauvegarde SQL"
#rm -Rf $DIRSAVESQL
#rm base-$DATE_FORMAT.tar
#echo "Suppression de l'archive de sauvegarde des sites"
#rm -R $DIRSAVESITES
#rm sites-$DATE_FORMAT.tar.gz