const gulp = require('gulp');
const gulpif = require('gulp-if');
const uglify = require('gulp-uglify');
const notify = require('gulp-notify');
const rename = require('gulp-rename');
const options      = require( 'gulp-options' );
const stripDebug   = require( 'gulp-strip-debug' );
const sourcemaps = require('gulp-sourcemaps');
const browserify   = require( 'browserify' );
const babelify     = require( 'babelify' );
const source       = require( 'vinyl-source-stream' );
const buffer       = require( 'vinyl-buffer' );

// CSS related plugins
const dartSass         = require( 'sass' );
const gulpSass         = require( 'gulp-sass' );
const sass = gulpSass(dartSass);
const autoprefixer = require( 'gulp-autoprefixer' );
const minifycss    = require( 'gulp-uglifycss' );

// Browers related plugins
const browserSync  = require( 'browser-sync' ).create();
const reload       = browserSync.reload;

var projectURL   = 'https://test.dev';
var styleBack    = './src/scss/settings.scss';
var styleFront     = './src/scss/frontend.scss';
var styleDest     = './assets';
var mapURL       = './';

var jsSrc        = './src/js/';
var jsDest        = './assets/';
var jsBack    = 'settings.js';
var jsFront     = 'frontend.js';
var jsFiles      = [jsBack, jsFront];

var styleWatch   = './src/scss/**/*.scss';
var jsWatch      = './src/js/**/*.js';
var phpWatch     = './**/*.php';



gulp.task( 'browser-sync', function() {
	browserSync.init({
		proxy: projectURL,
		https: {
			key: 'C:/Users/ori/.config/certificates/test_key.pem',
			cert: 'C:/Users/ori/.config/certificates/test_cert.pem'
		},
		injectChanges: true,
		open: false
	});
});

gulp.task('styles', function() {
    return gulp.src( [styleBack, styleFront], {allowEmpty: true} )
        .pipe( sourcemaps.init() )
        .pipe( sass({errLogToConsole: true, outputStyle: 'compressed'}) )
        .on( 'error', console.error.bind( console ) )
        .pipe( autoprefixer() )
        .pipe( sourcemaps.write( mapURL ) )
        .pipe( gulp.dest( styleDest ) )
        .pipe( browserSync.stream() );
});

gulp.task('js', function(cb) {
    jsFiles.map(function(entry) {
		return browserify({
			entries: [ jsSrc + entry ]
		})
		.transform( babelify )
		.bundle()
		.pipe( source( entry ) )
		.pipe( buffer() )
		.pipe( gulpif( options.has( 'production' ), stripDebug() ) )
		.pipe( sourcemaps.init({ loadMaps: true }) )
		.pipe( uglify() )
		.pipe( sourcemaps.write( '.' ) )
		.pipe( gulp.dest( jsDest ) )
		.pipe( browserSync.stream() );
	});
	cb();
});

gulp.task( 'build', gulp.series('styles', 'js'), function() {
    return gulp.src( jsURL + 'myscript.min.js' )
		.pipe( notify({ message: 'Assets Compiled!' }) );
});


gulp.task( 'watch', function() {
    gulp.watch( phpWatch );
    gulp.watch( styleWatch, gulp.series( 'styles' ) );
    gulp.watch( jsWatch, gulp.series( 'js' ) );
    // gulp.src( jsURL + 'myscript.min.js' )
	// 	.pipe( notify({ message: 'Gulp is Watching, Happy Coding!' }) );
});
