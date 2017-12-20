About
============

It is a simple cms by php language, the base feature included as the following,

	allow adding record
	allow uploading picture
	allow registering user
	allow managing category



Setup
============

initialing the project environment and database by default database, username, userpawd

	# su
	# sh .myt -ed

or, set your custom by options `-h, -n, -u, -p`

	# sh .myt -ed -n db_name -u username -p password

if you have an existed database, just configure the file `cfg.php` for connecting.



Backup
============

1 backup your db, such as

	# mysqldump --database cms_db > others/db_xxx.sql

2 backup the dir, such as

	# tar -cvf others.tar others/

untar

	# tar -xvf others.tar

Notice, all of files of the system created that will be stored in directory `others`, 
such as the `others/upload/*`, `cfg.php`, `access.php`. e.g.
just backup the others dir is enough.



License
============

[MIT](https://opensource.org/licenses/MIT)




