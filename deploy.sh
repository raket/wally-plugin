# Remove old (if any)
rm -f wally-plugin.zip

# Compress files
zip -r wally-plugin.zip . -x \*.git\* \*node_modules\* \*bower_components\* gulpfile.js deploy.sh wally-plugin.zip \*.DS_Store\*

# Upload to raket.nu ~/vhosts/wally-wp/dist/staging
scp -i ~/.ssh/id_rsa wally-plugin.zip raketnu@raket.nu:~/vhosts/wally-wp/dist/staging/wally-plugin.zip