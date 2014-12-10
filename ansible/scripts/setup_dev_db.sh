#!/bin/sh

echo "Setting up db with test data..."

cd /var/www/ttm
for name in core bickerdike enlace lsna swop trp; do
    sudo mysql -u root < ${name}/sql/ttm-${name}_routines.sql;
done

sudo mysql -u root < /vagrant/scripts/test_permissions.sql

sudo mysql -u root < data/lisc-ttm-sample-data.sql

echo "... done."
