<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>CSV Ninja</title>
    <link rel="stylesheet" href="mainStyle.css">
    <style type="text/css">

    div#infoLeft {
    box-sizing: border-box;
    padding: 14px;
    size:11px;
    width: 50%;
    float: left;
    height: auto;
    border-right:solid 1px;
    overflow:hidden;
    }
.clear{
    clear:both;
}

    div#infoRight {
    box-sizing: border-box;
    padding: 10px;
    height: auto;
    margin-left: 50%;
    overflow:hidden; 
        
    }
    section {
        width: 80%;
        margin: auto;
    }
    div#end{
        height: auto;
        position: relative;
    }

    </style>
</head>
<body>
<div id="tBar"><?php require("title.php");?></div>
<section>
<div id="infoLeft">

<h1>CSV Ninja! <em>Start with a map and end up with data!</em></h1>
<em>If you want to shoot off and start right now just pick a link on the right. I'm sure you'll figure it out</em><br>

<p><h2>For a bit more information keep reading</h2>
<p>This is a map based data extraction tool. I have placed <a href="http://www.abs.gov.au/">Australia Bureau of Statistics (ABS)</a> Census Datapacks in an reasonably simple database. 
<p>And I've put this up in the <em>cloud</em> on an <a href="https://aws.amazon.com/">AWS EC2 instance.</a>
<p>I haven't changed the data in any way. I did join a few tables which were split up. But the numbers are all the same.
<p>Not to take away from my own efforts but all I really did was wrap up CSV files in a MySQL DB in a semi simple program that allows you to select an area and then get data based on you selection.

<p><h2>A quick how to and some notes on the future</h2>
<ul>
    <li>Pick a dataset.</li>
    <li>Pick some fields that you want info on</li>
    <li>Explore the map </li>
    <li>The select an area of interest to you at a resolution that interests you</li>
    <li>the just hit 'Get CSV'</li>
</ul>
<p>At that last step you'll get a new window with a bunch of data based on the fields you selected and the area you highlighted.
<p>Do this a couple of times for different fields on the same area and you can then use the results in some other application like R, SAS, SPSS, Excel :p etc, to do more complex analysis.
<br><p>CSV Ninja is just the first step. The next thing for me to work on is too pipe data from this into graphing and visualization tools like <a href="https://d3js.org/">D3 - Data-Driven Documents</a> 
<p>Also on the cards after some more thinking is a custom R package which will do thematic mapping and other cool tricks while making the dataset available via an API. 

<p><h2>How this came together</h2>
<p>I got bored, so I tried to stay productive and learn a few new things and extend myself somewhat.  

This is a list of the technologies and services and applications that are involved building and running this site. 

