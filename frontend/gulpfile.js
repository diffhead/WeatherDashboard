var gulp = require("gulp");
var browserify = require("browserify");
var source = require("vinyl-source-stream");
var tsify = require("tsify");
var sass = require('gulp-sass')(require('sass'));
var concat = require('gulp-concat');

var paths = {
    pages: ["workspace/ts/*.html"],
};

gulp.task("copy-html", function () {
    return gulp.src(paths.pages).pipe(gulp.dest("bundle"));
});

gulp.task(
    "default",
    gulp.series(
        gulp.parallel("copy-html"), 
        gulp.parallel(
            function () {
                return browserify({
                    basedir: ".",
                    debug: true,
                    entries: ["workspace/ts/index.ts"],
                    cache: {},
                    packageCache: {},
                })
                .plugin(tsify)
                .bundle()
                .pipe(source("index.js"))
                .pipe(gulp.dest("bundle"));
            },
            function() {
                return gulp.src('workspace/scss/index.scss')
                    .pipe(concat("index.css"))
                    .pipe(sass().on('error', sass.logError))
                    .pipe(gulp.dest('bundle')
                );
            }
        )
    )
);
