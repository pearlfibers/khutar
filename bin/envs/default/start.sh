#Generic setup
wp --allow-root media import /tmp/repo/khutar/e2e-tests/cypress/fixtures/image.jpg
wp --allow-root rewrite structure /%postname%/
