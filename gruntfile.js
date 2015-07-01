module.exports = function(grunt) {

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
            concat_css: {
                src: [
                    'public/style_assets/style.css',
                    'public/assets/css/base.css',
                ],
                dest: 'public/build/production.css'
            },
            concast_js: {
                src: [
                    'public/assets/js/*.js'
                ],
                dest: 'public/build/production.js'
            }
        },

        uglify: {
            build: {
                src: 'public/build/production.js',
                dest: 'public/build/production.min.js'
            }
        },

        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'public/build',
                    src: ['*.css', '!*.min.css'],
                    dest: 'public/build',
                    ext: '.min.css'
                }]
            }
        },

        imagemin: {
            dynamic: {
                optimizationLevel: 7,
                files: [{
                    expand: true,
                    cwd: 'public/recipe_images',
                    src: ['*.{png,jpg,gif,jpeg}'],
                    dest: 'public/recipe_images/build'
                }]
            }
        }
    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-imagemin');

    // 4. Where we tell Grunt what to do when we type "grunt" into the terminal.
    grunt.registerTask('default', ['concat', 'uglify', 'cssmin', 'imagemin']);

};