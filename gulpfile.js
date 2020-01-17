var gulp = require('gulp');
var rename = require('gulp-rename');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');

var styleSRC = '_src/sass/bootstrap.scss';
var styleDIST = './bootstrap/4/css/';
var styleWatch = '_src/sass/**/*.scss';

var jsSRC = '_src/js/script.js';
var jsDIST = './bootstrap/4/js/';
var jsWatch = '_src/js/**/*.js';

gulp.task('style', function () {
    return gulp.src(styleSRC)
        .pipe(sourcemaps.init())
        .pipe(sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        }))
        .on('error', console.error.bind(console))
        .pipe(rename({ suffix: '.min' }))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(styleDIST));
});

gulp.task('js', function () {
    return gulp.src(jsSRC)
        .pipe(gulp.dest(jsDIST));
});

gulp.task('default', gulp.series(['style', 'js']));

gulp.task('watch', gulp.parallel('default', function () {
    gulp.watch(styleWatch, gulp.series('style'));
    gulp.watch(jsWatch, gulp.series('js'));
}));