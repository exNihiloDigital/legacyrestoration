/**
 * Require NPM packages
 */
var gulp = require("gulp");
var sass = require("gulp-sass");
var glob = require("gulp-sass-glob");
var jade = require("gulp-jade-php");
// var empty = require('gulp-remove-empty-lines');
var prefixer = require("gulp-autoprefixer");
var concat = require("gulp-concat");
var minify = require('gulp-clean-css');
var rename = require("gulp-rename");
// var jshint = require("gulp-jshint");
var uglify = require("gulp-uglify");
var plumber = require("gulp-plumber");
// var notify = require("gulp-notify");
var util = require("gulp-util");
var wait = require("gulp-wait");
var del = require("del");

/**
 * Destination folders
 */
var root = "../../../../../../";
var theme = ["_sass/*.scss", "_sass/**/*.scss", "!_sass/dashboard.scss"];
var dashboard = "_sass/dashboard.scss";
var javascript = "_js/*.js";
var templates = "_jade/*.jade";
var includes = "_jade/_includes/*.jade";
var output = "assets";

/**
 * Tasks
 */
gulp.task("theme", function () {
    // var onError = function (err) {
        // notify.onError({
        //     title: "SASS",
        //     subtitle: "Notification",
        //     message: "<%= error.message %>",
        //     sound: false,
        //     icon: root + "_gulp_sass.jpg",
        //     onLast: true,
        //     wait: false
    //     })(err);

    //     this.emit('end');
    // }

    gulp.src(theme)
        // .pipe(plumber({ errorHandler: onError }))
        .pipe(glob())
        .pipe(wait(200))
        .pipe(sass())
        .pipe(prefixer({ browsers: ["last 2 versions", "> 5%", "Firefox ESR"] }))
        .pipe(concat("theme.min.css"))
        .pipe(minify())
        .pipe(gulp.dest(output))
});

gulp.task("dashboard", function () {
    // var onError = function (err) {
        // notify.onError({
        //     title: "Dashboard SASS",
        //     subtitle: "Notification",
        //     message: "<%= error.message %>",
        //     sound: false,
        //     icon: root + "_gulp_sass.jpg",
        //     onLast: true,
        //     wait: false
    //     })(err);

    //     this.emit('end');
    // }

    gulp.src(dashboard)
        // .pipe(plumber({ errorHandler: onError }))
        .pipe(glob())
        .pipe(sass())
        .pipe(prefixer({ browsers: ["last 2 versions", "> 5%", "Firefox ESR"] }))
        .pipe(concat("dashboard.min.css"))
        .pipe(minify())
        .pipe(gulp.dest(output))
});

gulp.task("javascript", function () {
    // var onError = function (err) {
        // notify.onError({
        //     title: "Javascript",
        //     subtitle: "Notification",
        //     message: "<%= error.message %>",
        //     sound: false,
        //     icon: root + "_gulp_js.jpg",
        //     onLast: true,
        //     wait: false
    //     })(err);

    //     this.emit('end');
    // }

    gulp.src(javascript)
        // .pipe(plumber({ errorHandler: onError }))
        // .pipe(jshint())
        .pipe(concat("theme.js"))
        .pipe(rename({ suffix: ".min" }))
        .pipe(uglify())
        .pipe(gulp.dest(output))
});

gulp.task('templates', function () {
    // var onError = function (err) {
        // notify.onError({
        //     title: "Views Includes",
        //     subtitle: "Notification",
        //     message: "<%= error.message %>",
        //     sound: false,
        //     icon: root + "_gulp_jade.jpg",
        //     onLast: true,
        //     wait: false
    //     })(err);

    //     this.emit('end');
    // }

    gulp.src(templates)
        // .pipe(plumber({ errorHandler: onError }))
        // .pipe(empty())
        .pipe(jade({ pretty: true }))
        .pipe(gulp.dest("./"))
})

gulp.task('includes', function () {
    // var onError = function (err) {
        // notify.onError({
        //     title: "Views",
        //     subtitle: "Notification",
        //     message: "<%= error.message %>",
        //     sound: false,
        //     icon: root + "_gulp_jade.jpg",
        //     onLast: true,
        //     wait: false
    //     })(err);

    //     this.emit('end');
    // }

    gulp.src(includes)
        // .pipe(plumber({ errorHandler: onError }))
        // .pipe(empty())
        .pipe(jade({ pretty: true }))
        .pipe(gulp.dest("includes"))
})

gulp.task('unpack', ['theme', 'dashboard', 'javascript', 'templates', 'includes']);

gulp.task('pack', function () {
    del(['./*.php', '!./functions.php'], {
        force: true
    })
    del('./assets/**', {
        force: true
    })
    del('./includes/**', {
        force: true
    })
})

gulp.task("default", function () {
    gulp.watch(theme, ['theme']);
    gulp.watch(dashboard, ['dashboard']);
    gulp.watch(javascript, ["javascript"]);
    gulp.watch(templates, ["templates"]);
    gulp.watch(includes, ["includes"]);
})