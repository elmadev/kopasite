=====================================================================
                     Welcome to Elasto Mania!

   A motorbike simulation game based on a real physical model.

                     Registered version 1.11

                 Copyright (C) 2000 Balazs Rozsa.
=====================================================================

Do not distribute!

=====================================================================

SYSTEM REQUIREMENTS

	Microsoft Windows 95/98/2000
	DirectX 5.0
	Pentium 133MHz
	16MB RAM
	4MB Hard Disk

=====================================================================

INSTALLATION

To install Elasto Mania run the self installing EXE file and follow
the instructions.

The game requires DirectX 5.0 or later installed on your system.
If you don't have this, you can download it from:

	www.microsoft.com/directx

The best times of the internal levels are stored in the file
state.dat. If you had the shareware version of Elasto Mania 1.0
before this registered version, you can copy your state.dat file
from the folder of your shareware version of the game to the folder
of this registered version. In this way you will transfer your
times from the first 18 levels to the registered version.

=====================================================================

ELASTO MANIA'S HOME PAGE

Visit our web site for free external levels, competitions and the
latest version at: www.elastomania.com

We also have a links page where you can find a lot of links to fan
sites for the game.

If you have any questions about the game, please send an email to:
balazs@elastomania.com

=====================================================================

HOW TO PLAY THE GAME

You have to ride a motorbike and complete the various stages. You
can get to the next level only by completing the previous one
successfully. You can skip five levels in total, but you can
go back and complete a previously skipped level later. You can
choose to play on any of the levels you have previously completed.
For all stages the best ten times are recorded along with the name
of the player. The levels become progressively more and more
difficult to complete.

To control your motorbike while playing, you use the following
keys (unless you have customized the controls in the Options menu):

UP arrow: accelerate (this puts a constant degree of force on the
	rear wheel).
DOWN arrow: block both wheels.
RIGHT arrow: turn the bike clock-wise.
LEFT arrow: turn the bike anticlock-wise.
SPACE: turns your bike around so you can go in the opposite
	direction.

During the various stages there are several objects that appear on
the screen. You can contact an object by touching it with your
helmet or any of your wheels.
The three different object types are:

- FOOD object: You have to touch all of these before you can
	accomplish a level. If you touch it, it will disappear.
	(Though the food objects are moving vertically, the invisible
	circles you have to touch in order to eat them are not. If
	this bothers you, please turn off their moving under Options
	from the Main menu!)
- KILLER object: You will die if you touch it.
- EXIT object: You can finish the level by touching it. (It works
	only if you have already collected all of the food objects).
	The exit object is a flower.

---------------------------------------------------------------------

Setting the look of the display

You can toggle on/off the visibility of the little view window by
pressing the 'v' button while playing or replaying. And with the
't' button you can do the same with the time display. (These two
settings are stored separately for the play and the replay modes.
For play mode the default is off, for the replay mode it is on.)

If the frame rate on your machine is low, you can press the '-'
button while playing in order to reduce the size of the screen.

---------------------------------------------------------------------

Multiplayer game

The multiplayer mode is a split-screen two-player mode. You can
play in a co-operative way in order to make a good time, or against
each others trying to eat more food than your opponent.

In the Flag Tag mode you compete to have the flag on your bike
for more time than it is on your opponent's bike.

The flag starts on biker A and biker B by turns. To get the flag,
you have to touch the wheels of the other bike with your wheels.
The head doesn't work for this. After capturing the flag, it
flashes for a short while, until the two bikes get a minimum
distance apart. During this time the flag cannot be recaptured
again.

=====================================================================

THE EDITOR

Getting help about the editor

To get help about the various editor functions you should enter
the editor and right click with the mouse on the particular buttons
you want help for.
That is the main help for the editor, but you should read the rest
of this file also to get a better understanding how the editor
works.

---------------------------------------------------------------------

The editor screen

On the left of the editor screen is a column of buttons. The
buttons in the upper half are command buttons, which means they
will take action at the moment you click on them with the left
mouse button. The buttons in the lower half are the tool selection
buttons. If you click on them with the left mouse button, you
select a tool. You can use a tool in the working area of the
screen. A one line help of the current tool is always displayed
at the top of your screen.

