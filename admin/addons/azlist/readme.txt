==================================================
A-Z List Module 1.7
==================================================
What does the azlist module do?
sorts your articles, each article is sorted in to the letter it starts with. 

example.
your articles subject is (hey world)
this article then whould be listed in the letter h.

when your article starts with a number or special charactor it is then indexed in (.

Main Features
===================
* Entity 2.0 support
* Ability to html skin table start, table end, azlist template style and the azindex.
* Custom fields.
* Custom field filtering.

Updates
===================
This version has been rewrote it now runs faster and the code is a great deal cleaner.


=======================================
Loading the azlist module
=======================================
To load call view.php in your browser followed by the query load=azlist
view.php?load=azlist

To select a category.
view.php?load=azlist&c=category

To get all articles with the letter a
?view.php?load=azlist&num=a

Filter with a custom category, lets say the name of the field is score
?load=azlist&f_score=4
this whould then show all results that match 4.

=============================
Customising the appearnce.
=============================
azlist supports the ncaster template naming system, the template naming system this allows you to 
style hard to get places with relative ease.

azlist uses all the following style names
style, table_start, table_end

you can overwrite the defalt syles by going in to ncaster and creating a new template where it says
template title insert
module:azlist{category:yourcategory}{the style name};
or
module:azlist{the style name};

example: 
module:azlist{style}