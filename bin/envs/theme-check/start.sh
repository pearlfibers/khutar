php -d memory_limit=1024M "$(which wp)" package install anhskohbo/wp-cli-themecheck --allow-root
wp plugin install theme-check --activate --allow-root
wp themecheck --theme=khutar --no-interactive --allow-root
