'use strict';

/* ==========================================================================
 Gulpfile

 Tasks:
 - gulp (builds for dev + watch)
 - gulp build (builds for prod)
 - gulp watch

 - gulp migrate
 - gulp cc (Clear Cache)
 - gulp fixperms
 - gulp maintenance
 - gulp apachectl
 ========================================================================== */


/* Setup Gulp
 ========================================================================== */
// Require
var gulp = require('gulp'),
    del = require('del'),
    fs = require('fs'),
    path = require('path'),
    _ = require('lodash'),
    rebase = require("rebase/tasks/gulp-rebase"),
    notifier = require('node-notifier'),
    runSequence = require('run-sequence'),
    plugins = require('gulp-load-plugins')();

var autoprefixer = require('autoprefixer');
var mqpacker = require('css-mqpacker');
var csswring = require('csswring');
var webpack = require('webpack-stream');


// Gulp Config
var showErrorNotifications = true,
    allowChmod = true;


// Project Config
var bowerComponentsPath = JSON.parse(fs.readFileSync(path.resolve(__dirname, '.bowerrc'))).directory;

var config = fs.readFileSync(path.resolve(__dirname, '.groundcontrolrc'), 'UTF-8'),
    vars = _.merge({
        'bowerComponentsPath': bowerComponentsPath
    }, JSON.parse(config).vars);

var resourcesPath = vars.resourcesPath;
var distPath = vars.distPath;

_.forEach(vars, function(value, key) {
    config = config.replace(new RegExp('\<\=\s*' + key + '\s*\>', 'ig'), value);
});

config = JSON.parse(config);




/* Errorhandling
 ========================================================================== */
var errorLogger, headerLines;

errorLogger = function(headerMessage,errorMessage){
    var header = headerLines(headerMessage);
    header += '\n             '+ headerMessage +'\n           ';
    header += headerLines(headerMessage);
    header += '\r\n \r\n';
    plugins.util.log(plugins.util.colors.red(header) + '             ' + errorMessage + '\r\n')

    if(showErrorNotifications){
        notifier.notify({
            'title': headerMessage,
            'message': errorMessage,
            'contentImage':  __dirname + "/gulp_error.png"
        });
    }
}

headerLines = function(message){
    var lines = '';
    for(var i = 0; i< (message.length + 4); i++){
        lines += '-';
    }
    return lines;
}




/* Add Async tag to script
 ========================================================================== */
var addAsyncTag = function (filepath, file, i, length) {
    if(config.js.addAsync === 'true') {
        return '<script src="' + filepath + '" async></script>';
    } else {
        return '<script src="' + filepath + '"></script>';
    }
}




/* Styles
 ========================================================================== */
gulp.task('styles', function() {
    errorLogger('browserSupport',config.browserSupport);
    var preProcessor = [
        autoprefixer({browsers:config.browserSupport})
    ];
    var postProcessors = [
        mqpacker,
        csswring
    ];
    return gulp.src([config.scss, '!' + config.scssFolder + 'admin-style.scss'])
        // Sass
        .pipe(plugins.sourcemaps.init())
        .pipe(plugins.plumber({errorHandler: plugins.notify.onError("Styles: <%= error.message %>")}))
        .pipe(plugins.sass()).on('error', function (err){
            errorLogger('rubySass Error', err.message);
        })


        .pipe(plugins.postcss(preProcessor)).on('error', function (err){
            errorLogger('preProcessor Error', err.message);
        })
        .pipe(gulp.dest(config.dist.css))
        // Minify output
        .pipe(plugins.postcss(postProcessors)) .on('error', function (err){
            errorLogger('postProcessors Error', err.message);
        })
        // Rename the file to respect naming covention.
        .pipe(plugins.rename(function(path){
            path.basename += '.min';
        }))
        // Write to output
        .pipe(gulp.dest(config.dist.css))
        .pipe(plugins.sourcemaps.write(config.dist.css))
        // Show total size of css
        .pipe(plugins.size({
            title: 'css'
        }));
});

/* Javascript
 ========================================================================== */
// Jshint
gulp.task('jshint',['webpack'], function() {
    return gulp.src([config.js.app, '!' + resourcesPath + '/ui/js/vendors/**/*.js'])
        // Jshint
        .pipe(plugins.jshint())
        .pipe(plugins.jshint.reporter(require('jshint-stylish')));
});


// Production
gulp.task('scripts-prod', ['jshint'], function() {
    return gulp.src(config.js.footer)
        // Uglify
        .pipe(plugins.uglify({
            mangle: {
                except: ['jQuery']
            }
        }))
        .pipe(plugins.plumber({errorHandler: plugins.notify.onError("JS: <%= error.message %>")}))
        .on('error', function (err){
            errorLogger('Javascript Error', err.message);
        })

        // Concat
        .pipe(plugins.concat('footer.min.js'))

        // Revision
        .pipe(plugins.rev())

        // Set destination
        .pipe(gulp.dest(config.dist.js))

        // Show total size of js
        .pipe(plugins.size({
            title: 'js'
        }));
});

