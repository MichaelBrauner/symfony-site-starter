let tailwindcss = require('tailwindcss');

module.exports = {
    plugins: [
        require('postcss-import'),
        require('postcss-nested-ancestors'),
        require('postcss-nested'),
        tailwindcss('tailwind.config.js'),
        require('autoprefixer'),
    ]
}