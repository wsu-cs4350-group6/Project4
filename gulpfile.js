var gulp = require('gulp');
var uglify = require('gulp-uglify');
var minifyCss = require('gulp-minify-css');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var apidoc = require('gulp-apidoc');
var watch = require('gulp-watch');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');

var bases = {
	bootstrap: 'bower_components/bootstrap/dist/',
	dist: 'public', 
	stylesheets: 'public/stylesheets/',
	javascripts: 'public/javascripts/',
    images: 'public/images',
	src: 'src',
	endpoints: 'src/Common/Endpoints',
	apidocuments: 'public/apidocs'
};

var paths = {
    scripts: 'src/Javascript/*.js',
    bootstrap: bases.bootstrap + 'css/bootstrap.min.css',
    styles: 'src/Stylesheets/*.css',
    images: 'src/Images/**.*'
};

gulp.task('copy', function() {

	gulp.src([paths.bootstrap, paths.styles])
    .pipe(minifyCss())
    .pipe(concat('style.min.css'))
    .pipe(gulp.dest(bases.stylesheets));

	gulp.src(paths.scripts)
	.pipe(uglify())
	.pipe(gulp.dest(bases.javascripts));

    gulp.src(paths.images)
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest(bases.images));

});

gulp.task('apidocs', function() {

	apidoc.exec({
		src: bases.endpoints,
		dest: bases.apidocuments
	});

});

gulp.task('watch', function() {

    gulp.watch(paths.scripts, ['copy']);
    gulp.watch(paths.styles, ['copy'])

});

// Define the default task as a sequence of the above tasks
gulp.task('default', ['copy']);