/**
 * Created by giang on 12/26/15.
 */
var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var streamqueue  = require('streamqueue');
var rename = require('gulp-rename');

var config = {
    SCRIPT_DEST : 'web/js/',
    SCRIPT_FILE : 'app.min.js'
};
gulp.task('default', ['styles', 'scripts', 'gardenwedding', 'goldstar', 'beautifulday', 'winterwonderland'], function(){
    console.log('i am GULP');
});

gulp.task('scripts', function(){
    gulp.src([
        'web/bundles/viettutweb/js/lib/jquery-1.11.1.min.js',
        'web/bundles/viettutweb/js/lib/bootstrap.min.js',
        'web/bundles/viettutweb/js/lib/jquery.mobile-1.4.3.min.js',
        'web/bundles/viettutweb/js/templates/common/jquery.mobile.init.js',
        'web/bundles/viettutweb/js/lib/masonry.pkgd.min.js',
        'web/bundles/viettutweb/js/lib/jquery.scrollTo.min.js',
        'web/bundles/viettutweb/js/templates/common/photoswipe.js',
        'web/bundles/viettutweb/js/templates/common/photoswipe-ui-default.js',
        'web/bundles/viettutweb/js/templates/common/popup.js',
        'web/bundles/viettutweb/js/templates/gardenwedding/index.js'
    ])
    .pipe(concat('libraries.temp'))
    .pipe(gulp.dest(config.SCRIPT_DEST))
    .pipe(rename('libraries.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(config.SCRIPT_DEST));
});

gulp.task('styles', function(){
    gulp.src([
        'web/bundles/viettutweb/css/lib/jquery.mobile-1.4.3.min.css',
        'web/bundles/viettutweb/css/templates/common/common.css',
        'web/bundles/viettutweb/css/templates/common/photoswipe.css',
        'web/bundles/viettutweb/css/templates/common/photoswipe.skin.css',
        'web/bundles/viettutweb/css/lib/bootstrap-combined.min.css',
        'web/bundles/viettutweb/css/lib/font-awesome.min.css'
    ]).pipe(concat('libraries.min.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/'))
});

gulp.task('gardenwedding', ['gardenwedding-scripts', 'gardenwedding-styles'], function () {});
gulp.task('gardenwedding-scripts', function () {
    gulp.src([
        'web/bundles/viettutweb/js/templates/gardenwedding/index.js'
    ])
    .pipe(uglify())
    .pipe(gulp.dest(config.SCRIPT_DEST + '/gardenwedding'));
});

gulp.task('gardenwedding-styles', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/gardenwedding/style.css',
        'web/bundles/viettutweb/css/templates/gardenwedding/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/gardenwedding'))
});

gulp.task('goldstar', ['goldstar-scripts', 'goldstar-styles'], function () {});
gulp.task('goldstar-scripts', function () {
    gulp.src([
        'web/bundles/viettutweb/js/templates/goldstar/index.js'
    ])
        .pipe(uglify())
        .pipe(gulp.dest(config.SCRIPT_DEST + '/goldstar'));
});

gulp.task('goldstar-styles', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/goldstar/style.css',
        'web/bundles/viettutweb/css/templates/goldstar/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/goldstar'))
});

gulp.task('beautifulday', ['beautifulday-scripts', 'beautifulday-styles'], function () {});
gulp.task('beautifulday-scripts', function () {
    gulp.src([
        'web/bundles/viettutweb/js/templates/beautifulday/index.js'
    ])
        .pipe(uglify())
        .pipe(gulp.dest(config.SCRIPT_DEST + '/beautifulday'));
});

gulp.task('beautifulday-styles', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/beautifulday/style.css',
        'web/bundles/viettutweb/css/templates/beautifulday/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/beautifulday'))
});

gulp.task('winterwonderland', ['winterwonderland-scripts', 'winterwonderland-styles'], function () {});
gulp.task('winterwonderland-scripts', function () {
    gulp.src([
        'web/bundles/viettutweb/js/templates/winterwonderland/index.js'
    ])
        .pipe(uglify())
        .pipe(gulp.dest(config.SCRIPT_DEST + '/winterwonderland'));
});

gulp.task('winterwonderland-styles', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/winterwonderland/style.css',
        'web/bundles/viettutweb/css/templates/winterwonderland/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/winterwonderland'))
});