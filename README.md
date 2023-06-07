# The Events Calendar v2 Template Reset & Customization Guide

Version: 2.0.2!
[Changelog](#changlog)

[Feeback encouraged!](https://mrwweb.com/contact/)

## Introduction

[The Events Calendar](https://theeventscalendar.com) (TEC) is a very powerful WordPress plugin for managing events. However, the way its templates and CSS are implemented—especially the v2 templates—leave much to be desired.

This repository contains useful reset files and a checklist of changes I make on nearly every project that uses The Events Calendar. I wish it weren't so long!

## Who Made This?

I'm Mark Root-Wiley of [MRW Web Design](https://MRWweb.com). I build WordPress websites for nonprofits. Checkout my free resource site [Nonprofit WP](https://nonprofitwp.org) and my [free plugins](https://profiles.wordpress.org/mrwweb/#content-plugins).

**If this saves you an hour and a bunch of frustration, consider [buying me a coffee or a beer](https://www.paypal.com/paypalme/rootwiley) to say thanks! 🍻☕**

## Customizations Checklist

### Styles

There are two complimentary stylesheets so that TEC inherits and uses more theme styles. This is especially powerful if you are using `/theme.json` to set colors, font sizes, and a [spacing scale](https://developer.wordpress.org/news/2023/03/everything-you-need-to-know-about-spacing-in-block-themes/).

- [ ] Use `css/tec-remap-custom-properties.scss` to override a number of TEC defaults with WP/`theme.json` defaults
  - [ ] Follow instructions in file header to review styles, customize additional properties, and delete what you won't be using
- [ ] Use `css/tec-inherit-values.scss` reset stylesheet below to get rid of numerous hard-coded values and inherit more theme styles
  - [ ] Optionally set CSS properties to match theme font sizes and colors
- [ ] Add custom styles to blocks.
  - (Optional) Reference [list of useful TEC styling selectors](<https://github.com/mrwweb/wordpress-block-editor-theme-support-starter/blob/master/third-party-blocks/the-events-calendar-front-end-blocks.css>) as starting point.

### Template Overrides

TEC provides a powerful system to override various plugin templates like the page-level templates all the way down to a specific block. Most sites will need to customize multiple templates for best results.

- [ ] Copy and customize BOTH `default-template.php` files into theme folders
  - [ ] `/tribe/events/v2/default-template.php` - Used for new Month, List, Day, etc. views
- [ ] Clean up one or both single event templates:
  - Classic Editor Events: `single-event.php`
  - Block Editor Events: `single-event-blocks.php`
- [ ] Customize additional templates as needed. Recommended accessibility fixes to templates:
  - [ ] `tribe/events/v2/list/event.php` - Datetime should follow the event's title heading for logical structure
  - [ ] `tribe/events/v2/latest-past/event.php` - Datetime should follow the event's title heading for logical structure
  - [ ] `tribe/events/blocks/event-datetime.php` - Don't use a Heading 2 for logical heading structure on single events
  - [ ] `tribe/events/v2/list/event/feature-image.php` - Apply `aria-hidden="true"` to featured image link since it's redundant with the event title link in list view

### Optional Plugins

- [ ] Fix a few things about event pages and [set a custom default block template](https://support.theeventscalendar.com/807454-Change-the-Default-Event-Template-in-Block-Editor) with mu-plugin in `mu-plugins/tec-customizations.php` in this repository
  - Customize the default block fora new Event with the `tribe_events_editor_default_template` filter. See `/example-block-templates/` for examples of block templates of various complexity
- [ ] Install [Post Type Archive Descriptions](https://wordpress.org/plugins/post-type-archive-descriptions/) for an editable area at the top of the main events page
- [ ] Explore [additional TEC extensions](https://theeventscalendar.com/?s=&submit=&match%5Btribe_ecp_product_links%5D%5B%5D=the-events-calendar&post_type%5B%5D=tribe-extensions) for customizations (e.g., hide past events, ["tweaks" plugin](https://theeventscalendar.com/extensions/the-events-calendar-tweaks/), etc.)

## Useful v2 Design Filters

In TEC v2 templates, you can use the `tribe_template_pre_html` filter to hide specific template parts. For example, to hide the "Read More" links in list views:

```php
/* Hide "Read More" links */
add_filter( 'tribe_template_pre_html:events/v2/components/read-more', '__return_false' );
```

You can also helpfully add content before or after any template part using `tribe_template_before_include` and `tribe_template_after_include`. For example:

```php
/* Add "Hello World" after the "Views" selector in the event bar */
add_action( 'tribe_template_before_include:events/v2/components/events-bar/views', function( $file, $name, $template ) {
  echo 'Hello World';
}, 10, 3 );
```

### References

- [Using Template Filters and Actions on TheEventsCalendar.com](https://theeventscalendar.com/knowledgebase/k/using-template-filters-and-actions/)
- [Template Hooks on TheEventsCalendar.com](https://theeventscalendar.com/knowledgebase/k/template-hooks/)

## Changlog

### 2.0.2 (June 7, 2023)

- New function in mu-plugin to replace wrapping `section` with a `div` for better semantics
- Move custom properties in `_tec-inherit-values.css` to the `body` instead of `:root` so they have access to `theme.json` values set on `body`
- Make sure the datetime block children inherit `font-size` from the body (or block parent)
- Replace hard-coded namespace with `__NAMESPACE__` to avoid problem when changing namespace
- Hide top border and padding above venue blog and event paging
- Remove checklist item for old `default-template.php` file that is no longer included in the plugin

### 2.0.1 (May 18, 2023)

- This is now a git repository rather than a gist!
- Rename css files for clarity
- Provide fallbacks for custom properties in `tec-inherit-values.css`
- Split examples into separate files in new examples folder
- Add `CONTRIBUTING.md`

### 2.0.0 (May 02, 2023)

- Added new `_tec-reset-variables.scss` file for better style reset coverage and more stuff working "out of the box".
- Removed some rules from `_tec-reset-styles.scss` that are no longer necessary due to new custom property definitions.
- Add some more useful snippets to the mu-plugin (hide recent past events, show past events in reverse chronological order)
- Add absolute position to export events drop-down so it doesn't reflow the page
- Add \MRW\TEC\is_tribe_view() function to detect when a TEC page is active (great for enqueueing custom styles!)
- Fix: Put mobile-specific styles for event datetime into media query
- Remove some dead highlighting styles
- Remove snippet to add post type archive description and just recommend [Post Type Archive Descriptions plugin](https://wordpress.org/plugins/post-type-archive-descriptions/) more obviously
- Remove link to "Remove Export Links" TEC add-on which is no longer available. Add link to extensions page instead
- Remove some recommended accessibility template fixes that have been [integrated into the plugin](https://github.com/the-events-calendar/the-events-calendar/pull/3762)!

### 1.5.0 (August 05, 2022)

- Remove font-family now that there's a customizer setting for it

### 1.4.2 (May 03, 2022)

- Attempt to improve subscribe button style overrides dealing with weird focus and hover behaviors. Absolute position dropdown to avoid layout jank

### 1.4.1 (February 9, 2022)

- Improvements to subscribe button overrides to make them more likely to win over unwanted theme styles

### 1.4.0 (January 19, 2022)

- Fix featured event styles in month view
- Add styles to override subscribe button styles
- New suggestion to hide featured image from assistive technology in list views
- Add equivalent template changes to `/latest-past/` templates to match `/list/` changes where applicable

### 1.3.0 (August 23, 2021)

- Add new selectors for heading styles and links on the new single event templates to match other override styles (fonts, underlining behavior, etc.)
- Increase specificity of `.tribe-common-c-btn` selectors in order to override messed up settings in plugin and ensure the search bar button is the correct color
- Remove filter that hid the back link on the single template. Does not work in v2 single events.

### 1.2.0 (June 18, 2021)

- Add new selectors to inherit font styles from the theme
- Add editor selectors to try to style blocks closer to front-end. Results will vary.
- Bug fix for TEC 5.7.0 template_include filter

### 1.1.0 (April 20, 2021)

- Add `/v2/` to path of `tribe_template_before_include` filter to fix bug in TEC 5.5.
- Remove errant SASS variable in style resets
- Fix missing accent customization for Featured Styles in list view. Adds new `--tec-accent-color` variable that defaults to `--tec-link-color`
