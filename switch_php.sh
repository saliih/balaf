#!/usr/bin/env bash
export IS_PHP7=`php --version|grep "PHP 7.2"`

if [[ -z $IS_PHP7 ]]; then
	echo "Switching to PHP 7.2"
	echo "===================="
	sudo a2dismod php5.6;
	sudo a2enmod php7.2;
	sudo systemctl restart apache2;
	sudo ln -sfn /usr/bin/php7.2 /etc/alternatives/php
else
	echo "Switching to PHP 5.6"
	echo "===================="
	sudo a2dismod php7.2;
	sudo a2enmod php5.6;
	sudo systemctl restart apache2;
	sudo ln -sfn /usr/bin/php5.6 /etc/alternatives/php
fi

php --version