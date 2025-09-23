import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class',
    theme: {
        extend: {
          textShadow: {
            custom: '0px 1px 4px #23430C',
          },
          webkitTextStroke: {
            1: '1px #F8F8F8',
          },
          colors: {
            darkmode: {
              600: '#232d45',
              800:'#1b253b',
              500:'#28334e',
              400:'#94a3b8',
              300:'#cbd5e1',
              444:'#38BDF8',
              555:'#99a3b3',
            },

                aside: '#1F4583',
                primary: '#2a60b8',
                thirdy: '#FF7B00',
                secondary: '#00C2FF',
                mainText: '#0F172A',
                secondText: '#64748B',
                lightgray: '#EFEFEF',
                hoverBlue: '#A5C8D8',

          },
          backgroundImage: {
            'gradient-dark': 'linear-gradient(195deg, #42424a, #191919)',
            'gradient-blue': 'linear-gradient(195deg, #1F4583, #0D6EFD, #38BDF8)',
          },
        },
      },
      plugins: [
        require('flowbite/plugin'),
        function ({ addUtilities }) {
          const newUtilities = {
            '.webkit-text-stroke-1': {
              '-webkit-text-stroke': '1px #F8F8F8',
            },
            '.text-shadow-black': {
              'text-shadow': '0px 1px 4px #23430C',
            },
            '.text-shadow-gold': {
              'text-shadow': '0px 1px 4px #f5a809',
            },
          };
          addUtilities(newUtilities);
        },
      ],
};
