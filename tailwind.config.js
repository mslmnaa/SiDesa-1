/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#f0f7f2',
          100: '#dceee0',
          200: '#bdddc5',
          300: '#90c59e',
          400: '#5fa672',
          500: '#3a7d44',
          600: '#2e653a',
          700: '#265230',
          800: '#214229',
          900: '#1c3724',
        },
        secondary: {
          50: '#f9f5f2',
          100: '#f0e7de',
          200: '#e1cfbd',
          300: '#ceb094',
          400: '#ba8e6a',
          500: '#8b5e3c',
          600: '#7d5137',
          700: '#684330',
          800: '#55372b',
          900: '#472f26',
        },
        accent: {
          50: '#fefcf3',
          100: '#fef9e7',
          200: '#fdf0c9',
          300: '#fce49f',
          400: '#f9d373',
          500: '#f2c94c',
          600: '#e3b33c',
          700: '#c99730',
          800: '#a37c2d',
          900: '#85652a',
        },
        light: '#fafafa',
        cream: '#f5ebdd',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}