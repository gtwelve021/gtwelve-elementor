# gtwelve-elementor

Custom Elementor widgets for G12 pages.

**Latest version: 1.0.128**

## Latest changes

### 1.0.128

- Fixed the G12 Feature Benefits carousel appearing blank or stacking cards vertically when Swiper layout styles were missing.
- Added the Swiper stylesheet dependency and scoped track and slide layout rules.
- Verified the fix in a browser preview at desktop, tablet, and mobile widths, including autoplay and looping. PHP syntax checks passed for all 32 PHP files.

### 1.0.127

- Removed the Home V2 hero's full-screen minimum height that caused large desktop gaps.

## Installation and updates

Upload the release ZIP containing the `gtwelve-elementor/` folder through **WordPress > Plugins > Add New > Upload Plugin**. When updating an existing installation, replace the installed plugin with the uploaded version. Elementor is required.

After updating, clear the site and CDN caches. If styles remain stale, regenerate Elementor CSS and data, then check the public page.

## G12 Mega Header

Version 1.0.126 includes **G12 Mega Header** in Elementor's GTwelve category, based on the supplied header HTML. Add it to a full-width header container with zero padding. Use one global header per page.

The content sections expose the supplied labels, URLs, images, and image alt text, with Elementor dynamic tags enabled. The original menu hierarchy is preserved; these controls edit its existing content rather than adding or removing menu groups. Style controls cover accent, text, border, and top-bar colors. Header Settings includes Scroll Behavior and top-bar visibility. Version 1.0.118 defaults existing widgets to Sticky and Compact on Scroll; select Scroll with Page to opt out. The retired child-theme scroll.js is dequeued when this widget renders.

The widget includes its own fonts, images, CSS, and JavaScript. Desktop mega menus, nested tabs, mobile accordions, Escape-to-close, focus trapping, and the compact scroll state follow the supplied design. The older G12 Site Header widget and its dedicated CSS/JS have been removed in version 1.0.126.

Version 1.0.119 aligns desktop mega menus to the navigation link row and removes menu hover background fills.

Version 1.0.120 widens desktop mega menus by 20 percent, keeps them centered within the header, and aligns the Digital dropdown beneath its menu item at the same vertical position.

Version 1.0.121 preserves the edited dropdown link padding (4px 0) and adds seven typography groups under Fonts and Text Colors. Each supports font family, size, weight, line height, spacing and transform through Elementor. Style also includes text/hover/active colors, header/scrolled/panel backgrounds, responsive logo widths, header heights, gaps and padding. Leave optional controls unset to keep the supplied CSS.
