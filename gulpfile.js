'use strict';

var gulp       = require('gulp'),
    concat     = require('gulp-concat'),
    uglify     = require('gulp-uglify'),
    sass       = require('gulp-sass'),
    minifyCss  = require('gulp-minify-css'),
    sourcemaps = require('gulp-sourcemaps');

var paths = {
    bower:  './bower_components',
    assets: './assets'
};

gulp.task('styles', function() {
    return gulp.src([
        paths.assets + '/styles/bootstrap/*.css',
        paths.assets + '/styles/app.scss'
    ])
        .pipe(sass())
        .pipe(concat('app.css'))
        .pipe(sourcemaps.init())
        .pipe(minifyCss())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./public/css'));
});

gulp.task('scripts', function() {
    return gulp.src([
        paths.assets  + '/scripts/**/*.js'
    ])
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'));
});

gulp.task('watch', function() {
    gulp.watch(paths.assets + '/styles/**/*.less', ['styles']);
    gulp.watch(paths.assets + '/scripts/**/*.js', ['scripts']);
});
gulp.task('default', ['styles', 'scripts']);