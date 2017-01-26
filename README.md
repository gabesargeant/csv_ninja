# csv_ninja

Hoi Hoi,

Read the index.php page for all the stuff thats usually in the git readme or 
have a glance at my ec2 instace thats running the show currently....

http://ec2-13-54-32-201.ap-southeast-2.compute.amazonaws.com/

As you are aware the files in this repo are pretty much what is up on that 
above instance. Whats missing? a php file called mysql.php which contains 
connection information to the db. 

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
The DB is readonly, so I didn't use prepared statements. That makes the SQL safe 
because there are noupdates or inserts or delets but there is the possibility of 
DOS via rescursive sql. 
Hopefully that doesn't happen before I covert version 1.0 to version 1.1 where 
that has been sorted.

More on the DB:

In the folder db_scriptsmisc ther eare misc scripts...
If you want to create a copy of the db the Census11AA.sql will create an empty
database for you. And don't worry i have removed the password that i use for the 
web use on my EC@ site.

So importing the data is easy. Have a look at the import queries sql file. And
more importantly, look at the merge script. Thats how i mashed things together.

The way to  use that is when unpack the ABS datapacks if you grab the whole of australia
basic community profiles you should have about 850 files. in 18 folders. Copy that script
into the 18 folders and then run it. it will merge the files as needed.

The clean.sh script will remove the excess files as needed.

Once the merge is done I put all the files into one folder and then logged into mysql 
and ran the command mysql> source importqueries.sql. about 5 minutes later 3.5 million rows
of data accross 46 tables was in a db at a size of 1.3 gig.

So those scripts and sql on its own should be enough to get up an running a fairly intersting
DB.

-Gabe Sargeant


MIT License

Copyright (c) [2016] [Gabriel Sargeant]

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
