=== Bootstrap Shortcodes for WordPress ===
Contributors: mwdelaney, FoolsRun, filipstefansson, nodley
Tags: bootstrap, shortcode, shortcodes, responsive, grid
Requires at least: 3.8
Tested up to: 4.6
Stable tag: 4.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Implements Bootstrap 3 styles and components in WordPress through shortcodes.

== Description ==

###Just The Shortcodes, Please
Plenty of great WordPress plugins focus on providing or including the Bootstrap library into your site. **Bootstrap Shortcodes for WordPress** assumes you're working with a theme that already includes Bootstrap 3 and focuses on giving you a great set of shortcodes to use it with.

This plugin creates a simple, out of the way button just above the WordPress TinyMCE editor (next to the "Add Media" button) which pops up the plugin's documentation and shortcode examples for reference and handy "Insert Example" links to send the example shortcodes straight to the editor. There are no additional TinyMCE buttons to clutter up your screen, just great, easy to use shortcodes!

**Requires PHP 5.3 or newer**

For questions, support, or to contribute to this plugin, check out [our GitHub project](https://github.com/audioscavenger/bootstrap-shortcoder)

####Updated for Bootstrap 3.3.x
Tested and working in the latest version of Bootstrap!

###Supported Shortcodes
####CSS
* Grid (container, row, columns, fully responsive)
* Buttons
####Components
* Button Groups
* Button Dropdowns
* Jumbotron
* Alerts
* Progress Bars
* List Groups
####JavaScript
* Tabs
* Tooltip
* Popover
* Accordion (Collapse)
* Carousel
* Modal
###Deprecated Shortcodes
* Lead body copy
* Emphasis classes
* Code
* Tables
* Images
* Responsive embeds
* Responsive utilities
* Navs
* Breadcrumbs
* Labels
* Badges
* Page Header
* Thumbnails
* Media Objects
* Wells

== Installation ==
1. Download and unzip this plugin
1. Upload the "bootstrap-shortcoder" folder to your site's `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create or edit a page or post and click the "B" button that appears above the editor to see the plugin's documentation!

== Frequently Asked Questions ==

= Does this plugin include Bootstrap 5.3? =

Yes, we include the CDN link from cdn.jsdelivr.net. 

= What happens if my Theme includes and uses Bootstrap? =

3 situations:
- If you theme does not include Bootstrap, we load it = no problems.
- If you theme includes Bootstrap 5, we replace it by version 5.3.
- If you theme includes Bootstrap 4 or lower, we are incompatible.

= Is this retro-compatible with shortcodes from _Boostrap 3 Shortcodes_ plugin? =

More or less, but:
- some stuff will break because the templates have changed: Tabs, ...
- some stuff are not included, see list above: Wells, Progress bars, Media, Images, Thumbnails...
I mean, come on, what would you do with a progress bar? or breadcrumbs in you posts?? The rest is either useless or included in WP 6.5.

== Changelog ==

= 4.0.5 =
- [x] MY MY MY fix bug of SHORTCODES loaded outsoide TinyMCE once and for all
- [x] rebuild main function and move this class under includes
- [x] moved every functions inside BoostrapShortcodes
- [x] moved everything inside BoostrapShortcodes
- [x] fixed media-button icon and size
- removed row_container
- [x] Test drop actual html just like best-editor -> just send_to_editor(html) instead of shortcodes... it's that easy
- [x] dequeue any other plugins loading bootstrap (except when they are a dependency)
- [x] fix helper tabs again and stop breaking it
- [ ] Add compiled code container after each code example so we can give choice to insert either
- [ ] add scrollup in mce window to #wpbody
- [ ] auto-load modal content just like in popover-shortcodes.js
- [ ] add dropdown menu in TinyMCE, tired of this crap modal. Explore bs-menu.js (mce dropdowns injection)
- [ ] disable register_shortcodes if is_admin()
- [ ] todo: check if bootstrap is not already loaded by theme or best-editor...
- [ ] todo: fix css grid insert in SHORTCODES-compiled
- [ ] add dropdown menu in TinyMCE, tired of this crap modal

= 4.0.4 =
- updated SHORTCODES-compiled.html
- tentative to make most methods generic
- removed table, table-wrap, media*, img, embed-responsive, thumbnail, page-header, responsive, panel*
- card-block becomes card-body
- added grid/grop login to cards
- added "cols" atts for cards type=grid
- added "type" atts for card
- [ ] todo: check if bootstrap is not already loaded by theme or best tinymce editor...
- [ ] todo: fix css grid insert in SHORTCODES-compiled
- [ ] add dropdown menu in TinyMCE, tired of this crap modal

= 4.0.3 =
- with nodeJS grunt + Gruntfile.js, README.md is converted to SHORTCODES.html - must test if we can maintain it
  - the problem is that the top of the README structure is incompatible with the Tabs structure
- renamed /help/README to /templates/SHORTCODES
- SHORTCODES Tabs are broken again
- should add examples from https://getbootstrap.com/docs/5.3/examples/
- moved shortcoder functions I keep under includes/shortcoder X cancelled: cannot include(methods.php)
- complete rewrite of the Class BoostrapShortcodes
- fixed callout
- updated bs-callout.css with BS 5.3 examples

= 4.0.2 =
- major cleanup
- added demo class for Grid
- started revamp of help/README: placed some insert code buttons at the top
- added scroll-up in modal
- rewrote modal and functions attached
- most works with Bootstrap 5.3

= 4.0.1 =
- fixed a major bug... shortcodes helper was loaded in the footer ALWAYS... slowing down your admin
- most functions and names are renamed properly
- added Bootstrap 5.3 cdn
- partially validated for Bootstrap 5.3: data-stuff becomes data-bs-stuff

= 4.0.0 =
- Complete reboot and new name
- added callout, cards, row-container
- panel

- Added callout:
  - these are the callout from Bootstrap docs, plus a nice background, plus transparency and disabled options.
  - help updated
  - todo: none

- Added cards:
  - these are the cards from bootstrap 4, in a Pinterest column like fashion.
  - help updated
  - todo: add more options like set of cards, no radius etc

- Added row-container:
  - for rows inside a column, this fix a bug where the row would close too early. We just needed another shortcode for rows that's it.
  - usage: [row][column][row-container][/row-container]..[/column][/row]
  - todo: integrate an usage example in help.html

- bugfix panel:
  - now it's a real container with panel-heading, panel-body, panel-footer as per bootstrap definition.
  - help updated
  - todo: inform current users that the syntax has changed. They do not lose their data, but they need to rewrite the shortcodes though.

= 3.3.9 =
* Tested to work with WordPress 4.6
* Fixed bug in [collapse] (thanks who all who reported it)
* Note PHP 5.3 or greater requirement in documentation
* Update documentation for clarity
* Fix issue with xclass in active tabs (thanks who all who reported it!)

= 3.3.8 =
* Tested to work with WordPress 4.5
* Set a default "active" slide in carousel if none is specified
* Add shortcode for responsive embeds
* Correct some non-latin characters displaying incorrectly
* Add filter to hook into tabs for things like tab history (thanks, Jason Maners!)

= 3.3.6 =
* Allow for xclass property on individual [tab]s
* Prevent Bootstrap help popup button from appearing on unintended pages
* Allow for commas in [popover] content
* Further correction for conflicts with Visual Composer
* Allow special characters in [page-header]

= 3.3.5 =
* Tested to work in WordPress 4.1!
* Allow non-English characters in [table-wrap], [media-object], [img], [thumbnail], [modal], [tab], and [collapse]
* Better compatibility with Visual Composer (Thanks, jannejava!)
* [tabs] and [tab], fix defaulting the first tab as "active" if no tabs are explicitly set as "active"

= 3.3.4 =
* Restore Bootstrap 3.2 backwards compatibility for [media-object] shortcode, updated documentation to use Bootstrap 3.3 example, but offer 3.2 options.
* Add "collapsed" class to non-active [collapse] elements (thanks, Artem!)

= 3.3 =
* Tested to work with Bootstrap 3.3!
* Only enqueue tooltip and popover trigger javascript if those shortcodes are in use
* Added support for offsets, pulls, and pushes of "0" in [column]
* Added support for Bootstrap's responsive tables in [table-wrap]
* Better correct for conflicts with Gravity Forms --these two plugins should finally play well together
* Fix documentation for [modal] and [responsive]
* Removed use of extract() to better fit with WordPress's best practices.

= 3.2.4 =
* NOTE: this update changes the way the [table-wrap], [tooltip], [popover], [page-header], [img], and [media-object] shortcodes function to better correct for unexpected input. Please report any problems you have with these shortcodes following this update.
* Add Bootstrap shortcode help popup button to Distraction Free Writing Mode toolbar
* Better responsive styles for help popup button on smaller screens
* Better correction for malformed or unexpected input in [table-wrap], [tooltip], [popover], [page-header], [img], and [media-object]s
* Fix display problems for WP-Engine users
* Fix documentation for [popover]
* Better handling of Gravity Forms' "No Conflict Mode"
* Fix conflict with All-In-One Events Calendar
* Fix for some situations where the help-tab popup would be behind other popup elements.
* WordPress 4.0 support!

= 3.2.3 =
* Fix conflicts with other plugins, like Gravity Forms, which use Bootstrap on the WordPress back-end.

= 3.2 =
* New Features
* This release features a brand new, much easier to use popup for the documentation. We're now using Bootstrap's "modal" component rather than the soon-to-be-retired WordPress Thickbox. We've also split the documentation up into tabs so that the technical information about the plugin isn't cluttering up the shortcode reference material. This should make the plugin a little less scary for end-users.
* Added optional "target" parameter to [list-group-item]
* Added support for new "block", "inline", and "inline-block" parameters in [responsive] introduced in Bootstrap 3.2
* Remove legacy [icon-white] shortcode (it wasn't documented anyway)

* Bug Fixes
* Fixed issue with [carousel] indicators (thanks, mebdev!)
* Fix any parameters expecting "true", or "false" accepting any input as "true". Now only accepts the word "true"; other input will be ignored and read as "false".
* Fix bug that prevented CSS classes from being applied to [dropdown-item]s
* Fixed bug that completely broke [divider] in dropdowns
* Fix animated progress bar classes

= 3.1.2 =
* Tested to work in WordPress 3.9
* Fix and document collapsibles "Active" state
* Fix uninitialized variables causing errors in debug mode
* Fix "Active" tab, carousel checking, should work better now
* Fix media button icon in Internet Explorer

= 3.1.1 =
* Support new parameters introduced in Bootstrap 3.1.x
* Use custom icon-font for editor button
* Fix bug which broke Distraction Free Editing in WordPress
* Fix bug which caused [responsive] shortcodes not to work

= 3.0.3.6 =
* Significant rewrite to properly escape inputs
* [tabs] now supports "pills" and "fade" styles
* [tabs] and [carousel] now support setting a tab or image other than the first one as "active". If no tab or carousel item is set to "active" the first one is set by default.
* [panel] titles are now optional (see documentation for new shortcode parameters)
* [list-group-item] now supports optional "type" parameter (Bootstrap 3.1 only)
* [button] now supports "disabled" and "active" parameters
* [progress-bar] now supports showing labels
* Add [dropdown-header] shortcode
* [container] now includes optional "fluid" parameter (Bootstrap 3.1 only)
* [modal] now supports sizes (Bootstrap 3.1 only)
* Composer support
* Resolve errors regarding uninitialized variables experienced by some users
* Resolve image path icons for non-standard WordPress directory names
* Resolved DOMDocument errors experienced by some users (if you still see these errors or warnings please let us know)

= 3.0.3.5 =
* Add support for [container] shortcode for themes without a container defined
* Add support for [carousel] and [carousel-item] shortcodes
* Add support for "xclass" and "data" parameters to all shortcodes
* Plenty of bugfixes and code cleanup to fix common issues

= 3.0.3.2 =
* Fix help tab popup on edit pages

= 3.0.3.1 =
* Change help-tab to inline rather than iframe in to meet WordPress.org submission requirements
* Add support for images (http://getbootstrap.com/css/#images)
* Add support for progress bars (http://getbootstrap.com/components/#progress)
* Add support for page header (http://getbootstrap.com/components/#page-header
* Improve list groups, add support for linked items and custom content (http://getbootstrap.com/components/#list-group)
* Add support for button dropdowns (http://getbootstrap.com/components/#btn-dropdowns)
* Add support for breadcrumbs (http://getbootstrap.com/components/#breadcrumbs)
* Add support for button-toolbar in button groups (http://getbootstrap.com/components/#btn-groups-toolbar)
* Add support for navs (http://getbootstrap.com/components/#nav)
* Remove "strong" parameter from alerts --this should be handled in the wrapped content
* Allow arbitrary classes in columns

= 3.0.3 =
* Initial WordPress.org release
