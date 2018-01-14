/**
 * Created by giang on 12/26/15.
 */
var gulp = require('gulp');
var concat = require('gulp-concat');
var minifyCss = require('gulp-minify-css');
var uglify = require('gulp-uglify');
var streamqueue  = require('streamqueue');
var rename = require('gulp-rename');
var htmlmin = require('gulp-htmlmin');
var config = {
    SCRIPT_DEST : 'web/js/',
    SCRIPT_FILE : 'app.min.js'
};
gulp.task('default', ['styles', 'scripts', 'retrocity', 'icecreamcake','fallinlove','christmaswedding', 'angelcar', 'welcome','gardenwedding', 'goldstar', 'beautifulday', 'winterwonderland', 'luxuryblack-styles', 'guestbook', 'html-minify'], function(){
    console.log('i am GULP');
});

gulp.task('scripts', function(){
    gulp.src([
        'web/bundles/viettutweb/js/lib/jquery-1.11.1.min.js',
        'web/bundles/viettutweb/js/lib/bootstrap.min.js',
        'web/bundles/viettutweb/js/lib/clipboard.min.js',
        'web/bundles/viettutweb/js/lib/jquery.mobile-1.4.3.min.js',
        'web/bundles/viettutweb/js/templates/common/jquery.mobile.init.js',
        'web/bundles/viettutweb/js/lib/masonry.pkgd.min.js',
        'web/bundles/viettutweb/js/lib/jquery.scrollTo.min.js',
        'web/bundles/viettutweb/js/templates/common/photoswipe.js',
        'web/bundles/viettutweb/js/templates/common/photoswipe-ui-default.js',
        'web/bundles/viettutweb/js/templates/common/popup.js',
    ])
    .pipe(concat('libraries.temp'))
    .pipe(gulp.dest(config.SCRIPT_DEST))
    .pipe(rename('libraries.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(config.SCRIPT_DEST));
});

gulp.task('base-scripts', function(){
    gulp.src([
        'web/bundles/viettutweb/vendor/jquery/jquery.js',
        'web/bundles/viettutweb/vendor/jquery.appear/jquery.appear.js',
        'web/bundles/viettutweb/vendor/jquery.easing/jquery.easing.js',
        'web/bundles/viettutweb/vendor/jquery-cookie/jquery-cookie.js',
        'web/bundles/viettutweb/vendor/bootstrap/bootstrap.js',
        'web/bundles/viettutweb/vendor/common/common.js',
        'web/bundles/viettutweb/vendor/jquery.stellar/jquery.stellar.js',
        'web/bundles/viettutweb/vendor/isotope/jquery.isotope.js',
        'web/bundles/viettutweb/vendor/owlcarousel/owl.carousel.js',
        'web/bundles/viettutweb/js/theme.js',
        'web/bundles/viettutweb/vendor/rs-plugin/js/jquery.themepunch.tools.min.js',
        'web/bundles/viettutweb/vendor/rs-plugin/js/jquery.themepunch.revolution.min.js',
        'web/bundles/bundles/viettutweb/vendor/circle-flip-slideshow/js/jquery.flipshow.js',
        'web/bundles/viettutweb/js/views/view.home.js',
        'web/bundles/viettutweb/js/custom.js',
        'web/bundles/viettutweb/js/theme.init.js'
    ])
    .pipe(concat('base.temp.js'))
    .pipe(gulp.dest(config.SCRIPT_DEST))
    .pipe(rename('base.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(config.SCRIPT_DEST));
});

gulp.task('base-styles', function(){
    gulp.src([
        'web/bundles/viettutweb/vendor/bootstrap/bootstrap.css',
        'web/bundles/viettutweb/vendor/fontawesome/css/font-awesome.css',
        'web/bundles/viettutweb/vendor/owlcarousel/owl.carousel.min.css',
        'web/bundles/viettutweb/vendor/owlcarousel/owl.theme.default.min.css',
        'web/bundles/viettutweb/vendor/magnific-popup/magnific-popup.css',
        'web/bundles/viettutweb/css/theme.css',
        'web/bundles/viettutweb/css/theme-elements.css',
        'web/bundles/viettutweb/css/theme-blog.css',
        'web/bundles/viettutweb/css/theme-shop.css',
        'web/bundles/viettutweb/css/theme-animate.css',
        'web/bundles/viettutweb/vendor/rs-plugin/css/settings.css',
        'web/bundles/viettutweb/vendor/circle-flip-slideshow/css/component.css',
        'web/bundles/viettutweb/css/skins/default.css',
        'web/bundles/viettutweb/css/custom.css'
    ])
        .pipe(concat('base.temp.css'))
        .pipe(gulp.dest(config.SCRIPT_DEST))
        .pipe(rename('base.min.css'))
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

gulp.task('gardenwedding', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/gardenwedding/style.css',
        'web/bundles/viettutweb/css/templates/gardenwedding/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/gardenwedding'))
});

gulp.task('luxuryblack-styles', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/luxuryblack/style.css',
    ]).pipe(minifyCss()).pipe(gulp.dest('web/css/luxuryblack'))
});

