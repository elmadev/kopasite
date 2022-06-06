<?php

echo "<p class='head red pad'>cupSource</p><div class='footer'></div>\n";
echo "<p class='pad'>A content management system made in PHP and MySQL which you can install into your webserver and can be used to arrange Elasto Mania Cups.</p>";
echo "<p class='pad'><a href='http://cup.sshoyer.net/cupSource1.09.rar'>Download release v1.09</a></p><br/>";
echo "<p class='pad'>You don't need any php/mysql knowledge to use it, but just ftp to upload it and some mysql admin tool like PHPMyAdmin to administrate it. Also recommended to change the graphics so the sites doesn't look alike.<br/>
<br/>
When installed you can add news/events, change welcome and rules texts and timezone via PHPMyAdmin. You can make any number of events and as admin see results during the event.<br/>
<br/>
Standings are made on the fly every time the page is accessed so you can delete events/times and standings will be updated with those changes.<br/>
<br/>
I've tried to make it rather simpel and it doesn't have that many features yet, only the basic, like no team/national stats, but it's made so it's possible to add. Feel free to make any changes yourself. I will update here ofcourse if I make any improvements.</p><br/>";
echo "<p class='pad'>1. Requirements<br/>
A webserver that supports PHP.<br/>
A MySQL database.<br/>
Some Mysql admin tool like \"PHPMyAdmin\".<br/>
<br/>
<br/>
2. Graphics<br/>
First of all you should change the pictures to get your own design.<br/>
You can also change the main.css file to get different font ect.<br/>
<br/>
<br/>
3. Install<br/>
a. Open db.php and change the mysql.host.com, login, pass, dbname to yours.<br/>
b. Copy all files to your webserver with ftp.<br/>
c. Run install.php with your browser. You should get a \"Install Succesful!\" message.<br/>
d. Delete install.php from the server.<br/>
e. Open the webside with your browser.<br/>
f. Create a user for yourself.<br/>
g. Go to your PHPMyAdmin.<br/>
g. i. Go to the cup_user table.<br/>
g. ii. Change the \"Rights\" field for your user to \"1\".<br/>
<br/>
<br/>
4. Usage<br/>
All the administration of the site will be made through PHPMyAdmin.<br/>
<br/>
Change texts: Change the 5 lines in cup_text to change the welcome text, rules, timezone, replay names and html title.<br/>
For welcome and rules you can use <br> to make a new line.<br/>
The default time zone depends on your server. The number in the timezone line is the number of hours that will be added to this time for the site's timezome. Leave it a 0 at first, then check the clock on the site and see if it fits you.<br/>
ShortName is what relays will be called before event number and nick.<br/>
LongName is what will be shown in the top bar on browsers.<br/>
<br/>
Add news: Insert new line in the cup_news table. Write KuskiIndex, Headline and News fields, leave others. You can see your KuskiIndex in the cup_user table.<br/>
<br/>
Add event: Insert new line in the cup_event table.<br/>
Event field decides the order of the events.<br/>
Start and End fields are the start and end time of this event.<br/>
Designer is the designer of the level.<br/>
LevelName is the full filename of the level, fx. \"TEH01.lev\".<br/>
Level: Here you can select browse... and find the level on your computer.<br/>
PublicResults can be used to decide when results are shown. If it's 1 results are show, if it's 0 they're not. Select 1 if you want results shown as soon as the event is over. Select 0 if you want to paste results in IRC first fx. and then change to 1 when you want them updated on the site.<br/>
AppleResult should be set to 1 if you want apple results in this event, otherwise leave it at default (0).<br/>
<br/>
cup_user: Can be used to change people's info.<br/>
<br/>
cup_time: Should not be touched, unless you find someone cheating or something and want to delete their times.<br/>
<br/>
To start a new cup just delete all the lines in all the tables.</p>";

?>