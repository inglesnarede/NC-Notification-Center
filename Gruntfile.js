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
        },

        checktextdomain: {
            options:{
                text_domain: 'nc-notification-center',
                correct_domain: true,
                keywords: [
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d', 
                    'esc_attr_e:1,2d', 
                    'esc_attr_x:1,2c,3d', 
                    '_ex:1,2c,3d',
                    '_n:1,2,4d', 
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d'
                ],
            },

            files: {
               src: [ 'core/**/*.php', 'nc-notification-center.php' ],
               expand: true,
            },
        },

        pot: {
            options:{
                text_domain: 'nc-notification-center',
                dest: 'languages/',
                keywords: [
                    '__:1',
                    '_e:1',
                    '_x:1,2c',
                    'esc_html__:1',
                    'esc_html_e:1',
                    'esc_html_x:1,2c',
                    'esc_attr__:1', 
                    'esc_attr_e:1', 
                    'esc_attr_x:1,2c', 
                    '_ex:1,2c',
                    '_n:1,2', 
                    '_nx:1,2,4c',
                    '_n_noop:1,2',
                    '_nx_noop:1,2,3c'
                ],
            },
            
            files:{
                src: [ 'core/**/*.php', 'nc-notification-center.php' ],
                expand: true,
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-uglify');

    grunt.loadNpmTasks('grunt-pot');
    grunt.loadNpmTasks('grunt-checktextdomain');

    grunt.registerTask('nc-note',['sass', 'cssmin', 'uglify']);
}
