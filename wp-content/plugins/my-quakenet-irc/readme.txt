=== My QuakeNet IRC ===

Contributors: KwarK
Donate link: http://kwark.allwebtuts.net/
Tags: QuakeNet, IRC, chat, plugin
Tested up to: 3.4.1
Stable tag: 1.0.3

My QuakeNet IRC chat plugin for Wordpress. Add a zone for your QuakeNet IRC chat.

== Description ==


* Add a main chat zone where you want in your code or in a page easily with shortcode `[quake]`
* Add multiple irc chat Quakenet on your site with shortcode `[quake channels="..."]` with optional parameters width, height, status, message, button
* Option AutoFill input nickname (based on user->display_name from WordPress)
* One option to leave the choice of changes the NickName to yours users (or not)

e.g.

* basics

`[quake channels="allwebtuts"]`

* full example

`[quake width="600" height="400" channels="style-cataclysm" status="user only" message="Please login to view this chat" button="yes" autofill="yes" prompt="no"]`


button may take parameters yes or no (if nothing is defined - default no)

* yes, a link named IRC appears to hide/show the current IRC


status may take parameters user only or public (if nothing is defined - default public)

* public, all visitors on your wordpress installation view the channel ongoing
* user only, only the connected users view the channel ongoing

autofill may take parameters yes or no (if nothing is defined - default from administration)

* yes, AutoFill of the input nickname with the display_name from wordpress

prompt may take parameters yes or no (if nothing is defined - default from administration)

* yes, autofill but leave the choice to your user to change its nickname if autofill is enable
* no, force user to use only its display_name from wordpress

== Installation ==

1. Upload 'my-quakenet-irc' to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Define few attributs in Dashboard > Quakenet IRC


== Screenshots ==

1. Screenshot my-quakenet-admin


== Frequently Asked Questions ==

View forum support on Wordpress for more information


== Upgrade Notice ==

1. Use the Wordpress automatic upgrade notice or upgrade this plugin manually


== Changelog ==

= 1.0.3 =

* add AutoFill nickname with the user_displayname from wordpress
* add one option to force user to use only its display_name or permit to choose for another one

= 1.0.2 =

* code review

= 1.0.1 =

* now add multiple irc chat Quakenet on your site with [quake] shortcode

= 1.0 =

* Original review