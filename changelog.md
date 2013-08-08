== Changelog ==

= 0.4 =
2013-8-08

Added some new features:

* Shortcodes and "everything else" rendering -if wanted- using the "apply_filters" function from the WordPress API.
* New option to enable/disable "p" tags around the excerpt. "p" tags are not useful when "apply_filters" is enabled (we then get this error: <p><p>some text</p></p>), and when it doesn't, it may or may not be useful depending on the theme and the admin interests.
* Added a "p" tag with the class "jmhpew_readmore" around the "read more" link. The new class allows us to edit the link styles and I think that with the "p" tag the code is more standards compliant:
        Incorrect: <p>excerpt text</p><a href="#">read more</a>
        Correct: <p>excerpt text</p><p><a href="#">read more</a></p>
* Added a "span" tag with the class "jmhpew_dot_excerpt" around the " [...]" text. The new class allows us to edit the styles of that element.


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