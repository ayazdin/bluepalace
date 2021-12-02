=== Contempo Real Estate Custom Posts ===
Contributors: contempoinc
Donate link: 
Tags: real estate,realtor,realty,listings,real estate agent,rentals,custom posts,custom taxonomies
Requires at least: 3.3
Tested up to: 4.5
Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin registers listings & testimonials custom post types, along with related custom fields & taxonomies.

== Description ==

This plugin registers listings & testimonials custom post types, along with related custom fields & taxonomies. It serves as a simple base for theme authors to build custom real estate & listings themes. It does not include any template files, those would need to be created. 

== Installation ==

1. Unzip 'ct-real-estate-custom-posts.zip'.
1. Upload to the /wp-content/plugins/ directory.
1. Activate 'Contempo Real Estate Custom Posts' plugin through the 'Plugins' menu in WordPress.
1. If activation was successful you'll see three new custom post menu items

= NOTE =
This plugin does NOT come with template files those will need to be created for use within your theme.

== Changelog ==

= v1.0.0 =
* Initial Release!
= v1.0.1 =
* Changed listing_price() to ct_listing_price()
= v1.0.2 =
* Changed Testimonials CPT icon
= v1.0.3 =
* Cleaned up custom admin columns layout for listings and testimonials on mobile devices
= v1.0.4 =
* Localized missing strings
* Added lang global
* Changed function naming to avoid possible conflicts
= v1.0.5 =
* Added conditionals for functions to avoid possible conflicts
= v1.0.6 =
* Updated translation files
= v1.0.7 =
* Fixed translation locale bug
= v1.0.8 =
* Fixed currency bug
= v1.0.9 =
* Fixed price formatting i18n bug
= v1.1.0 =
* Added option to turn off page bottom margin
= v1.1.1 =
* Fixed Zip/Postcode bug
= v1.1.2 =
* Fixed international price formatting bug
= v1.1.3 =
* Fixed property information big in VC block
= v1.1.4 =
* CRITCIAL BUG FIX for Listings & Mapping
= v1.1.5 =
* Fixed Lot & Land Property Types bug for removing beds/baths
= v1.1.6 =
* Fixed Status flag bug
= v1.1.7 =
* Added conditional with admin notice for RE6 & RE5 themes
= v1.1.8 =
* Added drag & drop sorting for slider images
= v1.1.9 =
* Added WPML Config XML file
= v1.2.0 =
* Added styling for Status tags in the admin, For Sale, For Rent, etc… 
= v1.2.1 =
* Added function to price field so commas and separators are stripped before its added to the database, as the formatting is done automatically on the frontend, also to avoid price from/to search fields not working.
= v1.2.2 =
* Added option to change listings slug
= v1.2.3 =
* Added conditional so any booking plugin can be used with WP Pro Real Estate 7
= v1.2.4 =
* Added option to manually order homepage featured listings
= v1.2.5 =
* Added option for Postal Code to go along with Zipcode & Postcode
= v1.2.6 =
* Update language files
= v1.2.7 =
* Added option for State or Area
= v1.2.8 =
* Added option for Suburb to go along with State or Area
= v1.2.9 =
* Added option for Community, Neighborhood or District
= v1.3.0 =
* Added optional Listing Reviews
= v1.3.1 =
* Added optional Multi-floor Plans & Pricing
= v1.3.2 =
* Added more help text to multi-floor plan with a note to make sure and enable the option with Real Estate 7 Options > Listings > Enable Multi-Floorplan & Pricing Fields?, otherwise the floor plans won’t be shown.
* Updated Language Files
= v1.3.3 =
* Removed unused Meta & Social display options from posts
= v1.3.4 =
* Added individual on/off option for single post header
= v1.3.5 =
* Removed $lang global for ‘contempo’, updated lang files
= v1.3.6 =
* Added optional Virtual Tour field
= v1.3.7 =
* Fixed Dwelling Size Icon
= v1.3.8 =
* Removed unused Brokerage post type for release later on
= v1.3.9 =
* Added Brokerage Custom Post Type
* Added Brokerage select/assign option to Listings
* Added Agents select/assign option to Brokerages
* Updated language files
* Removed extraneous language files from /cmb2/ folder causing translation issues
= v1.4.0 =
* Added "Suburb" option to "Community, Neighborhood, Suburb or District" for listings
= v1.4.1 =
* Added "Province" option to "State, Area, Suburb or Province?" for listings
= v1.4.2 =
* Added "Minimal" listing grid style to Visual Composer > CT Listings module
= v1.4.3 =
* Added new multi layout grid module to Visual Composer > CT Listings Minimal Grid module
= v1.4.4 =
* Added additional layout style to Visual Composer > CT Listings Minimal Grid module
= v1.4.5 =
* Added additional layout style to Visual Composer > CT Listings Minimal Grid module
= v1.4.6 =
* Added List layout option to Visual Composer > CT Listings module
= v1.4.7 =
* Added “Building” option to "Community, Neighborhood, Suburb, District or Building” for listings
* Updated Language Files
= v1.4.8 =
* Added Optional Brokerage Reviews