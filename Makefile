composer:
	curl -sS https://getcomposer.org/installer | php
	php composer.phar install

npm:
	./Console/cake atcmobile aggregateManifestFile package.json
	sudo npm install

bower:
	./Console/cake atcmobile aggregateManifestFile bower.json
	sudo ./node_modules/.bin/bower install --allow-root

build:
	sudo ./node_modules/.bin/grunt build

update:
	make npm
	make bower
	make composer
	make build


