Game List 1.0

This is a ncaster module for displaying a list of articles.
* features the ability to assign a link template.

=======================================
Linking to a Game List
=======================================
example to list the catogory news as a list.
<a href="http://yourhost.com/view.php?load=gamelist&c=news">News Game list</a> 

======================================
Making a link Template
======================================
Link templates are supported in some addons, they accept tags used in news styles
so you can include stuff like <!--username--> #your username or <!--subject--> # the subject

Open index.php up in this folder.
find
$template = '<a href="<!--url_dynamic-->"><!--subject--></a> - <!--news_desc--><br>'; // please enter a style

Now you can replace the template in this string.