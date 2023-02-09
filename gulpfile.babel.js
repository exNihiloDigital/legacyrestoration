// Required NPM Packages
import autoprefixer from 'autoprefixer';
import babel from 'gulp-babel';
import browserSync from 'browser-sync';
import cleanCSS from 'gulp-clean-css';
import concat from 'gulp-concat';
import dartSass from 'sass';
import gulp from 'gulp';
import gulpSass from 'gulp-sass';
import jade from 'gulp-jade-php';
import newer from 'gulp-newer';
import plumber from 'gulp-plumber';
import postcss from 'gulp-postcss';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';

// https://github.com/dlmanning/gulp-sass#importing-it-into-your-project
const sass = gulpSass(dartSass);

// Folder Destination Variables
const adminAcf = '_sass/_admin/acf.scss';
const adminDashboard = '_sass/_admin/dashboard.scss';
const adminGutenberg = '_sass/_admin/gutenberg.scss';
const adminLogin = '_sass/_admin/login.scss';
const javascript = '_js/*.js';
const outputJS = './assets/js';
const outputStyles = './assets/css';
const style = '_sass/*.scss';
const template = '_jade/*.jade';
const templateIncludes = '_jade/_includes/**/*.jade';

const siteURL = 'framework.local';

// Loop through _scss files, compile them, concatonate them, saves to /assets as .css
gulp.task('styles', () =>
    gulp
        .src('./_sass/theme.scss', { sourcemaps: true })
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(gulp.dest(outputStyles, { sourcemaps: true }))
);

gulp.task('minifycss', () =>
    gulp
        .src(`${outputStyles}/theme.css`, { sourcemaps: true })
        .pipe(plumber())
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(outputStyles, { sourcemaps: '.' }))
        .pipe(browserSync.stream())
);

gulp.task('acf', () =>
    gulp
        .src(adminAcf)
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(outputStyles))
        .pipe(browserSync.stream())
);

gulp.task('dashboard', () =>
    gulp
        .src(adminDashboard)
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(outputStyles))
        .pipe(browserSync.stream())
);

gulp.task('gutenberg', () =>
    gulp
        .src(adminGutenberg)
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(outputStyles))
        .pipe(browserSync.stream())
);

gulp.task('login', () =>
    gulp
        .src(adminLogin)
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer()]))
        .pipe(cleanCSS())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest(outputStyles))
        .pipe(browserSync.stream())
);

// Loop through Jade files, compile them, saves to template root as .php
gulp.task('templates', () =>
    gulp
        .src(template)
        .pipe(plumber())
        .pipe(jade())
        .pipe(newer('./'))
        .pipe(gulp.dest('./'))
        .pipe(browserSync.stream())
);

// Loop through files in the include folder
gulp.task('includes', () =>
    gulp
        .src(templateIncludes)
        .pipe(plumber())
        .pipe(jade())
        .pipe(newer('./includes'))
        .pipe(gulp.dest('./includes'))
        .pipe(browserSync.stream())
);

// Loop through JS files, compile them, concatonate them, minify them, saves to /assets as .min.js
gulp.task('javascript', () => {
    let scripts = './_js/theme.js';

    gulp.src(scripts).pipe(babel()).pipe(concat('theme.js')).pipe(gulp.dest(outputJS));

    return gulp
        .src(scripts, { allowEmpty: true })
        .pipe(babel({ presets: ['@babel/preset-env'] }))
        .pipe(concat('theme.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(outputJS))
        .pipe(browserSync.stream());
});

// Watch files in _jade, _js, _scss. Run compile tasks for respective file type if changed.
gulp.task('default', () => {
    // Start BrowserSync
    browserSync.init({
        proxy: siteURL,
    });

    //Watch Jade, SCSS, and JavaScript files
    gulp.watch(adminAcf, gulp.series('acf'));
    gulp.watch(adminDashboard, gulp.series('dashboard'));
    gulp.watch(adminGutenberg, gulp.series('gutenberg'));
    gulp.watch(adminLogin, gulp.series('login'));
    gulp.watch(javascript, gulp.series('javascript'));
    gulp.watch(style, gulp.series(['styles', 'minifycss']));
    gulp.watch(template, gulp.series('templates'));
    gulp.watch(templateIncludes, gulp.series('includes'));
});
