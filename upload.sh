#!/bin/bash
# This script does some various utility tasks
# Builds the static site using Jekyll
# And syncs the generated site with S3

# You can run this script with three options
# -i  | enable Image processing. Creates thumbnails and quickly compresses images.
# -c  | enable maximum Compression for images. Creates thumbnails, thoroughly compresses images, and takes a long time doing it
# -n  | No-upload mode. Doesn't upload the build to S3.
# -s  | enable Setup mode. Downloads the necessary npm files for compression

# BUILD OPTIONS - EDIT THESE
SITE_S3='s3://daviseford-website-code/shittalk/'    # Your S3 bucket address
SITE_BUILD_DIR='.'                       # Where your site is generated
CSS_BUILD_DIR="${SITE_BUILD_DIR}/public/css/"   # Generated CSS location
JS_BUILD_DIR="${SITE_BUILD_DIR}/public/js/"     # Generated JS location

CSS_SRC_DIR='./css/'                     # Source CSS
JS_SRC_DIR='./js/'                       # Source JS
IMG_SRC_DIR='./img/'                     # Source images

# BUILD OPTIONS - EDIT THESE
IS_JEKYLL_SITE=false         # If true, will run jekyll build process

MINIFY_BUILD_CSS=false       # Minify any CSS in your CSS_BUILD_DIR
MINIFY_BUILD_JS=false        # Minify any JS files in your JS_BUILD_DIR
BABELIFY_BUILD_JS=false      # Babelify any JS files in your JS_BUILD_DIR

MINIFY_SRC_CSS=true         # Minify any CSS in your CSS_SRC_DIR
MINIFY_SRC_JS=true          # Minify any JS files in your JS_SRC_DIR

MINIFY_HTML=false            # Minify the Jekyll-generated HTML in your SITE_BUILD_DIR
COMPRESS_IMG=true           # If true, will compress all png and jpg files in the IMG_SRC_DIR
RENAME_IMG=false             # If true, will rename files in IMG_SRC_DIR from ".JPG" and ".jpeg" to ".jpg"
THUMBNAILS=false             # If true, will create a /thumbnails/ directory in your IMG_SRC_DIR
                            # with all of your current IMG_SRC_DIR structure copied over

FAVICONS=false              # If true, will generate favicon files for you
                            # Looks at /favicon.png and favicon_cfg.json
                            # Uses https://realfavicongenerator.net/ CLI tool

# END EDITING. DO NOT EDIT PAST THIS POINT.

SCRIPT_NAME=$(basename $BASH_SOURCE)
TEMP_SCRIPT_NAME="build.sh"

# We combine the options of this file with the logic available on our gist
sed '/# END EDITING. DO NOT EDIT PAST THIS POINT/q' "$SCRIPT_NAME" > ${TEMP_SCRIPT_NAME}
curl -s https://gist.githubusercontent.com/daviseford/2b6ccde756f3f3fc473c2f8bf5ab14c9/raw/ |
sed '1,/# END EDITING. DO NOT EDIT PAST THIS POINT/d' >> ${TEMP_SCRIPT_NAME}

# https://stackoverflow.com/questions/4824590/propagate-all-arguments-in-a-bash-shell-script
sh ${TEMP_SCRIPT_NAME} "$@"
rm -f ${TEMP_SCRIPT_NAME}