You can get help on the command and tool selection buttons by
clicking on any of them with the right mouse button.

---------------------------------------------------------------------

Getting started with the editor

When you start working with the editor, I suggest that you work
only with simple polygons and don't work with pictures nor with
'grass' polygons. Only after you are familiar with the polygon
aspect of the editor, should you begin to work with pictures.

The following information about the editor is mainly in connection
with putting graphic objects onto the levels.

---------------------------------------------------------------------

What file types uses the program for the levels

When you play a level, the topology of the polygons and the
placement of the objects and pictures (like the trees) come from a
level file (with the extension of '.lev' in the LEV subdirectory).
But this file doesn't contain any graphics, like the texture of the
background, the pictures of the trees, or the apples you have to
gather. The graphics are stored in a separate file with the
extension of '.lgr' in the LGR subdirectory. The level file
contains only the name of the lgr file. In this way you can have
many level files using one .lgr file, thus saving a lot of disk
space because the .lgr files are usually much bigger than the level
files. Actually all internal levels of the game use one lgr file,
default.lgr.

If you load a level file to play or to edit it, and there is no LGR
file with the name that is specified in the level file, the
default.lgr file will be used instead. Probably the names of the
pictures in the level and LGR file won't match, so the non-matching
objects won't appear on the screen when you play and will be
removed from the level file if you load it into the editor and save
it.

The game works only with maximum 8 character long .lev, .rec and
.lgr file names (plus extension).

---------------------------------------------------------------------

Making your own LGR files

For editing the level files you can use the built-in editor. But
you can not change the LGR files with the editor. If you want to
add pictures to an LGR file, you have to use a command line
program, make_lgr.exe. This program is not part of the game, you
have to download the LGR Development Kit separately from our site
(www.elastomania.com). It is available for free and the same
Development Kit can be used for the shareware and registered
versions also.

Since this Development Kit is not part of the game, I did not put
as much effort into making it easy to use, and polishing it as I
should have. I only made it available for the public so that those
who want to include their own graphics into the game can do this,
if they are willing to spend time understanding exactly how this
program works. They should have prior knowledge about manipulating
image files, using color palettes and using DOS command line tools.

---------------------------------------------------------------------

Working with pictures

Pictures don't affect the way you ride your bike on a level, they
are only there to make the level look nicer.

There are two kind of pictures: normal pictures and masks with
textures. The bushes, trees and all objects are normal pictures.
In most cases you will create normal pictures and very seldom will
you use masks with textures.

With the Create Picture tool you can create new pictures. Just
click the left mouse button where you want to place the selected
picture.

But first you must select a picture by clicking the right mouse
button anywhere above the working area. A dialog will appear with
three fields: normal picture, mask and texture. You can either
select a normal picture, or select a mask with a texture.
If you select a mask or a texture alone, you won't be able to put
it into your level. I suggest that you only use normal pictures
and don't bother with Masks or Textures too often.

---------------------------------------------------------------------

Properties of pictures

Every picture has two properties: distance and clipping.

    - The distance determines which pictures hide the others. The
    range of the distance property is 1-999. The distance of the
    biker and the apple and flower objects is 500.

    - The clipping property determines if the picture is visible
    above the ground or the Sky. The clipping property has three
    states:
        S-Sky: Only those parts of the picture are drawn that are
                    in the sky.
        G-Ground: Only those parts of the picture are drawn that
                    are in the ground.
        U-Unclipped.

    Most pictures are set to the S-Sky clipping property, so their
    parts that are underground are invisible.

---------------------------------------------------------------------

Grass polygons

Most of the time the top of the ground is a bright green band on
which you can roll with the bike. To put this band there you need
grass polygons. A grass polygon is a separate polygon that makes
the region above its line grass textured. It may be a bit confusing
how it should be placed. The quickest way to understand how it
works is examining the example level file, tutor2.lev. Load it into
the editor, play on it and take a look how it is implemented in the
level design (you can use the View Options button to display only
the grass polygons to see it better).

You can change a normal polygon into a grass polygon or vice versa
by right-clicking near a vertex with the Move tool and check the
property in the dialog.

