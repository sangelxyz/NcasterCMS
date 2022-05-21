<?php
// language file.
// English
// by anihlator.
/** note.
  * for those who translates this file in to anouther language please send it to us
  * so we can distribute it on the ncaster website, the file will remail untouched
  * you may include your name, email and url in the header.
  */
// welcome message
$lan['welcome'] = "Welcome to ncaster, ${conf_user['username']}";


// Buttons
// added august 04, 2003
$lan['submit'] = 'submit';
$lan['reset'] = 'reset';

// settings/options
$lan['advancedsettings'] = 'From here you can change absolute paths and other advanced options.';
$lan['displaysettings'] = 'In here you can change anything from, the amount of articles to display on your news page, your date style and the ability to turn on Auto build.';
$lan['speedsettings'] = 'Speed settings allows you to turn off or enable features to increase speed.';
$lan['uploadsettings'] = 'All upload settings can be found in here. Settings range from filtering to where your upload folder is located.';
$lan['mysqlsettings'] = 'These settings are only for very advanced users only! These give you the ability to change settings like the mysql login password, username, host and the ability to change the database ncaster will use.';
$lan['uploadmanager'] = 'Here you can easily remove uploaded items.';
$lan['addstaff'] = 'Here you can add a new staff member account to NCaster.';
$lan['removemember'] = 'Remove a staff member from NCaster.';
$lan['addfields'] = 'Here you can add or remove a custom field.';
$lan['buildlist'] = 'Build list is a special function that allows you to out put files to include easily in to ssi pages ect. It has features such as the amount of articles to publish to the layout to style it with.';
$lan['editlayout'] = 'Want to Edit and delete layouts? From with in you can do just that.';
$lan['addfullpagel'] = 'Here you can add a new full page layout from with inside news caster';
$lan['adddisplayl'] = 'Here you can add a new news display template from with in side ncaster.';
// updated june 15
$lan['assignlayout'] = 'Assign template(s) to a category.';
$lan['render_settings'] = 'These rendering options allow you to fine tune the ncaster parser to get the results you want but keep the features you need, you can also change the suffix of the template tags among others. ';
//
$lan['buildnews'] = 'Update your news page.';
$lan['changepassword'] = 'Change your password.';
$lan['uploaditem'] = 'Upload an item.';
$lan['create_field_type'] = 'Create new custom field type.';
$lan['field_type_manager'] = 'Create, edit &amp; delete field types.';
$lan['tools'] = 'Tools to improve speed and clean up your database.';
$lan['category_remove_set'] = 'Remove a category';
$lan['category_edit_set'] = 'Edit a category';
$lan['arcatogory'] = 'Add a category.';

// advanced settings.
$lan['advancedfullpath'] = '<b>Full Absolute path to store pre-rendered content.</b> <br>(No trailing slash)';

// render settings
$lan['enable_enitiy'] = '<b>Enable Entity feature?</b><br>(Native scripting language.)';
$lan['hgzip'] = '<b>Gzip Content?</b>';
$lan['gzlevel'] = '<b>Gzip Compression</b><br> ratio 9=max 1=min?';
$lan['cfields'] = '<b>Enable Custom Fields?</b>';
$lan['cache'] = '<b>Enable Template caching?</b><br>Improves speed by at least 15x';
$lan['cachepath'] = '<b>If Template caching enabled enter the absolute path to store files?</b>';
$lan['interval'] = '<b>Update cached templates every?</b><br>Time is in minutes 1 = 1m ect only place a number.';
  // updated june 15
$lan['tagstart'] = '<b>Tag start prefix</b><br>Template tag start prefix example\'s &lt;!$ or &lt;castertag&gt; or &lt;!-- you can also define your own.<br>';
$lan['tagend'] = '<b>Tag end prefix</b><br>Template tag end prefix example\'s $&gt; or &lt;/castertag&gt; or --&gt; you can also define your own.';


