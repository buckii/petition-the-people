module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    jshint: {
      options: {
        force: true
      },
      all: ['app/assets/js/*.js']
    },

    concat: {
      dist: {
        src: ['app/assets/js/application.js'],
        dest: 'public/js/application.js'
      }
    },

    uglify: {
      min: {
        files: {
          'public/js/application.js': ['public/js/application.js']
        }
      }
    },

    compass: {
      dist: {
        options: {
          config: 'app/config/config.rb'
        }
      }
    },

    watch: {
      options: {
        livereload: true
      },
      docs : {
        files: ['*.md'],
        tasks: ['markdown']
      },
      scripts: {
        files: ['app/assets/js/*'],
        tasks: ['jshint', 'concat', 'uglify']
      },
      styles: {
        files: ['app/assets/scss/*.scss'],
        tasks: ['compass']
      },
    },

  });

  // Load tasks
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'compass']);

};