gulp.task('inject-prod-scripts', ['scripts-prod'], function() {
    var files = gulp.src(config.dist.js + '/**/*.js');
    return gulp.src('src/' + config.project.mainBundlePath + '/Resources/views/' + config.project.mainJsInclude.folder + '/' + config.project.mainJsInclude.fileName)
        // Inject
        .pipe(plugins.inject(files, {
            transform: addAsyncTag,
            ignorePath: '/web'
        }))

        // Rebase
        .pipe(rebase({
            script: {
                '(\/[^"]*\/)': '/frontend/js/'
            }
        }))

        // Write
        .pipe(gulp.dest('app/Resources/views/' + config.project.mainJsInclude.folder + '/'));
});


// Development
gulp.task('scripts-dev', ['jshint'], function() {
    return gulp.src(config.js.footer)
        // Flatten
        .pipe(plugins.flatten())

        // Write
        .pipe(gulp.dest(config.dist.js));
});

gulp.task('inject-dev-scripts', ['scripts-dev'], function() {
    var files = gulp.src(config.js.footer, {read: false});

    return gulp.src('src/' + config.project.mainBundlePath + '/Resources/views/' + config.project.mainJsInclude.folder + '/' + config.project.mainJsInclude.fileName)
        
        // Inject
        .pipe(plugins.inject(files))

        // Rebase
        .pipe(rebase({
            script: {
                '(\/[^"]*\/)': '/frontend/js/'
            }
        }))

        // Write
        .pipe(gulp.dest('app/Resources/views/' + config.project.mainJsInclude.folder + '/'));
});




/* Images
 ========================================================================== */
gulp.task('images', function() {
    return gulp.src(config.img)
        // Only optimize changed images
        .pipe(plugins.changed(config.dist.img))

        // Imagemin
        .pipe(plugins.imagemin({
            optimizationLevel: 3,
            progressive: true,
            svgoPlugins: [{
                removeViewBox: false
            }]
        }))

        // Set destination
        .pipe(gulp.dest(config.dist.img))

        // Show total size of images
        .pipe(plugins.size({
            title: 'images'
        }));
});




/* Fonts
 ========================================================================== */
gulp.task('fonts', function() {
    return gulp.src(config.fonts)
        // Set destination
        .pipe(gulp.dest(config.dist.fonts))

        // Show total size of fonts
        .pipe(plugins.size({
            title: 'fonts'
        }));
});

/* Clean/clear
 ========================================================================== */
gulp.task('clean', function(done) {
    del([
        distPath + '**',
        'app/Resources/' + config.project.mainBundleName + '/views/' + config.project.mainJsInclude.folder + '/' + config.project.mainJsInclude.fileName,
    ], done);
});


// Run webpack
gulp.task('webpack', function(){
    return gulp.src('app/Resources/vue/main.js')
        .pipe(webpack( require('./webpack.config.js') ))
        .pipe(gulp.dest('web/frontend/js/'));
});


/* Default tasks
 ========================================================================== */
// Watch
gulp.task('watch', function() {
    // Livereload
    plugins.livereload.listen();
    gulp.watch(config.liveReloadFiles).on('change', function(file) {
        plugins.livereload.changed(file.path);
    });

    // Styles
    gulp.watch(config.scss, ['styles']);

    // Scripts
    gulp.watch(config.js.app, ['inject-dev-scripts']);

    // Images
    gulp.watch(config.img, ['images']);

    gulp.watch('app/Resources/vue/**/*.*',['inject-dev-scripts']);
});


// Build
gulp.task('build', function(done) {
    runSequence(
        'clean',
        ['clear-symfony-cache', 'styles', 'inject-prod-scripts', 'images', 'fonts'],
        done);
});


// Build Deploy
gulp.task('build-deploy', function(done) {
    allowChmod = false;

    gulp.start('build');
});


// Default
gulp.task('default', function(done) {
    runSequence(
        'clean',
        ['clear-symfony-cache', 'styles', 'inject-dev-scripts', 'images', 'fonts'],
        ['watch'],
        done);
});

/* Other tasks
 ========================================================================== */
// Clear symfony cache
gulp.task('clear-symfony-cache', plugins.shell.task([
    'rm -rf app/cache/*'
]));


// Migrate
gulp.task('migrate', plugins.shell.task([
    'app/console doctrine:migrations:migrate --no-interaction'
]));


// Clear Cache
gulp.task('cc', plugins.shell.task([
    'php app/console cache:clear',
    'php app/console assetic:dump',
    'php app/console assets:install web --symlink'
]));

// Install for Bower & npm
gulp.task('install_deps', plugins.shell.task([
    'npm install',
    'bower install',
    'bundle install'
]));