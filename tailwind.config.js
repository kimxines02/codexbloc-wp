/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php',
    './inc/**/*.php',
    './template-parts/**/*.php',
    './codexbloc-showcase/**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        // Accent is driven by a CSS variable so it can be changed in Appearance > Customize.
        accent: {
          DEFAULT: 'rgb(var(--cb-accent) / <alpha-value>)',
          dark: 'rgb(var(--cb-accent-dark) / <alpha-value>)',
          soft: 'rgb(var(--cb-accent-soft) / <alpha-value>)',
        },
        ink: '#1d1d1f',
        // Neutral scale tuned to a sleek, professional gray-on-white palette
        // (true neutrals, not blue-tinted) instead of Tailwind's default slate.
        slate: {
          50: '#fbfbfd',
          100: '#f5f5f7',
          200: '#e8e8ed',
          300: '#d2d2d7',
          400: '#a1a1a6',
          500: '#86868b',
          600: '#6e6e73',
          700: '#424245',
          800: '#333336',
          900: '#1d1d1f',
          950: '#000000',
        },
      },
      fontFamily: {
        sans: [
          '-apple-system', 'BlinkMacSystemFont', '"SF Pro Display"', '"SF Pro Text"', 'system-ui',
          '"Segoe UI"', 'Roboto', '"Helvetica Neue"', 'Arial', 'sans-serif',
        ],
      },
    },
  },
  plugins: [],
};
