var gulp = require('gulp'),
		config = require('./gulpconfig.json'), // local config file
		$ = require('gulp-load-plugins')(),
		sass = require('gulp-sass'),
		concat = require('gulp-concat'),
		sourcemaps = require('gulp-sourcemaps'),
		autoprefixer = require('gulp-autoprefixer'),
		connect = require('gulp-connect-php'),
		browserSync = require('browser-sync'),
		jshint = require('gulp-jshint'),
		clean = require('gulp-clean'),
		_ = require('lodash');

var reload  = browserSync.reload;
var paths = {
	sass: [
		'assets/stylesheets/**/*.scss',
	],
	js: [
		'assets/javascripts/*.js'
	],
	vendors: [
		{
			src: 'node_modules/bootstrap-sass/assets/fonts/**/*', // bootstrap fonts
			dest: config.dist + '/fonts/',
		}
	],
	vendorsJs: [
		'node_modules/jquery/dist/jquery.min.js',
		'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
		'node_modules/moment/min/moment.min.js',
		'node_modules/bootstrap-daterangepicker/daterangepicker.js',
		'node_modules/slick-carousel/slick/slick.js',
		'node_modules/omni-slider/omni-slider.js',
		'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js'
	]
};

// Build Sass
gulp.task('sass', function() {
	return gulp.src(paths.sass)
		.pipe(sourcemaps.init())
		.pipe($.sass({
			outputStyle: 'compressed' // if css compressed **file size**
		})
		.on('error', $.sass.logError))
		.pipe($.autoprefixer({
			browsers: ['last 2 versions', 'ie >= 9']
		}))
    .pipe(sourcemaps.write(''))
		.pipe(gulp.dest( config.dist + '/css/'));
});

// Build App JavaScripts
gulp.task('javascript',function() {
	return gulp.src(paths.js)
		.pipe(sourcemaps.init())
		.pipe(concat('app.js'))
		.pipe(sourcemaps.write(''))
		.pipe(gulp.dest( config.dist + '/js/'));
});

// Validate JavaScripts
gulp.task('lint', function() {
	return gulp.src(paths.js)
		.pipe(jshint())
		.pipe(jshint.reporter('default'));
});

// Build Vendors JavaScript
gulp.task('vendorsJs', function() {
	return gulp.src(paths.vendorsJs)
		.pipe(sourcemaps.init())
		.pipe(concat('vendors.js'))
		.pipe(sourcemaps.write(''))
		.pipe(gulp.dest( config.dist + '/js/'));
});

// TODO: copy assets to dist not assets
gulp.task('copyVendors',function(){
	return _.map(paths.vendors,function(vendor){
		return gulp.src(vendor.src)
			.pipe(gulp.dest(vendor.dest));
	});
});

gulp.task('clean', function () {
  return gulp.src( config.dist , {read: true})
  	.pipe(clean());
});

gulp.task('connect', function() {
  connect.server({port: 8010, keepalive: true});
});

gulp.task('browser-sync',['connect'], function() {
  browserSync.init({
		proxy: '127.0.0.1:8010',
		port: 8080,
		open: true,
		notify: false
  });
});

gulp.task('build', ['lint','copyVendors','sass','vendorsJs','javascript']);

gulp.task('dev', ['copyVendors','sass','vendorsJs','javascript','browser-sync'], function() {
	gulp.watch([paths.sass,paths.js,'views/**/*.php'], ['sass','javascript',reload]);
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['build']);
