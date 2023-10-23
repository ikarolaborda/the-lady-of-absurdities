#!/bin/sh

# Create symbolic link for docs
#if [ ! -L "/var/www/book-api/public/docs" ]; then
#  ln -s /var/www/book-api/docs /var/www/book-api/public/docs
#fi

# Check if npm binary exists
if command -v npm > /dev/null 2>&1; then
    # Install node modules
    npm install
    npm run prod
else
    echo "npm not found! Skipping npm commands."
fi

# Start the existing entrypoint script
exec docker-php-entrypoint php-fpm
