/* jshint node:true */
// https://github.com/kswedberg/grunt-version
module.exports = {
	packageJson: {
		options: {
			prefix: '"version"\\:\\s+"'
		},
		src: 'package.json'
	},
	stylesheet: {
		options: {
			prefix: 'Version\\:\\s+'
		},
		src: 'style.css'
	},
	scssStylesheet: {
		options: {
			prefix: 'Version\\:\\s+'
		},
		src: 'assets/scss/style.scss'
	},
	functions: {
		options: {
			prefix: 'khutar_VERSION\', \''
		},
		src: 'functions.php'
	},
	packageVersion: {
		options: {
			pkg: 'vendor/pearlfibers/pearlfibers-sdk/composer.json',
			release: 'patch',
			prefix: '\\.*\\$pearlfibers_sdk_version\.*\\s=\.*\\s\''
		},
		src: 'vendor/pearlfibers/pearlfibers-sdk/load.php'
	}
};