gulp.task('goldstar', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/goldstar/style.css',
        'web/bundles/viettutweb/css/templates/goldstar/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/goldstar'))
});

gulp.task('christmaswedding', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/christmaswedding/style.css',
        'web/bundles/viettutweb/css/templates/christmaswedding/app.css',
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/christmaswedding'))
});

gulp.task('fallinlove', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/fallinlove/style.css',
        'web/bundles/viettutweb/css/templates/fallinlove/app.css',
        'web/bundles/viettutweb/css/templates/fallinlove/animate.css',
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/fallinlove'))
});

gulp.task('icecreamcake', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/icecreamcake/style.css',
        'web/bundles/viettutweb/css/templates/icecreamcake/app.css',
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/icecreamcake'))
});

gulp.task('retrocity', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/retrocity/style.css',
        'web/bundles/viettutweb/css/templates/retrocity/app.css',
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/retrocity'))
});

gulp.task('angelcar', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/angelcar/style.css',
        'web/bundles/viettutweb/css/templates/angelcar/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/angelcar'))
});

gulp.task('beautifulday', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/beautifulday/style.css',
        'web/bundles/viettutweb/css/templates/beautifulday/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/beautifulday'))
});

gulp.task('winterwonderland', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/winterwonderland/style.css',
        'web/bundles/viettutweb/css/templates/winterwonderland/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/winterwonderland'))
});

gulp.task('welcome', function(){
    gulp.src([
        'web/bundles/viettutweb/css/templates/welcome/style.css',
        'web/bundles/viettutweb/css/templates/welcome/app.css'
    ]).pipe(concat('app.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/welcome'))
});

gulp.task('guestbook', ['guestbook-scripts', 'guestbook-styles', 'guestbook-libraries'], function () {});
gulp.task('guestbook-scripts', function () {
    gulp.src([
        'web/bundles/viettutweb/js/guest_book.js'
    ])
        .pipe(uglify())
        .pipe(gulp.dest(config.SCRIPT_DEST + '/guestbook'));
});

gulp.task('guestbook-styles', function () {
    gulp.src([
        'web/bundles/viettutweb/css/templates/common/snsbbs.css',
        'web/bundles/viettutweb/css/templates/common/emoticon.css',
        'web/bundles/viettutweb/css/lib/jquery.cropbox.custom.css',
        'web/bundles/viettutweb/css/lib/font-awesome.min.css'
    ]).pipe(concat('guestbook.css')).pipe(minifyCss()).pipe(gulp.dest('web/css/guestbook'))
});

