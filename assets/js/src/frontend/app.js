/* jshint esversion: 6 */
import { initBlog } from './blog.js';
import { initNavigation, repositionDropdowns } from './navigation.js';
import { HFG } from './hgf.js';

function run() {
	window.HFG = new HFG();
	initBlog();
	initNavigation();
}

function onResizeDebouncedRun() {
	repositionDropdowns();
}

/**
 * Run JS on load.
 */
window.addEventListener('load', () => {
	run();
});

/**
 * Do resize events debounced.
 */
let khutarResizeTimeout;
window.addEventListener('resize', () => {
	clearTimeout(khutarResizeTimeout);
	khutarResizeTimeout = setTimeout(onResizeDebouncedRun, 500);
});
