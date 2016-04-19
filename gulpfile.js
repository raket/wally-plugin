'use strict';

var gulp       = require('gulp'),
	bowerFiles = require('main-bower-files'),
	path       = require('path'),
	open       = require('open'),
	fs         = require('fs'),
	chalk      = require('chalk'),
	args       = require('yargs').argv,
	map        = require('map-stream'),
	runSequence = require('run-sequence'),
    sourcemaps = require('gulp-sourcemaps'),
    livereload = require('gulp-livereload'),
    gulpPlugins = require('gulp-load-plugins')(),
	autoprefixer = require('gulp-autoprefixer'),
	wiredep = require('wiredep').stream;

// chalk config
var errorLog  = chalk.red.bold,
	hintLog   = chalk.blue,
	changeLog = chalk.red;

var themeName = 'wally-plugin';
var themePath = 'static/';

var	SETTINGS = {
    app: {
        name: themeName
    },
	src: {
		app:        themePath,
		css:        themePath + 'sass/',
	},
	build: {
		app:        themePath,
		css:        themePath + 'css/',
	},
	scss: 'scss/'
};

var bowerConfig = {
    debugging: true,
    paths: {
		bowerDirectory: SETTINGS.src.bower,
		bowerrc: '.bowerrc',
		bowerJson: 'bower.json'
	}
};


// Flag for generating production code.
var isProduction = args.type === 'production';

gulp.task('tasks', gulpPlugins.taskListing);

/*============================================================
=                          Concat                           =
============================================================*/

gulp.task('concat', ['concat:css']);



gulp.task('convert:scss', function () {
	console.log('-------------------------------------------------- COVERT - scss');

	// Callback to show sass error
	var showError = function (err) {
		console.log(errorLog('\n SASS file has error clear it to see changes, see below log ------------->>> \n'));
        console.log(err.toString());
        this.emit('end');
	};

    return gulp.src(SETTINGS.src.css + 'admin.scss')
        .pipe(sourcemaps.init())
        .pipe(gulpPlugins.sass({
            includePaths: [
                SETTINGS.src.css,
                SETTINGS.src.bower
            ]
        })).on('error', showError)
		.pipe(autoprefixer({
			browsers: ['last 3 versions'],
			cascade: false,
			remove: true
		}))
        .pipe(sourcemaps.write())
       .pipe(gulp.dest(SETTINGS.build.css))
       .pipe(livereload());
});

gulp.task('concat:css', ['convert:scss'], function () {

	console.log('-------------------------------------------------- CONCAT :css ');
	gulp.src([
            SETTINGS.build.css + 'admin.css',
            //SETTINGS.src.css + '*.css'
        ])
	    .pipe(gulpPlugins.concat('admin.css'))
	    .pipe(gulpPlugins.if(isProduction, gulpPlugins.minifyCss({keepSpecialComments: '*'})))
	    .pipe(gulp.dest(SETTINGS.build.css))
        .pipe(livereload());
});

gulp.task('reload', function () {
    console.log('-------------------------------------------------- RELOAD');
    livereload();
});

gulp.task('copy', function () {
    console.log('-------------------------------------------------- COPY :icons');
    gulp.src([SETTINGS.src.bower + '/fontawesome/fonts/**.*'])
        .pipe(gulp.dest(SETTINGS.build.bower + '/fontawesome/fonts'));
});

/*=========================================================================================================
=												Watch

	Incase the watch fails due to limited number of watches available on your sysmtem, the execute this
	command on terminal

	$ echo fs.inotify.max_user_watches=524288 | sudo tee -a /etc/sysctl.conf && sudo sysctl -p
=========================================================================================================*/
	
gulp.task('watch', function () {
	
	console.log('watching all the files.....');
    livereload.listen();

	var watchedFiles = [];

	watchedFiles.push(gulp.watch([SETTINGS.src.css + '*.css',  SETTINGS.src.css + '**/*.css'],  ['concat:css']));
	
	watchedFiles.push(gulp.watch([SETTINGS.src.css + '*.scss', SETTINGS.src.css + '**/*.scss'], ['concat:css']));

	// Just to add log messages on Terminal, in case any file is changed
	var onChange = function (event) {
		if (event.type === 'deleted') {
			setTimeout(function () {
				runSequence( 'concat', 'watch');
			}, 500);
		}
		console.log(changeLog('-------------------------------------------------->>>> File ' + event.path + ' was ------->>>> ' + event.type));
	};

	watchedFiles.forEach(function (watchedFile) {
		watchedFile.on('change', onChange);
	});
    //
    //var server = livereload();
    //gulp.watch([SETTINGS.src.templates + '*.php', SETTINGS.src.templates + '**/*.php']).on('change', function(file) {
    //    server.changed(file.path);
    //    util.log(util.colors.yellow('PHP file changed' + ' (' + file.path + ')'));
    //});
	
});

/*============================================================
 =                          Wiredep                          =
 ============================================================*/

gulp.task('wiredep', function () {
	gulp.src(SETTINGS.src.css + 'admin.scss')
		.pipe(wiredep())
		.pipe(gulp.dest(SETTINGS.src.css));
});

/*============================================================
=                             Start                          =
============================================================*/

gulp.task('build', function () {
	console.log(hintLog('-------------------------------------------------- BUILD - Development Mode'));
	runSequence('concat', 'copy', 'watch');
});

gulp.task('build:prod', function () {
	console.log(hintLog('-------------------------------------------------- BUILD - Production Mode'));
	isProduction = true;
	runSequence('concat', 'watch');
});

gulp.task('default', ['build']);

// Just in case you are too lazy to type: $ gulp --type production
gulp.task('prod', ['build:prod']);