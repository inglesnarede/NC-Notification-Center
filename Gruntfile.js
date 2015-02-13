module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        sass: {
            dist: {
                files: {
                    'assets/css/max/nc-notifications.css' : 'assets/css/sass/notifications.scss'
                }
            }
        },

        cssmin: {
            add_banner: {
                options: { banner: '/* Custom Styling for the Notification Center */' },
            
                files: { 'assets/css/nc-notifications.css': ['assets/css/max/notifications.css'] }
            }
        },

        uglify: {
            main_target: {
                options: {
                    mangle: true,
                    compress: true,
                    compress: {
                        drop_console: true
                    },
                    sourceMap: false
                },

                files: [{
                    expand: true,
                    cwd: 'assets/js/max',
                    src: 'assets/js/**/*.js',
                    dest: 'assets/js/min'
                }]
            },

            non_logged_in_target: {
                files: [{ 
                    'assets/js/nc-note.js': ['assets/js/max/jquery.cookie.js', 'assets/js/max/notifications.js'] 
                }]
            },

            logged_in_target: {
                files: [{ 
                    'assets/js/nc-notifications.js': ['assets/js/max/notifications.js'] 
                }]
            }
        } 
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.registerTask('nc-note',['sass', 'cssmin', 'uglify']);
}
