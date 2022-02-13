var gulp = require("gulp");
var browserify = require("browserify");
var source = require("vinyl-source-stream");
var tsify = require("tsify");
var scss = require('gulp-scss');

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
        gulp.parallel(function () {
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
        }),
        gulp.parallel(function() {
            return gulp.src(
                    "workspace/scss/**/*.scss"
                ).pipe(scss(
                    {"bundleExec": true}
                )
            )
            .pipe(gulp.dest("bundle"));
        })
    )
);
