<!-- DO NOT EDIT THIS FILE; it is auto-generated from readme.txt -->
# The Joshua Project, Nation Info

Allows the site owner to render information from The Joshua Project about a specific country.

**Contributors:** [topher1kenobe](http://profiles.wordpress.org/topher1kenobe)  
**Tags:** [widget](http://wordpress.org/plugins/tags/widget)  
**Requires at least:** 3.0  
**Tested up to:** 4.0  
**Stable tag:** 1.0  
**License:** [GPLv2 or later](http://www.gnu.org/licenses/gpl-2.0.html)  
**Donate link:** http://joshuaproject.net/donate  

## Description ##

This plugin provides a widget to render data take from The Joshia Project about a specific country, chosen by the site admin.  The admin can choose from these bits of data to render in the widget:

* Flag
* Population
* Unreached Percentage
* People Groups
* Unreached People Groups
* Primary Language
* Primary Religion
* Percent Evangelical

## Installation ##

1. Upload the `/joshua-project-country-info/` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Visit Appearance -> Widgets in the admin and place the widget in a sidebar

## Screenshots ##


## Usage ##

Some basic CSS is included.  If you'd like to turn it off, drop this code into your theme functions.php file or a plugin of your choosing.

`function t1k-jp-country-data-styles-remove() {
    return false;
}
add_filter( 't1k-jp-country-data-styles', 't1k-jp-country-data-styles-remove' );`

## Changelog ##

### 1.0 ###
* Initial release

