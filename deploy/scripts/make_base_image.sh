#!/bin/sh

mkdir -p .vm

set -e

BASE_IMAGE_PATH=base-image.qcow2

cd .vm

if [ -f $BASE_IMAGE_PATH ]; then
    echo "Base image already set up."
    exit 0
fi

echo "Fetching image..."
wget https://people.debian.org/%7Eaurel32/qemu/amd64/debian_wheezy_amd64_standard.qcow2 \
     -O $BASE_IMAGE_PATH
echo "... done."

# ... that's obviously not the end of it, but it's "a start" maybe? ;p