The trickiest part is that a grass polygon always has an inactive
line. This line is the one that is longest in the x direction. The
other lines determine the lower border of the grass (the upper
border is determined by the normal polygons). The inactive line
looks the same in the editor as the other lines, you only know
which one it is from the fact that it is the longest line
horizontally.

=====================================================================

ADVANCED FEATURES

Exporting the best times statistic

When the game quits it writes a stats.txt file in which it lists
the best times for all levels. At the end of this file it
calculates various total times.

---------------------------------------------------------------------

Merging best times from two games

If you and your friend for example have two copies of the game on
two different computers, you can merge your best times by copying
one state.dat file from one computer to the directory of the game
on the other computer by the name, 'merge.dat'.
Each time the program starts it looks for the file merge.dat and if
it finds one, it merges its best times information into state.dat.
(One best time won't be imported multiple times into state.dat even
if you leave merge.dat in the game directory and start the game
many times.)

You cannot merge a registered state.dat file into the shareware
version.

---------------------------------------------------------------------

Removing somebody from the player list

If you want to remove somebody from the player list, go to Options,
choose Player A or B, then move the selection to the player you
want to remove. Press Ctrl-Alt Enter and it will be removed (at
least one player always has to be on the player list).

---------------------------------------------------------------------

Find out the time of a rec file

If you want to find out the time of a rec file without opening it,
go to Replay from the Main Menu, move the selection to the rec file
and press Ctrl-Alt Enter. The time of the rec file will be given to
you even if it was not finished.

=====================================================================

TROUBLESHOOTING INFORMATION

The sound best quality mode may cause problems. If this occurs,
please choose the compatibility mode.

The game may run on some NT systems with DirectX 3.0, but it may
not be reliable. The game may freeze, the sound may not work and
the framerate may be low. You should only try this on your own
risk.

=====================================================================

ACKNOWLEDGEMENT

I would like to thank the following people for helping to create
this game:
Csaba Rozsa, my brother, designed more than half of the levels, 
maintains the WWW homepage of the game and the Best Times table.
Geza Szabo helped me to draw most of the graphics.
Mate Magyar made the animated objects, most of the textures and
level 'Bowling'. He also suggested the idea of Flag Tag.
Eszter and Bori Paris also helped with the graphics.
Dylan Cooper gave me linguistic help for all written text in the
game and gave most of the levels their names.
Peter Illyes, Graham Mitchell and Imre Barczi helped me a lot 
with technical issues.
Gabor Gerenyi gave me most of the sound samples.
Tamas and Andris Kristyan helped me to record some sound effects
for the game.

The following persons tested the levels:
Csaba Fekete, David Hoover, Jennifer Hoover, Andris Kristyan,
Tamas Kristyan, Csaba Limbek, Csaba Magyari, Akos Nemeth Buhin,
Andras Torok.

=====================================================================

ASP OMBUDSMAN INFORMATION

Balazs Rozsa is a member of the Association of Shareware
Professionals (ASP). ASP wants to make sure that the shareware
principle works for you. If you are unable to resolve a
shareware-related problem with an ASP member by contacting the
member directly, ASP may be able to help. The ASP Ombudsman can
help you resolve a dispute or problem with an ASP member, but does
not provide technical support for members' products. Please write
to the ASP Ombudsman at 157-F Love Ave., Greenwood, IN 46142 USA,
FAX 317-888-2195, or send email to omb@asp-shareware.org.

=====================================================================

COPYRIGHT INFORMATION

Elasto Mania and all the file formats the program produces are
Copyright (C) 2000 Balazs Rozsa. All rights reserved.

=====================================================================

LEGAL STUFF

No portion of this software may be disassembled, reverse
engineered, decompiled, modified or altered.

This Software is supplied "as is" and no liability will be
accepted by Balazs Rozsa or any legal vendors of this software for
any damage incurred by the use of this software.

Neither directly nor indirectly you cannot rent, sell, lease, lend,
reproduce, copy or distribute by any means this software.

Disclaimer: Elasto Mania is supplied "as is" and no claims are made
as to it's suitability for any purpose, if any. Users installing
this software do so on such an understanding and also that the
limit of liability of the publisher or his agent is limited to the
price paid for the program alone.

=====================================================================