<ul>
    <li><a href="http://php.net/">PHP 7 for the server side scripting</a> </li>
    After c++, php is like a holiday for your mind. This was (I'm afraid to say) my first time writing in a weakly typed language. My big takeaway was it's easy to get stuff working but hard to get stuff right. 
    <p>
    
    <li><a href="https://developers.arcgis.com/javascript/3/jshelp/">The ESRI JS GIS framework</a></li>
    There are a lot of choices when it comes to mapping on the web. For me the choice came down to the amount of friction that I wanted to endure with integrating the ABS map server endpoints with my little app. 
    The ABS use ArcGIS servers so the easiest step for me to take was to just double down on the ESRI technology stack. That may sound like a disadvantage but it isn't. ESRI really lead the way with features in this space. For simple maps like where a 
    shop is and the like <a href="http://leafletjs.com/">Leaflet maps</a> or google or bing maps work but ESRI has a lot of options and a lot of support if you're starting out. In addition to the ESRI site and numerous Stack Overflow pages I also got my feet wet in the framework with the following book <a href="https://www.amazon.com/ArcGIS-Web-Development-Rene-Rubalcava/dp/1617291617">ArcGIS Web Development by Rene Rubalcava</a>. This book wasn't super useful in the creation of this site specifically but it did provide a foundation which I found helpful. So that was $30 well spent. 
    <p>
    <li><a href="https://www.mysql.com"/>MySQL 5.6 on AWS</a></li>
    If there's one common theme to my choices so far it's price. MySQL is cheap (0$) and if your having a problem with it then so is someone else. 
    The database for this application holds about ~1.3 gig of integer data in 46 tables with about ~7000 columns. This is really easy for a DB like MySQL. Couple that with PHP and things are just easy.
    <p>In addition to these reasons I also used MySQL because I've been doing some other work with it using its spatial functions. In version 5.6 and now 5.7 there are <a href="https://dev.mysql.com/doc/refman/5.7/en/spatial-analysis-functions.html">DB imbedded spatial functions.</a> With other apps I've built I have explored these features in some detail. At this stage they are a little immature but here's hoping. 
    <p>
    <li><a href="https://aws.amazon.com/">Amazon Web Service Elastic Compute cloud service (the free tier)</a></li>
    I looked at a few different hosting options for this site. Again the big issue was cost. Amazon will give new customers a bit of cloud for a year for free! Google and Microsoft also do similar stuff so at the end of my year with AWS I may just port my little app sideways around the market :).
    <p>
    AWS is a big topic. I was initially just going to do a S3 bucket and a static site but EC2 is very simple and its a steal for under a $1 a year. Also Ubuntu Server images!

    <li><a href="https://www.nginx.com/">Nginx on AWS for the web server</a></li>
    So it used to be the LAMP stack for web development. I just replaced the A (Apache Web Server) with Nginx, which is just a lighter simpler webserver.
    <p>
    <li><a href="https://www.ubuntu.com/">Ubuntu Server</a></li>
    Early last year I jumped ship from OSX onto linux, specifically Ubuntu. It's simple, ubiquitous and it just works. Also the difference between the desktop and the server OS is negligible. I run Nginx on my laptop for development and nothing changes in settings when moving content forward.
    <p>
    <li><b>paste, split, cat</b></li>
    These three are linux command line tools. I used Paste to concatenate datafiles together, in retrospect the tool Join would have been better. Anyway this was needed because certain datasets have a greater number of columns that Excel 2004 can handle (Backwards compatibility :( ) So I mashed these files together to just have one really large table. MySQL can handle tables with sixteen thousand columns and at most I have just under 400 in the largest table.
    <p>Split is super useful for splitting up large files. When I exported my finished database and compressed it, it came to about 300MB. Which isn't that big, but I have crap internet. So uploading 300 1mb chunks to AWS was way easier than attempting to get some decent bandwidth for a single 300mb upload.
    <p>Cat is the reverse of split. It puts the broken egg back together.
    <p>
    <li><a href="http://www.loading.io/">Loading.io</a></li>
    When the map is loading there is a little spinning box gif. Thanks loading.io.
    <p>
    <li><a href="http://www.abs.gov.au/">The data and map services came frome the ABS.</a></li>
    Specifically the data for CSV ninja is that which is contained in the ABS Census DataPacks for the Basic Community Profiles Short Headers. Everything is there if you want to spin up your own DB or get the whole stash
    <p>
</ul>

<p><h2>The tricky parts of doing all this. And things I learned along the way!</h2>
<ul>
    <li>Building the database in a simple fashion</li>
    <li>Finding a few limitations in the ESRI JS API</li>
    <li>Many, minor annoyances with CSS and the ESRI Framework</li>
</ul>
<h3>The DB</h3>
The DB was tricky to get correct. Eventually the solution was so simple I found I could generate a schema for 46 tables in about ~30 minutes with SQL developers assistance.
The big problem I had was that the datasets covers a range of levels (resolutions). So essentially there is s ton of duplication in the dataset. You have ~7000 columns where each column can been examined in a different level of detail. So in the Australia level dataset there is only one row with totals for everything. The flip side of this is that on the other end you have SA1 tables where you have ~7000 columns by ~54000 rows. And all the column totals sum up to the same as that top level Australia dataset.
<p>
It made sense to me to initially approach the problem with one set of tables at the SA1 level and then aggregate up using a table that had a relationships between each of the levels of detail. I would've really been leaning on the GROUP BY function to bring the magic using the approach. I actually decided against this because the amount of data in the SA1 dataset dwarfs all the others combined. So just putting all the levels into the same tables, split by the ~46 individual datasets you see on your left is simpler.
It also happened that the ArcGIS Map layers hold geographic codes that correspond to the region_id of the table so after checking very carefully I was able to run an inline data import into mysql where about 828 CSV files were imported with the region_ids being the primary keys of the tables without any clashes or errors.
<p>
<h3>The ESRI ArcGIS JS API</h3>
The ESRI Javascript front end is built to work really well with the ESRI backend. When you divert from this sort of setup things get tricky. 
And this is the way I went. My issues with the framework arn't really ESRI's fault but more the regular software integration troubles.
<p>
A quick overview of my integration woes:<p> ESRI provide the full stack; Front end, DB, Servers, great tooling and tons of SDKs for different platforms. 
So by trying to use half of it I hit a snag when I wanted to use some API features. 
A big one I am a little sore about that I hope will be fixed in the future is the <a href="https://developers.arcgis.com/javascript/3/jssamples/smartmapping_classesbycolor.html">SmartMapping Renderers</a> 
that the JS framework offer. I had initially wanted to start down the path of data visualization a little earlier and provide a way to interact with thematic mapping. 
My failed approch was to do a sql lookup for some selected features and then generate a set of feature nodes with the returned value that I could apply to the active layer. 
At this point I hoped I could use the SmartMapping Color Renderer to produce a thematic map.  It didn't work out so well. Actually it just didn't work. 
That could be my limitations as a programmer...but I suspect that the feature is best suited for when you have an ESRI Map Server of your own and you can build your data into your Feature Layers as is expected. 
The option of using a class breaks render were explored but this would mean more processing on the server side. Whilst I'm not opposed to doing this it was a question of "effort in VS value out". And creating accurate class breaks rendering in PHP was more work than I wanted to do that this point.
<p>
The next issue was less an integration issue but more an availability/size/optimization issue. 
If you're like me and have crap internet then you probably tend to avoid sites that are needlessly content heavy with auto playing videos or articles written in pictures instead of text. 
<p>These days the average size of a webpage on the internet now is around 2MB. Unfortunately this site is no different. 
When you go play with the data viewer there is CORS (Cross Origin Resource Sharing requests) occurring. 
The technology that drives the maps comes from a CDN (Contend Delivery Network). So that's the basemap images of the streets and the javascript that runs the interactive parts ot the webpage. 
Because of the API features involved in viewing the maps and selecting areas dynamicly, the size of the webpages starts to grow fairly rapidly. 
<p>
ESRI offer a Javascript Optimizer. It reads your code and then custom generates a cut down API for you to host on your own site so you don't have to use the CDNs for their API. 
I had a red hot go at this and I did get a slightly smaller page but the flip side was that I (my AWS EC2 instance) would then be a single point of distribution for the code that ran my site. 
So any delay on my connection would directly affect all downstream connections as I would be the sole provider or the details of my webpage.
 By using the generic APIs that ESRI CDN's provide all I have to do is provide is a shell of a webpage and its the user who pulls in the code from external sources as needed. 
 This is mostly a concern for really small players like myself who have their little piece of the internet on a single machine. For other the Web Optimizer makes sense.
<p>
<h3>CSS: Just trying to keep it simple</h3>
So there is the funny bug (Maybe?) with the ESRI map div object. If you pop it in a div and then give it a height like 80% via css. 
For it to work it requires all higher level elements to have their own height defined. Otherwise it defaults to something around 400px high. 
This is ok, But it gets a little tricky when you have page and set it to 100% then then the title div to float to the top and then you make a content container for underneath this. 
For some reason if you set these heights to be 100% the logic goes (wait...I could be wrong. Infact it feels like I'm wrong but anyway). 
<p>
The logic goes that the content div should take up 100% of the remaining space until the end of the screen or the end of content should be at the bottom of the screen if a scroll bar is needed. 
The ESRI map seems to pick up the 100% size and just takes the initial body size and fills that. It totally ignores any other divs or elements above it. 
So the maps becomes bigger than this visible space and to see it you have to scroll down. The solution is to set the content div height at around 98% or so (I'm again feeling like im doing something a little hacky here'). 
And then make everything just slightly smaller than 100%. After this is done the map behaves just like you would expect and fits into the page and there's no scroll bar. 
Maybe I hit some edge case, but I suspect that its because I decided to not use the Dojo framework for content layouts that ESRI provide. Again, integration issue abound.
<p>
Thats about everything that went into putting this simple little app together. 
The next step as I mentioned above is to work on piping the data from this into visualization tools that will make the pretty pictures :) I'm also thinking about an API.'

-Gabe.

</div>

<div id="infoRight">
    <h3><p><em>To Start just Pick a dataset from this list</em></h3>

<table>								
<tr style="font-weight: bold;"><td>#</td><td>datasets</td></tr>
<tr><td rowspan="2">1</td><td><a href="/picker.php?table=B01">Selected Person Characteristics by Sex</a></td></tr>
<tr><td>Persons</td></tr>
<tr><td rowspan="2">2</td><td><a href="/picker.php?table=B02">Selected Medians and Averages</a></td></tr>
<tr><td>Medians and Averages of other Tables</td></tr>
<tr><td rowspan="2">3</td><td><a href="/picker.php?table=B03">Place of Usual Residence on Census Night by Age</a></td></tr>
<tr><td>Persons</td></tr>
<tr><td rowspan="2">4</td><td><a href="/picker.php?table=B04">Age by Sex</a></td></tr>
<tr><td>Persons</td></tr>
<tr><td rowspan="2">5</td><td><a href="/picker.php?table=B05">Registered Marital Status by Age by Sex</a></td></tr>
<tr><td>Persons aged 15 years and over </td></tr>
<tr><td rowspan="2">6</td><td><a href="/picker.php?table=B06">Social Marital Status by Age by Sex</a></td></tr>
<tr><td>Persons aged 15 years and over </td></tr>
<tr><td rowspan="2">7</td><td><a href="/picker.php?table=B07">Indigenous Status by Age by Sex </a></td></tr>
<tr><td>Persons</td></tr>
<tr><td rowspan="2">8</td><td><a href="/picker.php?table=B08">Ancestry by Birthplace of Parents</a></td></tr>
<tr><td>Responses and persons </td></tr>
<tr><td rowspan="2">9</td><td><a href="/picker.php?table=B09">Country of Birth of Person by Sex</a></td></tr>
<tr><td>Persons</td></tr>
<tr><td rowspan="2">10</td><td><a href="/picker.php?table=B10">Country of Birth of Person by Year of Arrival in Australia</a></td></tr>
<tr><td>Persons born overseas</td></tr>
<tr><td rowspan="2">11</td><td><a href="/picker.php?table=B11">Proficiency in Spoken English/Language by Year of Arrival in Australia by Sex</a></td></tr>
<tr><td>Persons born overseas</td></tr>
<tr><td rowspan="2">12</td><td><a href="/picker.php?table=B12">Proficiency in Spoken English/Language of Parents by Age of Dependent Children</a></td></tr>
<tr><td>Dependent children in couple families</td></tr>
<tr><td rowspan="2">13</td><td><a href="/picker.php?table=B13">Language Spoken at Home by Sex</a></td></tr>
<tr><td>Persons</td></tr>
<tr><td rowspan="2">14</td><td><a href="/picker.php?table=B14">Religious Affiliation by Sex</a></td></tr>
<tr><td>Persons</td></tr>
<tr><td rowspan="2">15</td><td><a href="/picker.php?table=B15">Type of Educational Institution Attending (Full/Part-Time Student Status by Age) by Sex</a></td></tr>
<tr><td>Persons attending an educational institution </td></tr>
<tr><td rowspan="2">16</td><td><a href="/picker.php?table=B16">Highest Year of School completed by Age by Sex</a></td></tr>
<tr><td>Persons aged 15 years and over who are no longer attending primary or secondary school.</td></tr>
<tr><td rowspan="2">17</td><td><a href="/picker.php?table=B17">Total Personal Income (Weekly) by Age by Sex</a></td></tr>
<tr><td>Persons aged 15 years and over </td></tr>
<tr><td rowspan="2">18</td><td><a href="/picker.php?table=B18">Core Activity need for Assistance by Age by Sex</a></td></tr>
<tr><td>Persons </td></tr>
<tr><td rowspan="2">19</td><td><a href="/picker.php?table=B19">Voluntary Work for an Organisation or Group by Age by Sex </a></td></tr>
<tr><td>Persons aged 15 years and over </td></tr>
<tr><td rowspan="2">20</td><td><a href="/picker.php?table=B20">Unpaid Domestic Work:  Number of Hours by Age by Sex </a></td></tr>
<tr><td>Persons aged 15 years and over </td></tr>
<tr><td rowspan="2">21</td><td><a href="/picker.php?table=B21">Unpaid Assistance to a Person with a Disability by Age by Sex</a></td></tr>
<tr><td>Persons aged 15 years and over </td></tr>
<tr><td rowspan="2">22</td><td><a href="/picker.php?table=B22">Unpaid Child Care by Age by Sex</a></td></tr>
<tr><td>Persons aged 15 years and over </td></tr>
<tr><td rowspan="2">23</td><td><a href="/picker.php?table=B23">Relationship in Household by Age by Sex</a></td></tr>
<tr><td>Persons in occupied private dwellings</td></tr>
<tr><td rowspan="2">24</td><td><a href="/picker.php?table=B24">Number of Children Ever Born by Age of Parent</a></td></tr>
<tr><td>Females aged 15 years and over</td></tr>
<tr><td rowspan="2">25</td><td><a href="/picker.php?table=B25">Family Composition</a></td></tr>
<tr><td>Families and persons in families in occupied private dwellings</td></tr>
<tr><td rowspan="2">26</td><td><a href="/picker.php?table=B26">Total Family Income (Weekly) by Family Composition</a></td></tr>
<tr><td>Families in family households</td></tr>
<tr><td rowspan="2">27</td><td><a href="/picker.php?table=B27">Family Blending</a></td></tr>
<tr><td>Couple families with children</td></tr>
<tr><td rowspan="2">28</td><td><a href="/picker.php?table=B28">Total Household Income (Weekly) by Household Composition</a></td></tr>
<tr><td>Occupied private dwellings</td></tr>
<tr><td rowspan="2">29</td><td><a href="/picker.php?table=B29">Number of Motor Vehicles by Dwellings</a></td></tr>
<tr><td>Occupied private dwellings</td></tr>
<tr><td rowspan="2">30</td><td><a href="/picker.php?table=B30">Household composition by Number of Persons Usually Resident</a></td></tr>
<tr><td>Occupied private dwellings</td></tr>
<tr><td rowspan="2">31</td><td><a href="/picker.php?table=B31">Dwelling Structure</a></td></tr>
<tr><td>Occupied and unoccupied private dwellings and persons in occupied private dwellings</td></tr>
<tr><td rowspan="2">32</td><td><a href="/picker.php?table=B32">Tenure Type and Landlord Type by Dwelling Structure</a></td></tr>
<tr><td>Occupied private dwellings</td></tr>
<tr><td rowspan="2">33</td><td><a href="/picker.php?table=B33">Mortgage Repayment (Monthly) by Dwelling Structure</a></td></tr>
<tr><td>Occupied private dwellings being purchased</td></tr>
<tr><td rowspan="2">34</td><td><a href="/picker.php?table=B34">Rent (Weekly) by Landlord Type</a></td></tr>
<tr><td>Occupied private dwellings being rented</td></tr>
<tr><td rowspan="2">35</td><td><a href="/picker.php?table=B35">Type of Internet Connection by Dwelling Structure</a></td></tr>
<tr><td>Occupied private dwellings</td></tr>
<tr><td rowspan="2">36</td><td><a href="/picker.php?table=B36">Dwelling Structure by Number of Bedrooms</a></td></tr>
<tr><td>Occupied private dwellings</td></tr>
<tr><td rowspan="2">37</td><td><a href="/picker.php?table=B37">Selected Labour Force, Education and Migration Characteristics by Sex</a></td></tr>
<tr><td>Persons</td></tr>
<tr><td rowspan="2">38</td><td><a href="/picker.php?table=B38">Place of Usual Residence 1 Year Ago by Sex</a></td></tr>
<tr><td>Persons 1 year and over</td></tr>
<tr><td rowspan="2">39</td><td><a href="/picker.php?table=B39">Place of Usual Residence 5 Years Ago by Sex</a></td></tr>
<tr><td>Persons 5 years and over</td></tr>
<tr><td rowspan="2">40</td><td><a href="/picker.php?table=B40">Non-School Qualification:  Level of Education by Age by Sex</a></td></tr>
<tr><td>Persons aged 15 years and over with a qualification</td></tr>
<tr><td rowspan="2">41</td><td><a href="/picker.php?table=B41">Non-School Qualification:  Field of Study by Age by Sex</a></td></tr>
<tr><td>Persons aged 15 years and over with a qualification</td></tr>
<tr><td rowspan="2">42</td><td><a href="/picker.php?table=B42">Labour Force Status by Age by Sex</a></td></tr>
<tr><td>Persons aged 15 years and over </td></tr>
<tr><td rowspan="2">43</td><td><a href="/picker.php?table=B43">Industry of Employment by Age by Sex</a></td></tr>
<tr><td>Employed persons aged 15 years and over </td></tr>
<tr><td rowspan="2">44</td><td><a href="/picker.php?table=B44">Industry of Employment by Occupation</a></td></tr>
<tr><td>Employed persons aged 15 years and over </td></tr>
<tr><td rowspan="2">45</td><td><a href="/picker.php?table=B45">Occupation by Age by Sex</a></td></tr>
<tr><td>Employed persons aged 15 years and over </td></tr>
<tr><td rowspan="2">46</td><td><a href="/picker.php?table=B46">Method of Travel to Work by Sex</a></td></tr>
<tr><td>Employed persons aged 15 years and over </td></tr></table>


</div>
<div class="clear"></div>
<hr>
<blockquote>I made this and that. Code is on my <a href="https://github.com/gabesargeant">github account gabesargeant.</a> 
    <p>- G.Sargeant
    - gabe.sargeant@gmail.com
</blockquote>
</section>


</body>
</html>
