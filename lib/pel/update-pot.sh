#!/bin/sh
#
#  PEL: PHP Exif Library.  A library with support for reading and
#  writing all Exif headers in JPEG and TIFF images using PHP.
#
#  Copyright (C) 2004  Martin Geisler.
#
#  This program is free software; you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation; either version 2 of the License, or
#  (at your option) any later version.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program in the file COPYING; if not, write to the
#  Free Software Foundation, Inc., 51 Franklin St, Fifth Floor,
#  Boston, MA 02110-1301 USA

# $Id: update-pot.sh,v 1.1 2008/11/27 10:02:29 manolis Exp $


# This small script will update the pel.pot template file in the po
# directory so that it contains the all the strings used in PEL.

echo -n Extracting translatable strings...
xgettext --output=po/pel.pot \
    --keyword=tra            \
    --keyword=fmt            \
    --flag=fmt:1:php-format  \
    Pel*.php
echo done.

for po in po/*.po; do
    echo -n Updating $po:
    msgmerge -v -U $po po/pel.pot
done
