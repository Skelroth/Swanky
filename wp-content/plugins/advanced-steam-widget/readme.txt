=== Advanced Steam Widget ===
Contributors: harpercl
Tags: widget, Steam, gaming, template
Requires at least: 3.0
Tested up to: 3.5
Stable tag: trunk

Displays Steam gaming statistics in a widget with increased flexibility, stability, and performance

== Description ==

This plugin will add a widget that displays your Steam gaming statistics. It employs caching to keep your site's performance up and make it less susceptible to Steam outages or errors.

The widget formatting is completely customizable via templates and/or CSS. The templates use patterns that will plug in values for the following:

* Recently Played Games
    - Game Name
    - Steam URL
    - Icon URL
    - Small Logo URL
    - Large Logo URL
    - Time Played Last Two Weeks
    - Time Played Total
* Player Profile
    - Steam Username
    - 64-bit Steam ID
    - Avatar Icon URL
    - Avatar Medium URL
    - Avatar Large URL
    - Time Played Last Two Weeks

== Installation ==

1. Copy the contents of this archive to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the 'Appearance > Widgets' menu and add 'Steam Widget' to a sidebar
1. Expand the widget's options and enter a Steam ID

== Frequently Asked Questions ==

= I put the widget into my sidebar but nothing is displayed on my site. =

1. First, make sure you put your Steam ID in the widget's settings.
1. Then try refreshing your site a few times in case Steam was just experiencing an intermittent problem.

= How do I find my Steam ID? =

There are a couple ways to do this. One way is to open up the Steam application and click on COMMUNITY. The other way is to log into the Steam website and then click Home. The URL on the page will either be in the format http://steamcommunity.com/id/XXX/home or http://steamcommunity.com/profiles/XXX/home where your Steam ID is XXX. For the latter, it will be a generated 17-digit number. If you want to use the former, which has a prettier URL, go to "Edit my Profile" and enter a "Custom URL".

= How do I display the "Add to Friends" link? =

Use the following code. More Steam protocol links can be found at https://developer.valvesoftware.com/wiki/Steam_browser_protocol

`<a href="steam://friends/add/%ID64%>Add to Friends</a>`

== Screenshots ==

1. Default look of the widget in the Twenty Ten theme
2. Possible look for your widget
3. Widget options on the back-end

== Changelog ==

= 1.0.1 =
* a few default template fixes
* more error checking for the Steam API output

= 1.0 =
* First public release