# Copy the .env.example file to .env
cp -R -n -p .env.example .env

# Install dependencies
composer install

# Init Laravel
set containers (docker ps -q)
if test (count $containers) -gt 0
    docker stop $containers
end
./vendor/bin/sail up -d

# Install NPM packages
./vendor/bin/sail npm install

# Generate Laravel key
./vendor/bin/sail artisan key:generate

# Run migrations
./vendor/bin/sail artisan migrate

# Run Vite
./vendor/bin/sail npm run dev
