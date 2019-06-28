// Required NPM Packages
import gulp from "gulp";
import sass from "gulp-sass";
import jade from "gulp-jade-php";
import minify from "gulp-clean-css";
import uglify from "gulp-uglify";
import concat from "gulp-concat";
import rename from "gulp-rename";
import autoprefixer from "gulp-autoprefixer";
import browserSync from "browser-sync";
import plumber from "gulp-plumber";
import eslint from "gulp-eslint";

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

// Loop through _scss files, compile them, concatonate them, minify them, saves to /assets as .min.css
gulp.task("styles", done => {
  gulp
    .src(style)
    .pipe(plumber())
    .pipe(sass())
    .pipe(autoprefixer("last 2 versions", "> 5%"))
    .pipe(concat("theme.min.css"))
    .pipe(minify())
    .pipe(gulp.dest(output))
    .pipe(browserSync.stream());
  done();
});

gulp.task("dashboard", done => {
  gulp
    .src(dashboard)
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
  gulp
    .src(login)
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
  gulp
    .src(template)
    .pipe(plumber())
    .pipe(jade({ pretty: true }))
    .pipe(gulp.dest("./"))
    .pipe(browserSync.stream());
  done();
});

// Loop through files in the include folder
gulp.task("includes", done => {
  gulp
    .src(includes)
    .pipe(jade({ pretty: true }))
    .pipe(gulp.dest("./includes"))
    .pipe(browserSync.stream());
  done();
});

// Loop through JS files, compile them, concatonate them, minify them, saves to /assets as .min.js
gulp.task("javascript", done => {
  gulp
    .src(javascript)
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
  gulp.watch(style, gulp.parallel(["styles"]));
  gulp.watch(dashboard, gulp.parallel(["dashboard"]));
  gulp.watch(login, gulp.parallel(["login"]));
  gulp.watch(template, gulp.parallel(["templates"]));
  gulp.watch(includes, gulp.parallel(["includes"]));
  gulp.watch(javascript, gulp.parallel(["javascript"]));
  done();
});
