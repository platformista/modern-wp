#!/usr/bin/env bash

cd wordpress

if ! wp core is-installed; then
	WP_URL=$(echo $PLATFORM_ROUTES  | base64 --decode | jq -r 'keys[]' | grep $PLATFORM_APPLICATION_NAME | grep https | grep www)
	wp core install --url="${WP_URL}" --title="Modern WordPress" --admin_user=admin --admin_password=changeme --admin_email=change@me.com
	DEFAULT_THEME=$( jq -r '.[ "distro" ][ "default-theme" ]' ../composer.json )
	wp theme activate ${DEFAULT_THEME}
	jq -r '.[ "distro" ][ "enable-plugins" ][]' ../composer.json |
	while read PLUGIN; do
		wp plugin activate ${PLUGIN}
	done
else
	# Flushes the object cache which might have changed between current production and newly deployed changes
	wp cache flush
	# Runs the WordPress database update procedure in case core is being updated with the newly deployed changes
	wp core update-db
	# Runs all cron events that are due now and may have come due during the build+deploy procedure
	wp cron event run --due-now
fi
