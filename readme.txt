=== Page Excerpt Widget ===
Contributors: JonathanMH
Donate link: http://example.com/
Tags: page, page excerpt, widget, read more link
Requires at least: 2.8
Tested up to: 3.5
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows the user to place a widget with an excerpt of a page in any sidebar. Dropdown menu for page, amount of characters adjustable.

== Description ==

I have created a little WordPress plugin in the shape of a widget, which allows the user to display an excerpt of a page in a sidebar area of their choice.
I wrote this to replace a little theme hack I did for a client, where the front page was supposed to have an excerpt of a page on the front page, of course linking to the full page. Instead of keeping it that way and hard coding the page-id, I wanted something where the end user could change which page was supposed to be linked. I hope it will be of use to someone.

Right now you can:

* Define the amount of characters to use as an excerpt
* Select the page from all existing pages
* Link the title of the page, to the page
* Append a link to the page
* Decide a custom label for the read more link
* add multiple instances of the widget

I plan to increase the functionality with:

* some internationalisation

== Installation ==

1. Upload the `page_excerpt_widget` directory to `/wp-content/plugins/` on your WordPress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to 'Appearance > Widgets' to place the Page Excerpt Widget in one of your sidebar areas.

== Frequently Asked Questions ==

= Can I have multiple page excerpt widgets active at the same time? =

Yes.

== Screenshots ==

1. This shows the widget in the backend and the options the user has.
2. This shows the output of the widget in the twenty eleven theme.

== Changelog ==

= 0.2 =
2013-1-6

Rewrite for multiple instances

* WP 2.8 is a requirement now

= 0.1 =
2012-7-11

Initial release

* Define the amount of characters to use as an excerpt
* Select the page from all existing pages
* Link the title of the page, to the page
* Append a link to the page
* Decide a custom label for the read more link

== Suggestions welcome ==
Since this is my first plugin and widget, suggestions, improvements and more are very welcome. I've also published the code on github, for easier discussion and improvement. https://github.com/JonathanMH/page-excerpt-widget