// Display settings.
$lan['languageselect'] = '<b>Please select a default language</b>';
$lan['ebbcode'] = '<b>Enable NC-Code in posts?</b>';
$lan['ehtmleditor'] = '<b>Enable Html in posts?</b>';
$lan['enablewysiwyg'] = '<b>Load Java script Wysiwyg editor</b> <br>(if html mode enabled)?';
$lan['enablenceditor'] = '<b>Load Java script Nc-Code editor</b> <br>(if NC-Code enabled)?';
$lan['sitename'] = '<b>Your site name?</b>';
$lan['grouparticles'] = '<b>Group articles under a day header?</b>';
$lan['shadowlink'] = '<b>Enable url quary Encoding (Shadow Link)?</b>';

$lan['articleamount'] = '<b>How many articles would you like to display, on your main page?</b>';
$lan['fullbox'] = '<b>Display Full News box?</b><br> (Recommended)';
$lan['timestamp'] = '<b>Time Stamp used in the tag &lt;!$time$&gt;, you can style it how you want it.</b><br> It\'s recommend that you read the documentation before entering a new style.';
$lan['autobuild'] = '<b>Auto build?</b><br> (Builds all files in build list)';
$lan['enable_postauth'] = '<b>Article Authentication</b><br> Whould you like to enable article authentication';

// backup
$lan['compress'] = '<b>Compress using</b>';



// Upload settings
$lan['removehtml'] = '<b>Strip html from text pages uploaded?</b>';
$lan['eupload'] = '<b>Enable upload feature<br></b> (Some servers do not support it)';
$lan['euploadip'] = '<b>Enable Upload feature in posts?</b><br> (Some servers do not support it.)';
$lan['aimageip'] = '<b>Attach uploaded image(s) to article?</b><br>(If no is selected you can still use [imagieid][/imageid] to include picture\'s in your articles.';
$lan['uploadpath'] = '<b>Absolute path to your upload directory</b><br> (Do not include a trailing slash. E.g./ => / <=.)';
$lan['uploadhttp'] = '<b>Www path to your upload directory</b><br> e.g./ http://myhost.com/upload Note: Do not include any trailing slashes e.g. => / <=';
$lan['img_size_selects'] = '<b>Image size pre-selects:</b><br>(When adding a size make sure the height and width are separated with x example. 640x480 for each pre-select make sure there is a space in between each.)';

// new june 08
$lan['img_icon'] = '<b>Please enter the full absolute path to your Logo</b><br> Logo is used for Water Marking images. Must be (PNG)';
$lan['img_transparent'] = '<b>Enter a color you wish to make transparent in your logo.</b><br>Leave blank if your logo was saved with transparencies';
$lan['img_position'] = '<b>Select the position.</b><br> To where you wish to place your logo on the source image.';
$lan['img_quality'] = '<b>Image quality.</b><br>Quality of the saved jpeg image\'s. (0-100)';
$lan['img_translucency'] = '<b>Translucency.</b><br>Translucency fades the logo to blend in to the source image. (0-100)';


// Create field type
$lan['fieldname'] = 'Name of field type:';
$lan['fieldnv'] = 'Field Names &amp; values box.';
$lan['fieldbase'] = 'Base field on';

// mysql database settings
$lan['host'] = 'Your host address for your mysql database:';
$lan['password'] = 'Your password for your mysql database.';
$lan['username'] = 'Your username for your mysql database.';
$lan['dbname'] = 'Your NCaster mysql database name.';

// add remove catogory
$lan['catogoryname'] = 'Please insert the new category name here.';
$lan['removecatogory'] = 'Please Select a category to remove.';
$lan['updatecatogory'] = 'Please Select a category to update.';

// category pages
$lan['update_category_name'] = 'Category Name:';
$lan['update_category_templatef'] = 'Template (Full page):';
$lan['update_category_templaten'] = 'Template (Article Style):';
$lan['update_category_avatar'] = 'Category Avatar:';

// updated july 15
$lan['is_hub'] = 'Make this category an assicative hub?';
$lan['relate_to'] = 'Relate this article to which Hub? (Optional)';
$lan['rel_info'] = 'Give a short description of what this hub relates to example. Games for a games site or DVD for a music site: (optional)';

// upload directory
$lan['updir'] = 'upload directory is';

// add staff member
$lan['addusername'] = 'Username:';
$lan['addpassword'] = 'Password:';
$lan['addemail'] = 'Email address of staff member:';
$lan['addper'] = 'Permissions:';

