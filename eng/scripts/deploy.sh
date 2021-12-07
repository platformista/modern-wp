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
	wp core update-db
fi

if [ "$PLATFORM_BRANCH" != "master" ]; then
	wp plugin deactivate jetpack
fi
