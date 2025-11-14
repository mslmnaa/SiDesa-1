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
        // Nest Theme Colors
        primary: {
          50: '#f0fdf5',
          100: '#dcfce8',
          200: '#bbf7d1',
          300: '#86efad',
          400: '#4ade80',
          500: '#3BB77E', // Main Nest Green
          600: '#2e9d67',
          700: '#267d54',
          800: '#226344',
          900: '#1e5239',
        },
        secondary: {
          50: '#f8fafc',
          100: '#f1f5f9',
          200: '#e2e8f0',
          300: '#cbd5e1',
          400: '#94a3b8',
          500: '#64748b',
          600: '#475569',
          700: '#334155',
          800: '#253D4E', // Main Nest Navy
          900: '#0f172a',
        },
        accent: {
          50: '#fef6ee',
          100: '#fdecd7',
          200: '#fad5ae',
          300: '#f7b97a',
          400: '#f39244',
          500: '#FDC040', // Nest Yellow/Orange
          600: '#ea580c',
          700: '#c2410c',
          800: '#9a3412',
          900: '#7c2d12',
        },
        light: '#F4F6FA',
        cream: '#FFF3E0',
        'nest-green': '#3BB77E',
        'nest-navy': '#253D4E',
        'nest-yellow': '#FDC040',
        'nest-red': '#F74B81',
        'nest-blue': '#29A8DF',
      },
      fontFamily: {
        'sans': ['Quicksand', 'system-ui', 'sans-serif'],
        'heading': ['Lato', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        'display-1': ['5rem', { lineHeight: '1.1', fontWeight: '700' }],
        'display-2': ['3.5rem', { lineHeight: '1.2', fontWeight: '700' }],
        'display-3': ['3rem', { lineHeight: '1.2', fontWeight: '700' }],
      },
      boxShadow: {
        'nest': '20px 20px 54px rgba(0,0,0,0.03)',
        'nest-hover': '20px 20px 54px rgba(0,0,0,0.06)',
      },
      borderRadius: {
        'nest': '15px',
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
}