#!/bin/bash
SITE_S3='s3://daviseford.com/shittalk/'    # Your S3 bucket address
SITE_BUILD_DIR='./dist/'    # Where your site is generated
npm run build
aws s3 sync --delete --size-only ${SITE_BUILD_DIR} ${SITE_S3} --exclude "*build_log.txt" --exclude "*.idea*" --exclude "*.sh" --exclude "*.git*" --exclude "*.DS_Store"
