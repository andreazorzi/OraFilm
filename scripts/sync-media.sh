server=<server>
maindir=/var/docker/<app>

bash -c '
    rsync -avz --max-size=10M --ignore-existing \
    '$server':'$maindir'/uploads/ ./public/uploads/
'