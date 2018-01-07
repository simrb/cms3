#!/bin/bash

Uhost="localhost"
Udata="cms_db"$RANDOM
Uname="cms_u"$RANDOM
Upawd="cms_p"$RANDOM
Uinitpj="no"
Uinitdb="no"
Uinitht="no"

while getopts "h:n:u:p:edi" opt
do
	case $opt in
		 h)
		 	Uhost=$OPTARG;;
		 n)
		 	Udata=$OPTARG;;
		 u)
		 	Uname=$OPTARG;;
		 p)
		 	Upawd=$OPTARG;;
		 e)
		 	Uinitpj="yes";;
		 d)
		 	Uinitdb="yes";;
		 i)
		 	Uinitht="yes";;
		 ?)
			echo "unkonw option"
			grep 'version' module/admin/libs/config.php
			exit 1
			;;
	esac
done


Urepstr="s/localost/$Uhost/g;s/cms_db/$Udata/g;s/cms_user/$Uname/g;s/cms_pawd/$Upawd/g"


function getdir(){
    for element in `ls $1`
    do  
        dir_or_file=$1"/"$element
        if [ -d $dir_or_file ] ; then 
			create_file=${dir_or_file}"/"${my_file}
			if [ ! -f "$create_file" ] ; then
 				touch "$create_file"
 				echo "$create_file"
			fi
            getdir $dir_or_file
        fi  
    done
}


# need root to run this script
function needroot() {
	if [ ! `whoami` = "root" ] ; then
		echo "Running the file must be root user"
		exit;
	fi
}


if [ ! $1 ]; then
cat << EOF
================================================================
Options
  -e, initialling the project environment.
  -d, initialling the database.
    -h, hostname
    -n, database
    -u, username
    -p, password
  -i, increarsing the index.html file for each directory.
  -v, check the version of current release.

For example
if you want to initial the project.

   # sh .myt -ed

EOF
fi


# create the index.html for each dir
if [ $Uinitht = "yes" ] ; then
	echo "initialing index page for each directory."
	my_path=$(cd `dirname $0`; pwd)
	my_file="index.html"
	getdir $my_path
fi


# initial database
if [ $Uinitdb = "yes" ] ; then
	needroot
	echo "initialing database with -h$Uhost, -n$Udata, -u$Uname, -p$Upawd."
	sed $Urepstr "module/admin/libs/00initdb.sql" > "others/initdb.sql"
 	mysql -h localhost -u root < "others/initdb.sql"
 	rm -f "others/initdb.sql"
fi


# initial running environment of server
if [ $Uinitpj = "yes" ] ; then
	needroot
	echo "initialing project environment."

	my_file="/usr/sbin/httpd"
	if [ ! -f "$my_file" ] ; then
		yum -y install httpd
		service httpd start
		chkconfig httpd on
	fi

	my_file="/usr/bin/mysql"
	if [ ! -f "$my_file" ] ; then
		yum -y install mysql mysql-server
# 		yum -y install mysql mysql-server mysql-devel
		service mysqld start
		chkconfig mysqld on
	fi

	my_file="/usr/bin/php"
	if [ ! -f "$my_file" ] ; then
		yum -y install php php-mysql
	fi

	# install the php-mbstring
	my_file="/etc/php.d/mbstring.ini"
	if [ ! -f "$my_file" ] ; then
		yum -y install php-mbstring
	fi

	# install the php-gd
	my_file="/etc/php.d/gd.ini"
	if [ ! -f "$my_file" ] ; then
		yum -y install php-gd
	fi

	my_file="/etc/php.d/custom.ini"
	if [ ! -f "$my_file" ] ; then
		echo 'short_open_tag=On' > $my_file
		echo 'upload_max_filesize=3M' >> $my_file
		echo "${my_file} is created"
	fi

	# copy the cfg.php
	my_file="others/cfg.php"
	if [ ! -f "$my_file" ] ; then
		sed $Urepstr "module/admin/libs/cfg.php" > $my_file
		chmod 777 $my_file
		echo "file ${my_file} is created"
	fi

	# create upload dir
	my_dir="others/upload"
	if [ ! -d "$my_dir" ] ; then
		mkdir $my_dir
		chmod -R 777 $my_dir
		echo "dir ${my_dir} is created"
	fi

	# create logo file
	my_file="others/upload/logo.jpg"
	if [ ! -f "$my_file" ] ; then
 		touch $my_file
		echo "${my_file} is created"
	fi

fi




