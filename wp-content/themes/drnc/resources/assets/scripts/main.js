// Web Font Loader
var WebFont = require('webfontloader');

WebFont.load({
 google: {
   families: ['Noto+Sans:400,400i,700,700i', 'Playfair+Display:700', 'Material+Icons'],
 },
});

// import external dependencies
import 'jquery';

// Import everything from autoload
import "./autoload/**/*"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import templateTools from './routes/tools';
import form from './routes/form';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  templateTools,
  form,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