// remove/edit staff member
$lan['rstaff'] = 'Please select a staff member account to remove:';
$lan['staffaction'] = 'Action:';


// add fields. edit/add
$lan['fname'] = 'Field Name:';
$lan['ftype'] = 'Field Type :';
$lan['fsizew'] = 'Field size (Width):';
$lan['fsizeh'] = 'Field size 2 (height)(only for multiline box)';
$lan['fdisplay'] = 'Display Field?';
$lan['fdesc'] = 'Description:';
$lan['forder'] = 'Order field(insert a number, lower number fields show first on post and edit screens)';
$lan['fvalue'] = 'Field Value (Leave blank to have no value)'; 

// build list
$lan['buildlist'] = 'Build list enables you to pre-render lists of articles to reduce load time.';
// build list add entry
$lan['bcatogory'] = 'Select the catogory to extract information from:';
$lan['btemplate'] = 'Please Select template to use:';
$lan['bamount'] = 'Amount of articles to display:';

// updated
$lan['bmode'] = 'Please select how you wish to save your build entry (File or database).';
$lan['bfilename'] = 'If mode is file please enter the file name you wish to save this build entry in. e.g (news.txt)';

// updated august 04, 2003
$lan['build_sortby'] = 'You can sort your articles by descending or ascending order, descending meaning newest articles and ascending meaning oldest.'; 
$lan['build_startrows'] = 'The start row allows you to skip x amount of articles for display.'; 
$lan['filter'] = 'Filtering is an advanced feature that allows you to filter articles by values, please read the documentation for more detailed help.';

// updated august 05, 2003
$lan['build_use_key'] = 'Key to sort by.';


// layout management. add fullpage, add news style and also edit.
$lan['lname'] = 'Name of layout';
$lan['lnave'] = 'Action bar:';
$lan['llayout'] = 'Layout:';

// assign layout
$lan['assigntemplate'] = 'Select a template to assign to category:';

// change password
$lan['coldpassword'] = 'Old password?';
$lan['cnewpassword'] = 'New Password?';

// post article & edit article
$lan['subject'] = 'Subject: * </b>(<font color="red">Required</font>)<b>';
$lan['description'] = "".$cto[$catogory]['category']."".' Description:';
$lan['fullnews'] = 'Full text for '.$cto[$catogory]['category'].':';
$lan['attachfile'] = 'Attach a file to this article?';
$lan['attachfile2'] = 'Whould you like to upload a file in to this article?';

// updated july 15
$lan['rel_hub_info'] = 'Relate article to?';

// user profiles
$lan['user_pass'] = 'Change password';
$lan['email'] = 'Your email Address';
$lan['realname'] = 'Your Name';
$lan['info'] = 'Information About you';
$lan['hobbys'] = 'Hobbys';
$lan['aim'] = 'AIM Username';
$lan['icq'] = 'Icq Number';
$lan['msn'] = 'Msn Username';
$lan['yahoo'] = 'Yahoo Username';
$lan['birthdate'] = 'Date of birth';
$lan['gender'] = 'Gender';
$lan['html_editor'] = 'Enable java script html Editor?';
$lan['nccode_editor'] = 'Enable Java Script NC-Code editor?';
$lan['language'] = 'Select your language';
$lan['avartar'] = 'Enter a url to your Avatar:';

// Login Logout messages
$lan['pwchanged'] = 'Password Has been changed, Please Login with your new details';
$lan['pwnotchanged'] = '<li>Sorry your old password does not match recordeds</li>';


// Tools menu
$lan['cleanup_tool_header'] = 'Database Clean up Tool.';
$lan['cleanup_tool_text'] = 'This tool removes unused field data, this is normaly caused by renaming or deleting a field.';
  
$lan['cachecleaner_tool_header'] = 'Cache Cleaner';
$lan['cachecleaner_tool_text'] = 'Cache cleaner removes all cached templates, if you want to show an updated template design instantly and you have caching enabled do a quick clean with this tool.';

// All done. If you translated any or all of this language pak to anouther language please submit it to
// us it whould greatly help in ncasters development. email: michealo@ozemail.com.au
// Full credit is allways given to those who contribute.
?>