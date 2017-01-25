# csv_ninja

Hoi Hoi,

Read the index.php page for all the stuff thats usually in the git readme or have a glance 
at my ec2 instace thats running the show currently....

http://ec2-13-54-32-201.ap-southeast-2.compute.amazonaws.com/

As you are aware the files in this repo are pretty much what is up on that above instance. 
Whats missing? a php file called mysql.php which contains connection information to the db. 

This file is this:

<?php //login.php
$hn = 'localhost';
$db = 'mysql db name';
$un = 'username'; 
$pw = 'a password'
?>

So if you want to have a crack at copying the site in all its glory just...
1. > touch mysql.php
2. put all that above <php?...?> and the corresponding stuff in the right places. 


Lastly,
The DB is readonly, so i didn't use prepared statements. That makes the SQL safe because there are no
updates or inserts or delets but there is the possibility of DOS via rescursive sql. 

Hopefully that doesn't happen before I covert version 1.0 to version 1.1 where that has been sorted.

-Gabe Sargeant

