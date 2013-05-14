=== Auto Terms of Service and Privacy Policy ===
Contributors: cliffpaulick
Tags: legal, policy, privacy, t&c, terms and conditions
Requires at least: 3.0
Tested up to: 3.5
Stable tag: /trunk/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Put your own details into a modified version of Automattic's "Terms of Service" and "Privacy Policy". 3 shortcodes available.

== Description ==

Puts your own information into a version of Automattic's <a href="http://en.wordpress.com/tos/">Terms of Service</a> and <a href="http://automattic.com/privacy/">Privacy Policy</a>, both available under the <a href="http://creativecommons.org/licenses/by-sa/3.0/">Creative Commons Sharealike</a> license, that have been modified to exclude specifics to Automattic (like mentions of "JetPack", "WordPress.com", and "VIP") and have more generic language that can apply to most any site or service provider, including single sites, subscription sites, blog networks, and others.

<strong>FYI: You need to edit the actual plugin file before using it</strong> (I know it's not perfect, feel free to contribute your code edits). Then you can add your own page and use one of the 3 available shortcodes: [my_terms_of_service_and_privacy_policy], [my_terms_of_service], and/or [my_privacy_policy]

A video demo:
[youtube http://www.youtube.com/watch?v=58rwQ_yDMfs]

Disclaimer: <a href="http://tourkick.com/">Clifford Paulick of TourKick.com</a> is not an attorney. Additional disclaimer text within the plugin file(s).

== Installation ==

After automatically installing to wp-content/plugins/ or manually installing to wp-content/mu-plugins/ (Must Use, i.e. Always Active), edit the actual plugin file, starting at Line 40, and follow the steps shown there.
== Frequently Asked Questions ==

Why?

Because Terms and Conditions and Privacy Policies are important to have and because some businesses don't understand their importance or are unable or unwilling to afford an attorney to draft custom T&C and Privacy Policy documents. This plugin allows you to create your own, based on Automattic's. Thanks to Automattic for telling us we can use and abuse theirs.

How?

Edit the plugin's actual file, starting at Line 40, following the steps listed there.

MultiSite?

Kinda... It Network Activates but doesn't show up under each site's list of intalled/available plugins. However, if they use the shortcode(s), the output will work.

What's on the To-Do List?

See the plugin's file. Not much, really. This took way longer than I expected so I don't plan to keep updating it every 6-12 months that Automattic makes a minor revision to their T&C or Privacy Policy. Plus, the way the plugin's setup, I don't want to push an update that makes you lose your edits.

How can I give back?

Please rate the plugin, Tweet about it (mentioning @TourKick would be appreciated), contribute code enhancements, etc. I do not want monetary compensation for this particular project, but thank you for the thought.

How do I add a "to the top" link?

<a href="http://wordpress.org/extend/plugins/dynamic-to-top/" target="_blank">Dynamic "To Top" Plugin</a> is a good one that works site-wide, not just for this plugin. It might be a solution for you.
== Screenshots ==
1. Administrator view of shortcode output before plugin has been customized

2. View of editing the plugin (using <a href=\"http://wordpress.org/extend/plugins/advanced-code-editor/\">Advanced Code Editor</a> plugin)

3. Page/Post Editor screen, using this plugin's shortcode: [my_terms_of_service]

4. Output of [my_terms_of_service] after customizing this plugin

5. Page/Post Editor screen, using this plugin's shortcode: [my_privacy_policy]

6. Output of [my_privacy_policy] after customizing this plugin

7. Page/Post Editor screen, using this plugin's shortcode: [my_terms_of_service_and_privacy_policy]

8. Output of [my_terms_of_service_and_privacy_policy] after customizing this plugin. Creates in-page links for quick access.

9. Scroll or Click to Privacy Policy when using [my_terms_of_service_and_privacy_policy] shortcode, further down the same page as the previous screenshot. Separated by horizontal line.
== Changelog ==
* WARNING: If you modified the previous version of this (e.g. added your own business name and information), make sure you backup your information BEFORE UPDATING to a new version.
* Changelog DIFFs for all versions are available at <a href="http://plugins.trac.wordpress.org/browser/auto-terms-of-service-and-privacy-policy/trunk" target="_blank">WordPress SVN</a>.
= Version: 1.3.2012.12.29 =
* Fixed 2 more hard-coded references to "WordPress" within that same paragraph. That should be all of them now.
= Version: 1.2.2012.12.29 =
* Fixed a <a href="http://wordpress.org/support/topic/update-required?replies=1#post-3439913" target="_blank">hard-coded reference to "WordPress"</a>, reported by kc22033. Thanks!
* Checked WordPress' Terms of Service and Privacy Policy for updates, and there weren't any changes since this plugin's creation.
= Version: 1.1.2012.12.28 =
* Changed shortcodes to return instead of echo, to fix the shortcode display issue. Thanks to <a href="http://profiles.wordpress.org/birgire" target="_blank">birgire</a>.
* Fixed link anchor text to use the name specified in the settings, to fix the issue of displaying hard coded "Terms of Use" and "Privacy Policy" anchor text in the table of contents for the [my_terms_of_service_and_privacy_policy] shortcode.
= Version: 1.0.2012.09.12 =
* Initial release.