// Required NPM Packages
import autoprefixer from "gulp-autoprefixer";
import browserSync from "browser-sync";
import concat from "gulp-concat";
import eslint from "gulp-eslint";
import gulp from "gulp";
import jade from "gulp-jade-php";
import minify from "gulp-clean-css";
import plumber from "gulp-plumber";
import rename from "gulp-rename";
import sass from "gulp-sass";
import sourcemaps from "gulp-sourcemaps";
import uglify from "gulp-uglify";

// Folder Destination Variables
const root = "../../../../../../";
const style = ["_scss/*.scss", "_sass/**/*.scss"];
const dashboard = ["_sass/_admin/dashboard.scss"];
const login = ["_sass/_admin/login.scss"];
const template = "_jade/*.jade";
const includes = ["_jade/_includes/*.jade"];
const javascript = "_js/*.js";
const output = "./assets";
const siteURL = "phos-framework.test";

// Loop through _scss files, compile them, concatonate them, saves to /assets as .css
gulp.task("styles", done => {
    gulp.src("./_sass/theme.scss")
        .pipe(plumber())
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(sass())
        .pipe(autoprefixer("last 2 versions", "> 5%"))
        .pipe(sourcemaps.write(undefined, { sourceRoot: null }))
        .pipe(gulp.dest(output));
    done();
});

gulp.task("minifycss", () => {
    return gulp
        .src(`${output}/theme.css`)
        .pipe(sourcemaps.init({ loadMaps: true }))
        .pipe(plumber())
        .pipe(rename({ suffix: ".min" }))
        .pipe(sourcemaps.write("./"))
        .pipe(gulp.dest(output))
        .pipe(browserSync.stream());
});

gulp.task("dashboard", done => {
    gulp.src(dashboard)
        .pipe(plumber())
        .pipe(sass())
        .pipe(autoprefixer("last 2 versions", "> 5%"))
        .pipe(concat("dashboard.min.css"))
        .pipe(minify())
        .pipe(gulp.dest(output))
        .pipe(browserSync.stream());
    done();
});

gulp.task("login", done => {
    gulp.src(login)
        .pipe(plumber())
        .pipe(sass())
        .pipe(autoprefixer("last 2 versions", "> 5%"))
        .pipe(concat("login.min.css"))
        .pipe(minify())
        .pipe(gulp.dest(output))
        .pipe(browserSync.stream());
    done();
});

// Loop through Jade files, compile them, saves to template root as .php
gulp.task("templates", done => {
    gulp.src(template)
        .pipe(plumber())
        .pipe(jade({ pretty: true }))
        .pipe(gulp.dest("./"))
        .pipe(browserSync.stream());
    done();
});

// Loop through files in the include folder
gulp.task("includes", done => {
    gulp.src(includes)
        .pipe(jade({ pretty: true }))
        .pipe(gulp.dest("./includes"))
        .pipe(browserSync.stream());
    done();
});

// Loop through JS files, compile them, concatonate them, minify them, saves to /assets as .min.js
gulp.task("javascript", done => {
    gulp.src(javascript)
        .pipe(plumber())
        .pipe(eslint())
        .pipe(concat("theme.js"))
        .pipe(rename({ suffix: ".min" }))
        .pipe(uglify())
        .pipe(gulp.dest(output))
        .pipe(browserSync.stream());
    done();
});

// Watch files in _jade, _js, _scss. Run compile tasks for respective file type if changed.
gulp.task("default", done => {
    // Start BrowserSync
    browserSync.init({
        proxy: siteURL
    });
    //Watch Jade, SCSS, and JavaScript files
    gulp.watch(style, gulp.series(["styles", "minifycss"]));
    gulp.watch(dashboard, gulp.parallel(["dashboard"]));
    gulp.watch(login, gulp.parallel(["login"]));
    gulp.watch(template, gulp.parallel(["templates"]));
    gulp.watch(includes, gulp.parallel(["includes"]));
    gulp.watch(javascript, gulp.parallel(["javascript"]));
    done();
});
