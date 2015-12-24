'use strict';

var gulp         = require('gulp'),
    concat       = require('gulp-concat'),
    uglify       = require('gulp-uglify'),
    sass         = require('gulp-sass'),
    minifyCss    = require('gulp-minify-css'),
    sourcemaps   = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer');;

var paths = {
    bower:  './bower_components',
    assets: './assets'
};

gulp.task('styles', function() {
    return gulp.src([
        paths.bower + '/bootstrap/dist/css/bootstrap.css',
        paths.bower + '/bootstrap-material-design/sass/bootstrap-material-design.scss',
        paths.bower + '/bootstrap-material-design/sass/ripples.scss',
        paths.assets + '/styles/app.scss'
    ])
        .pipe(sass({
            includePaths: paths.bower + '/bootstrap-sass/assets/stylesheets'
        }))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(concat('app.css'))
        .pipe(sourcemaps.init())
        .pipe(minifyCss())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('./public/css'));
});

gulp.task('scripts', function() {
    return gulp.src([
        paths.bower   + '/jquery/dist/jquery.js',
        paths.bower   + '/bootstrap-sass/assets/javascripts/bootstrap-sprockets.js',
        paths.bower   + '/bootstrap-sass/assets/javascripts/bootstrap.js',
        paths.bower   + '/bootstrap-material-design/scripts/material.js',
        paths.bower   + '/bootstrap-material-design/scripts/ripples.js',
        paths.bower   + '/matchHeight/jquery.matchHeight.js',
        paths.bower   + '/pwstrength-bootstrap/dist/pwstrength-bootstrap-1.2.9.js',
        paths.assets  + '/scripts/base/*.js',
        paths.assets  + '/scripts/validator/*.js',
        paths.assets  + '/scripts/init/*.js'
    ])
        .pipe(concat('app.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'));
});

gulp.task('watch', function() {
    gulp.watch(paths.assets + '/styles/**/*.scss', ['styles']);
    gulp.watch(paths.assets + '/scripts/**/*.js', ['scripts']);
});
gulp.task('default', ['styles', 'scripts']);