# Collecting


Add collecting forms to your Omeka S sites.

### Version 1.5.3-alpha

This is a customized version of the Collecting module which allows grouping
of related media metadata fields and paged presentation of these grouped
fields to the user who is uploading media to a site.

The Collecting module was modified to include a new "screen" element in the
to both the admin Collecting form and to the presentation form. This screen
element is a number which can be used to group related metadata
fields (i.e. multiple form fields with screen=2 will be presented on the second
screen when the user is uploading a media file and adding metadata
for the file).

This version of the Collecting module adds a screen field to the Doctrine-based
database table for the module. Installing the module will update/migrate the database
schema. A downgrade database migration is included, but currently has not been
tested, for uninstalling this module from an Omeka-S installation.

See the [Omeka S user manual](http://omeka.org/s/docs/user-manual/modules/collecting/) for user documentation.

## Installation

See general end user documentation for [Installing a module](http://omeka.org/s/docs/user-manual/modules/#installing-modules)
