=============================
PLUGIN NAME
=============================
related items

=============================
PLUGIN DESCRIPTION
=============================

adds an area for all major elgg entity types that renders a list of related items from the installation, matched by tags.
the greater the number of matching tags between the presently viewed item and the others in the site, the more 'related' they are identified to be.

=============================
CHANGELOG
=============================

3.0.1: added compatibility for elgg 3.x

2.0: added compatibility for elgg 2.0

1.0: removed javascript and added CSS flexgrid
added: icons for tidypics albums and bookmarks (if suitable plugin is installed to provide bookmark icons).
changed: icon size from medium to small for various object types
fixed: full list of items was not maintaining consistent ordering

0.9.2: fixed php warning about array

0.7.9
fixed: pagination missing on 'view all related items' page
added: count of related items to 'view all related items' link
changed: 'view all related items' link is only rendered when more are available than shown on the current item's page
0.7.8
fixed: items being shown when no tags are present for current item
0.7.7
fixed: related item subtype lable pluralisation
fixed: admin option for subtype selection was being ignored
fixed: set css size of thumbnail images
0.7.6
fixed: related item list now fits horizontally if item count is less than columns chosen in admin
added: option to place related items before or after comments
0.7.5
fixed: jquery error on resize window event
changed: icon grabbing php
added: option to enable / disable image icons
added: user icon shows if no item icon is available.
0.7.4
fixed: breadcrumb trail for 'view all related items' list is now complete for main subtypes
added: image icon support for blog_tools and au_sets (pinboards)
added: item subtype label at bottom of each related item box
fixed: css issues with chromium
0.7.3
changed: centered related items in their list
changed: padding of list items now fits better with percentages used for box widths
0.7.2
fixed: no boxes are now rendered if no related items are available
changed: missing parameters for get_related_entities functions (+ removed strict input rules for function)
---
0.7.1
changed: optimised algorithm by moving php code to sql
removed: limit on amount of tags to search for (not needed now code is more efficient)
---
0.7
added: view all related items page
---
0.6.9
fixed: checkbox labels in admin panel (1.8 deprecated warnings)
changed: further refined php logic for efficiency
fixed: php logic errors with maximum tag variable
---
0.6.8
added: further simplified code for efficiency
---
0.6.7
fixed: returned the elggobject check that filters out non objects
---
0.6.6
changed: improved performance of sql / php
added: icon for title text (you need to use a custom css value to populate this image)
---
0.6.5
fixed: added excerpt limit for related item titles
---
0.6.4
fixed: show dates option was not functional in admin panel
changed: language file strings in admin
---
0.6.3
added: thumbnail images for videos and files
added: css codes to identify thumbnail images that are stored by elgg
---
0.6.2
added: css theming for default elgg theme
fixed: logic error causing fatal break/continue message in logs.
---
0.6.1
added: options for jquery heights and number of grid columns.
---
0.6
added: admin panel for configuration of search and diplay
fixed: logic errors in certain circumstances
---
0.5.2
fixed: check for zero tags
---
0.5.1
fixed: image thumbnail path is now correctly formed for tidypics
---
0.5
added: image icons for image items
fixed: php warning for array
changed: optimised code for performance
---
0.4.2
fixed: issue with 0.4.1 where single tagged items were listed incorrectly
---
0.4.1
fixed: php warning for array
---
0.4
added: matched keywords are now displayed for each related item
added: changed css for icon element (you will need to play with this on your own site - icon images are not included).
changed: made css for name and date/time smaller
---
0.3
added: now shows related items of most elgg entity types (defined in the start.php file), not just entities of the same type as the one being viewed.
fixed: added jquery to make all list boxes the same height.
added: the box for each type of entity now has its own css class to allow customisation of appearance (see screenshot)
---
0.2
fixed: removed limit from search query: the related items list now correclty contains items from the entiree database rather than just comparing simlarity for the first 10 found.
changed: css - hover over colour changes for hyperlinks.
---
0.1
initial release
