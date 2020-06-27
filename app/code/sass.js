// Requirements
const sass = require('node-sass');
const fs = require('fs');
const mkdirp = require('mkdirp')
const path = require("path");

const compileSass = (options = {}) => {
  // set default options
  options = Object.assign({
    style: 'expanded'
  }, options);

  // render the result
  const result = sass.renderSync({
    file: options.src,
    outputStyle: options.style,
    outFile: options.dest,
    sourceMap: true
  });

  // write the result to file
  mkdirp(path.dirname(options.dest)).then(made => {
    fs.writeFile(options.dest, result.css, (err) => {
        if(err){
          cb(err)
        }
      });
  })

  console.log(`File ${options.dest} has wirtten on disk.`);
};

// Expanded
compileSass({
  src : 'src/scss/main.scss',
  dest: 'src/assets/main.css'
});

// Minified
compileSass({
  src : 'src/scss/main.scss',
  dest : 'src/assets/main.min.css',
  style: 'compressed'
});
