// ---------------
// General plugins
// ---------------
import gulp from 'gulp';
import autoprefixer from 'gulp-autoprefixer';
import browserSyncPkg from 'browser-sync';
import chalk from 'chalk';
import colors from 'ansi-colors';
import gulpIf from 'gulp-if';
import log from 'fancy-log';
import noop from 'gulp-noop';
import rename from 'gulp-rename';
import clean from 'gulp-rimraf';

import dartSass from 'sass';
import gulpSass from 'gulp-sass';
const sass = gulpSass(dartSass);
import fs from 'fs';

import sassGlob from 'gulp-sass-glob';
import sourcemaps from 'gulp-sourcemaps';
import cleanCss from 'gulp-clean-css';
import uglifyPkg from 'gulp-uglify-es';

const uglify = uglifyPkg.default;
const browserSync = browserSyncPkg.create();

// -----------------
// Paths & Config
// -----------------
const basePath = {
    src: './src/',
    assets: './assets/',
    templates: './templates/',
};

const path = {
    styles: {
        src: basePath.src + 'scss/',
        assets: './',
    },
    scripts: {
        src: 'js/',
        assets: basePath.assets + 'js/',
    },
    images: {
        src: basePath.src + 'image/',
        assets: basePath.assets + 'image/',
    },
    fonts: {
        src: basePath.src + 'font/',
        assets: basePath.assets + 'font/',
    },
    templates: {
        assets: basePath.templates,
    },
    node_modules: 'node_modules/',
    breakpoint_sass: 'breakpoint-sass/stylesheets/',
    fontAwesome: 'font-awesome/scss/',
};

// -----------------
// Utility function
// -----------------
const changeEvent = (evt) => {
    log(
        'File',
        colors.cyan(
            evt.path.replace(new RegExp('/.*(?=/' + basePath.src + ')/'), '')
        ),
        'was',
        colors.magenta(evt.type)
    );
};

// -----------------
// BrowserSync
// -----------------
function browserSyncInit(done) {
    browserSync.init({
        files: [path.styles.assets + '**/*.css', path.scripts.assets + '**/*.js'],
        proxy: 'http://appserver',
        socket: {
            domain: 'http://spouse.lndo.site',
            port: 80,
        },
        injectChanges: true,
        open: false,
        logLevel: 'debug',
        logConnections: true,
    });
    done();
}

// -----------------
// Compile SASS
// -----------------
function compileSASS() {
    return gulp
        .src(path.styles.src + '**/*.scss')
        .pipe(gulpIf(path.env === 'development', sourcemaps.init()))
        .pipe(sassGlob())
        .pipe(
            sass({
                includePaths: [
                    path.node_modules + path.breakpoint_sass,
                    path.node_modules + path.fontAwesome,
                    './',
                ],
                outputStyle: 'expanded',
            }).on('error', function (err) {
                log.error(
                    chalk.black.bgRed(' SASS ERROR', chalk.white.bgBlack(' ' + err.message.split('  ')[2] + ' '))
                );
                log.error(
                    chalk.black.bgRed(' FILE:', chalk.white.bgBlack(' ' + err.message.split('\n')[0] + ' '))
                );
                log.error(chalk.black.bgRed(' LINE:', chalk.white.bgBlack(' ' + err.line + ' ')));
                log.error(chalk.black.bgRed(' COLUMN:', chalk.white.bgBlack(' ' + err.column + ' ')));
                log.error(chalk.black.bgRed(' ERROR:', chalk.white.bgBlack(' ' + err.formatted.split('\n')[0] + ' ')));
                return this.emit('end');
            })
        )
        .pipe(
            autoprefixer({
                overrideBrowserslist: ['last 2 versions'],
            })
        )
        .pipe(gulpIf(path.env === 'production', cleanCss()))
        .pipe(gulpIf(path.env === 'development', sourcemaps.write()))
        .pipe(gulp.dest(path.styles.assets))
        .pipe(browserSync.stream());
}

// -----------------
// Copy Scripts
// -----------------
function copyScripts() {
    return gulp
        .src(path.scripts.src + '*.js')
        .pipe(gulpIf(path.env === 'production', uglify()))
        .pipe(
            rename({
                suffix: '.min',
            })
        )
        .pipe(gulp.dest(path.scripts.assets));
}

// ---------------------------------------------------
// Copy images from src to assets if necessary.
// ---------------------------------------------------
function copyImages() {
    if (!fs.existsSync(path.images.src)) return Promise.resolve();
    return gulp.src(path.images.src + '**/*').pipe(gulp.dest(path.images.assets));
}

// ---------------------------------------------------
// Copy fonts from src to assets if necessary.
// ---------------------------------------------------
function copyFonts() {
    if (!fs.existsSync(path.fonts.src)) return Promise.resolve();
    return gulp.src(path.fonts.src + '**/*').pipe(gulp.dest(path.fonts.assets));
}

// ----------------------
// Function to run watch.
// ----------------------
function runWatch() {
    gulp.watch(path.styles.src + '**/*.scss', compileSASS);
    gulp.watch(path.scripts.src + '*.js', copyScripts);
}

function cleanAssets() {
    return gulp.src('./assets/', { read: false, allowEmpty: true }).pipe(clean());
}

// -----------------
// Environment
// -----------------
function environment(env) {
    console.log('Running tasks in ' + env + ' mode.');
    path.env = env;
}

// -----------------
// Dev / Prod tasks
// -----------------
gulp.task('dev', (done) => {
    environment('development');
    done();
});

gulp.task('prod', (done) => {
    environment('production');
    done();
});

// -------------------------------------
// Build development css & scripts task.
// -------------------------------------
gulp.task(
    'development',
    gulp.series('dev', cleanAssets, compileSASS, copyScripts, copyImages, copyFonts)
);

gulp.task('default', gulp.series('dev', gulp.parallel(runWatch, browserSyncInit)));

gulp.task(
    'production',
    gulp.series('prod', cleanAssets, compileSASS, gulp.parallel(copyScripts, copyImages, copyFonts))
);
