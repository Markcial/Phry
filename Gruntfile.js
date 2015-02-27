module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    submodule: {
      options: {},
      'deps/bootstrap' : {
          options: {
              base: 'deps/bootstrap',
              tasks: ['dist']
          }
      },
      'deps/jquery' : {
          options: {
              base: 'deps/jquery'
          }
      }
    },
    copy: {
      main: {
        files: [
          // includes files within path and its sub-directories
          {expand: true, cwd: 'deps/bootstrap/dist', src: ['**'], dest: 'web/assets/bootstrap'},
          {expand: true, cwd: 'deps/jquery/dist', src: ['**'], dest: 'web/assets/jquery'}
        ]
      }
    }
  });

  grunt.loadNpmTasks('grunt-submodule');

  grunt.loadNpmTasks('grunt-contrib-copy');

  grunt.registerTask('booh', "Just testing", function () {
    console.log('boooh!');
  });

  grunt.registerTask('default', ['booh', 'submodule', 'copy']);
};
