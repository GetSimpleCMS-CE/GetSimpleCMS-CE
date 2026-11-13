/** @type {import('tailwindcss').Config} */
module.exports = {
  prefix: 'tw-',
  darkMode: 'class',
  corePlugins: { preflight: false },
  content: [
    '../*.php',
    '../../*.php',
  ],
  theme: {
    extend: {
      colors: {
        gs: {
          bg: 'rgb(var(--gs-bg) / <alpha-value>)',
          panel: 'rgb(var(--gs-panel) / <alpha-value>)',
          border: 'rgb(var(--gs-border) / <alpha-value>)',
          text: 'rgb(var(--gs-text) / <alpha-value>)',
          muted: 'rgb(var(--gs-muted) / <alpha-value>)',
          primary: 'rgb(var(--gs-primary) / <alpha-value>)',
        },
      },
      boxShadow: {
        soft: '0 10px 30px -12px rgb(15 23 42 / 0.25)',
      },
    },
  },
  plugins: [],
};
