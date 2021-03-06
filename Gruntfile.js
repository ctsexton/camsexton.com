module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    sass: {
      dist: {
        options:{
          style:'compressed'
        },
        files: {
          'themes/artistsite/assets/css/styles_25.06.18b.css' : 'themes/artistsite/assets/css/src/input.scss'
        }
      }
    },
    autoprefixer:{
      dist:{
        files:{
          'themes/artistsite/assets/css/styles_25.06.18b.css':'themes/artistsite/assets/css/styles_25.06.18b.css'
        }
      }
    },
    watch: {
      css: {
        files: 'themes/artistsite/assets/css/src/*.scss',
        tasks: ['sass', 'autoprefixer']
      }
    }
  });
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-autoprefixer');
  grunt.registerTask('default',['watch']);
}
