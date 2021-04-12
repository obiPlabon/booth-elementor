const { src, watch, dest, series } = require('gulp');
const csso                         = require('gulp-csso');
const rename                       = require('gulp-rename');
const csscomb                      = require('gulp-csscomb');
const autoPrefixer                 = require('gulp-autoprefixer');
const plumberNotifier              = require('gulp-plumber-notifier');
const concat                       = require('gulp-concat');
const cssbeautify                  = require('gulp-cssbeautify');

const AUTOPREFIXER_BROWSERS = [
    'last 2 version',
    '> 1%',
    'ie >= 9',
    'ie_mob >= 10',
    'ff >= 30',
    'chrome >= 34',
    'safari >= 7',
    'opera >= 23',
    'ios >= 7',
    'android >= 4',
    'bb >= 10'
];

const frontendSassFiles = 'assets/css/widgets/*.css';

function makeFrontendCSS() {
    return src(frontendSassFiles)
        .pipe(plumberNotifier())
        .pipe(autoPrefixer(AUTOPREFIXER_BROWSERS))
        .pipe(cssbeautify())
		.pipe(concat('booth-elementor.css'))
		.pipe(dest('assets/css'))

        .pipe(csso())
        .pipe(rename({suffix: '.min'}))
		.pipe(dest('assets/css'));
}

function startWatching() {
    watch(frontendSassFiles, makeFrontendCSS);
}

exports.default = series(
	makeFrontendCSS,
	startWatching
);
