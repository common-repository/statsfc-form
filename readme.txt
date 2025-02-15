=== StatsFC Form ===
Contributors: willjw
Donate link:
Tags: widget, football, soccer, premier league
Requires at least: 3.3
Tested up to: 6.2.2
Stable tag: 3.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This widget will place a current football form guide in your website.

== Description ==

Add a football form guide to your WordPress website. To request a key sign up for your free trial at [statsfc.com](https://statsfc.com/sign-up).

For a demo, check out [wp.statsfc.com/form](https://wp.statsfc.com/form/).

= Translations =
* Bahasa Indonesia
* Dansk
* Deutsch
* Eesti
* Español
* Français
* Hrvatski Jezik
* Italiano
* Magyar
* Norsk bokmål
* Slovenčina
* Slovenski Jezik
* Suomi
* Svenska
* Türkçe

If you're interested in translating for us, please get in touch at [hello@statsfc.com](mailto:hello@statsfc.com) or on Twitter [@StatsFC](https://twitter.com/StatsFC).

== Installation ==

1. Upload the `statsfc-form` folder and all files to the `/wp-content/plugins/` directory
2. Activate the widget through the 'Plugins' menu in WordPress
3. Drag the widget to the relevant sidebar on the 'Widgets' page in WordPress
4. Set the StatsFC key and any other options. If you don't have a key, sign up for free at [statsfc.com](https://statsfc.com)

You can also use the `[statsfc-form]` shortcode, with the following options:

* `key` (required): Your StatsFC key
* `competition` (required*): Competition key, e.g., `EPL`
* `team` (required*): Team name, e.g., `Liverpool`
* `year` (optional): The season to show form for, e.g., `2015/2016`
* `date` (optional): For a back-dated form guide, e.g., `2013-12-31`
* `limit` (optional): Number of teams to show form for, e.g., `5`, `10`
* `highlight` (optional): Name of the team you want to highlight, e.g., `Liverpool`
* `show_badges` (optional): Display team badges, `true` or `false`
* `show_score` (optional): Display match scores (on mouse over), `true` or `false`
* `default_css` (optional): Use the default widget styles, `true` or `false`
* `omit_errors` (optional): Omit error messages, `true` or `false`

*Only one of `competition` or `team` is required.

== Frequently asked questions ==



== Screenshots ==



== Changelog ==

= 3.0.0 =
* Refactor: Update plugin for new API

= 2.14.3 =
* Hotfix: Possible issue loading language/CSS files

= 2.14.2 =
* Hotfix: Check options exist before using them

= 2.14.1 =
* Hotfix: Check the before/after widget/title bits exist before using them

= 2.14.0 =
* Feature: Added `team` parameter to show form for a single team. Using this parameter means `competition` is optional
* Feature: Added `year` parameter to show form for a specific season

= 2.13.2 =
* Hotfix: Load relevant language file based on the default language for the site

= 2.13.1 =
* Hotfix: Fixed missing team badges

= 2.13.0 =
* Feature: Added multi-language support. If you're interested in translating for us, please get in touch at [hello@statsfc.com](mailto:hello@statsfc.com)

= 2.12.2 =
* Hotfix: Added a responsive horizontal scroll if the widget is too wide for mobile

= 2.12.1 =
* Hotfix: Fixed possible `Undefined index: omit_errors` error

= 2.12.0 =
* Feature: Put CSS/JS files back into the local repo
* Feature: Enqueue style/script directly instead of registering first

= 2.11.0 =
* Feature: Added `omit_errors` parameter
* Feature: Load CSS/JS remotely

= 2.10.3 =
* Hotfix: Fixed "Invalid domain" bug caused by referal domain

= 2.10.2 =
* Hotfix: Fixed bug with boolean options

= 2.10.1 =
* Hotfix: Fixed bug with multiple widgets on one page

= 2.10.0 =
* Feature: Added `show_badges` and `show_score` options; removed `team` option

= 2.9.0 =
* Feature: Allow more discrete ads for ad-supported accounts

= 2.8.0 =
* Feature: Enabled ad-support

= 2.7.0 =
* Feature: Use built-in WordPress HTTP API functions

= 2.6.0 =
* Feature: Added badge class for each team

= 2.5.0 =
* Feature: Default `default_css` parameter to `true`

= 2.4.0 =
* Feature: Updated team badges.

= 2.3.0 =
* Feature: Added a `limit` parameter.

= 2.2.0 =
* Feature: Added `[statsfc-form]` shortcode.

= 2.1.0 =
* Feature: Added a `date` parameter.

= 2.0.0 =
* Feature: Updated to use new API.

= 1.8.0 =
* Feature: Tweaked error message.

= 1.7.0 =
* Feature: More reliable team icons.

= 1.6.0 =
* Feature: Added fopen fallback if cURL request fails.

= 1.5.1 =
* Hotfix: Fixed possible cURL bug.

= 1.5.0 =
* Feature: Use cURL to fetch API data if possible.

= 1.4.1 =
* Hotfix: Fixed a formatting bug where teams don't have 6 results.

= 1.4.0 =
* Feature: Updated team badges for 2013/14.

= 1.3.1 =
* Hotfix: Fixed a bug when selecting a specific team.

= 1.3.0 =
* Feature: Allow the form of a single team to be displayed.

= 1.2.0 =
* Feature: Load images from CDN.

= 1.1.0 =
* Feature: Changed 'Highlight' option from a textbox to a dropdown.

= 1.0.2 =
* Hotfix: Fixed possible CSS overlaps.

= 1.0.1 =
* Hotfix: Fixed CSS bugs.

== Upgrade notice ==