gulp.task('guestbook-libraries', function () {
    gulp.src([
        'web/bundles/viettutweb/js/lib/jquery-1.11.1.min.js',
        'web/bundles/viettutweb/js/lib/mustache.js',
        'web/bundles/viettutweb/js/lib/masonry.pkgd.min.js',
        'web/bundles/viettutweb/js/lib/imagesloaded.pkgd.min.js',
        'web/bundles/viettutweb/js/lib/hammer.js',
        'web/bundles/viettutweb/js/lib/jquery.mousewheel.js',
        'web/bundles/viettutweb/js/lib/jquery.cropbox.custom.js'
    ])
        .pipe(concat('guestbook-libraries.temp'))
        .pipe(gulp.dest(config.SCRIPT_DEST))
        .pipe(rename('guestbook-libraries.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(config.SCRIPT_DEST));
});

gulp.task('gardenwedding-html-minify', function() {
    return gulp.src('src/Viettut/Bundle/WebBundle/Resources/views/gardenwedding/index.html.twig')
        .pipe(htmlmin({collapseWhitespace: true, minifyJS: true, removeComments: true}))
        .pipe(rename('gardenwedding.min.twig'))
        .pipe(gulp.dest('src/Viettut/Bundle/WebBundle/Resources/views/gardenwedding/'));
});


gulp.task('html-minify', ['icecreamcake-html-minify','fallinlove-html-minify','christmaswedding-html-minify', 'angelcar-html-minify','beautifulday-html-minify', 'gardenwedding-html-minify', 'goldstar-html-minify', 'winterwonderland-html-minify', 'welcome-html-minify'], function() {
});

gulp.task('angelcar-html-minify', function() {
    return gulp.src('src/Viettut/Bundle/WebBundle/Resources/views/angelcar/index.html.twig')
        .pipe(htmlmin({collapseWhitespace: true, minifyJS: true, removeComments: true}))
        .pipe(rename('angelcar.min.twig'))
        .pipe(gulp.dest('src/Viettut/Bundle/WebBundle/Resources/views/angelcar/'));
});

gulp.task('beautifulday-html-minify', function() {
    return gulp.src('src/Viettut/Bundle/WebBundle/Resources/views/beautifulday/index.html.twig')
        .pipe(htmlmin({collapseWhitespace: true, minifyJS: true, removeComments: true}))
        .pipe(rename('beautifulday.min.twig'))
        .pipe(gulp.dest('src/Viettut/Bundle/WebBundle/Resources/views/beautifulday/'));
});

gulp.task('goldstar-html-minify', function() {
    return gulp.src('src/Viettut/Bundle/WebBundle/Resources/views/goldstar/index.html.twig')
        .pipe(htmlmin({collapseWhitespace: true, minifyJS: true, removeComments: true}))
        .pipe(rename('goldstar.min.twig'))
        .pipe(gulp.dest('src/Viettut/Bundle/WebBundle/Resources/views/goldstar/'));
});

gulp.task('winterwonderland-html-minify', function() {
    return gulp.src('src/Viettut/Bundle/WebBundle/Resources/views/winterwonderland/index.html.twig')
        .pipe(htmlmin({collapseWhitespace: true, minifyJS: true, removeComments: true}))
        .pipe(rename('winterwonderland.min.twig'))
        .pipe(gulp.dest('src/Viettut/Bundle/WebBundle/Resources/views/winterwonderland/'));
});

gulp.task('welcome-html-minify', function() {
    return gulp.src('src/Viettut/Bundle/WebBundle/Resources/views/welcome/index.html.twig')
        .pipe(htmlmin({collapseWhitespace: true, minifyJS: true, removeComments: true}))
        .pipe(rename('welcome.min.twig'))
        .pipe(gulp.dest('src/Viettut/Bundle/WebBundle/Resources/views/welcome/'));
});

gulp.task('christmaswedding-html-minify', function() {
    return gulp.src('src/Viettut/Bundle/WebBundle/Resources/views/christmaswedding/index.html.twig')
        .pipe(htmlmin({collapseWhitespace: true, minifyJS: true, removeComments: true}))
        .pipe(rename('christmaswedding.min.twig'))
        .pipe(gulp.dest('src/Viettut/Bundle/WebBundle/Resources/views/christmaswedding/'));
});

gulp.task('fallinlove-html-minify', function() {
    return gulp.src('src/Viettut/Bundle/WebBundle/Resources/views/fallinlove/index.html.twig')
        .pipe(htmlmin({collapseWhitespace: true, minifyJS: true, removeComments: true}))
        .pipe(rename('fallinlove.min.twig'))
        .pipe(gulp.dest('src/Viettut/Bundle/WebBundle/Resources/views/fallinlove/'));
});

gulp.task('icecreamcake-html-minify', function() {
    return gulp.src('src/Viettut/Bundle/WebBundle/Resources/views/icecreamcake/index.html.twig')
        .pipe(htmlmin({collapseWhitespace: true, minifyJS: true, removeComments: true}))
        .pipe(rename('icecreamcake.min.twig'))
        .pipe(gulp.dest('src/Viettut/Bundle/WebBundle/Resources/views/icecreamcake/'));
});