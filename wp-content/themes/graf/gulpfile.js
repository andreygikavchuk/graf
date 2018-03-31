// Include gulp
var gulp = require('gulp');
var sass = require('gulp-sass'),
    assets  = require('postcss-assets'),
    postcss = require('gulp-postcss'),
    watch = require('gulp-watch'),
    autoprefixer = require('gulp-autoprefixer');
    browserSync  = require('browser-sync');

var pngquant = require('imagemin-pngquant');
var cache = require('gulp-cache');
// var concatCss = require('gulp-concat-css');
var imagemin = require('gulp-imagemin');


gulp.task('browser-sync', function() {
  browserSync.init(['assets/css/*.css', 'assets/js/**/*.js', 'index.html'], {
    server: {
      baseDir: './'
    }
  });
});

// Compile Our Sass
gulp.task('sass', function() {

  return gulp.src('assets/sass/**/*.scss')
      .pipe(sass({ errLogToConsole: true}))
      .pipe(autoprefixer({
        browsers: ['last 10 versions'],
        cascade: false
      }))
    //   .pipe(concatCss('style.min.css'))
      .pipe(gulp.dest('assets/css'));

});




gulp.task('imgmin', function() {
    return gulp.src('assets/img/*')
        .pipe(cache(imagemin({
            progressive: true,
            svgoPlugins: [{
                removeViewBox: false
            }],
            use: [pngquant()]
        })))
        .pipe(gulp.dest('assets/img/'));
});


gulp.task('watch', function() {
  gulp.watch('assets/sass/**/*.scss', ['sass']);
});

// Default Task
gulp.task('default', ['sass', 'browser-sync', 'watch']); 
