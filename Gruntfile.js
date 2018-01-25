module.exports = function (grunt) {

	require('time-grunt')(grunt);
	grunt.loadNpmTasks('grunt-shell');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-uglify-es');
	grunt.loadNpmTasks('grunt-contrib-jshint');

	// Task configuration will be written here.
	grunt.initConfig({
		package: grunt.file.readJSON('package.json'),
		// Ejecute shell commands
		shell: {
			options: {
				stdout: true
			},
			npm_install: {
				command: 'npm install'
			},
			bower_install: {
				command: 'bower install'
			},
			copy_fonts: {
				command: '\\cp -R -u -p bower_components/bootstrap/fonts/* public/fonts/'
			},
			copy_fast: {
				command: '\\cp -R -u -p public/assets/app.js public/assets/app.min.js && ' +
					'\\cp -R -u -p public/assets/app.css public/assets/app.min.css'
			},
			clean: {
				command: '\\rm -rf public/assets/app.js && \\rm -rf public/assets/app.css'
			}
		},
		// Concatenate our JavaScript and CSS files.
		concat: {
			css: {
				options: {
					stripBanners: true
				},
				dest: './public/assets/app.css',
				src: [
					'bower_components/angular-dialog-service/dist/dialogs.min.css',
					'bower_components/angular-bootstrap/ui-bootstrap-csp.css',
					'bower_components/bootstrap/dist/css/bootstrap.min.css',
					'bower_components/angular-toastr/dist/angular-toastr.min.css',
                    'bower_components/nya-bootstrap-select/dist/css/nya-bs-select.min.css',
                    'bower_components/angular-openlayers-directive/css/markers.css',
                    'bower_components/angular-openlayers-directive/css/openlayers.css',
                    'bower_components/angular-openlayers-directive/dist/angular-openlayers-directive.css'
				]
			},
			scripts: {
				options: {
					separator: ';\n',
					stripBanners: true
				},
				dest: './public/assets/app.js',
				src: [
					'bower_components/jquery/dist/jquery.min.js',
					'bower_components/angular/angular.min.js',
                    'bower_components/angular-animate/angular-animate.min.js',
                    'bower_components/angular-bootstrap/ui-bootstrap.min.js',
					'bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
					'bower_components/angular-cookies/angular-cookies.min.js',
					'bower_components/angular-dialog-service/dist/dialogs-default-translations.min.js',
					'bower_components/angular-dialog-service/dist/dialogs.min.js',
					'bower_components/angular-route/angular-route.min.js',
					'bower_components/angular-sanitize/angular-sanitize.min.js',
					'bower_components/angular-toastr/dist/angular-toastr.min.js',
					'bower_components/angular-toastr/dist/angular-toastr.tpls.min.js',
					'bower_components/bootstrap/dist/js/bootstrap.min.js',
                    'bower_components/bootstrap/dist/js/bootstrap.min.js',
                    'bower_components/nya-bootstrap-select/dist/js/nya-bs-select.min.js',
                    'bower_components/angular-file-upload/dist/angular-file-upload.min.js',
                    'bower_components/angular-openlayers-directive/dist/angular-openlayers-directive.min.js',

					'public/app/app.js',
					'public/app/**/*.js',
					'public/app/**/**/*.js'
				]
			}
		},
		// Compress CSS files.
		cssmin: {
			options: {
				specialComments: false,
				advanced: true,
				colors: true,
				report: 'min'
			},
			minify: {
				src: ['public/assets/app.css'],
				dest: 'public/assets/app.min.css'
			}
		},
		// Compress JS files.
		uglify: {
			options: {
				mangle: false,
				report: 'min',
				screwIE8: true,
				beautify: false,
				drop_console: true,
				preserveComments: false
			},
			my_target: {
				files: {
					'public/assets/app.min.js': ['public/assets/app.js']
				}
			}
		},
		// Validate files with JSHint.
		jshint: {
			options: {
				reporter: require('jshint-stylish'),
				force: true,
				esversion: 6,
			},
			all: ['public/app/*.js', 'public/app/**/*.js', 'public/app/**/**/*.js']
		}
	});

	// Register all tasks.
	grunt.registerTask('default', ['shell:copy_fonts', 'concat', 'cssmin', 'uglify', 'shell:clean']);
	grunt.registerTask('install', ['shell:npm_install', 'shell:bower_install']);
	
	grunt.registerTask('test', ['jshint']);
	
	grunt.registerTask('devel', ['shell:copy_fonts', 'concat', 'shell:copy_fast', 'shell:clean']);
	grunt.registerTask('prod', ['shell:copy_fonts', 'concat', 'cssmin', 'uglify', 'shell:clean']);
};