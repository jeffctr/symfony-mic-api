/**
 * Required External Modules
 */
const express = require('express');
const path = require('path');


// Make a request for a user with a given ID
let products = [];


/**
 * App Variables
 */
const app = express();
const HOST = '0.0.0.0';
const PORT = process.env.PORT || 8080;

/**
 *  App Configuration
 */
app.set('views', path.join(__dirname, 'src/views'));
app.set('view engine', 'pug');
app.use(express.static(path.join(__dirname, 'src/assets')));

/**
 * Routes Definitions
 */
app.get('/', (req, res) => {
  res.render('index', { title: 'Products', products });
});

/**
 * Server Activation
 */
app.listen(PORT, HOST);
console.log(`Running on http://${HOST}:${PORT}`);
