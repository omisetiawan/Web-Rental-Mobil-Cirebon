import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Inter"', ...defaultTheme.fontFamily.sans],
                inter: ['"Inter"', ...defaultTheme.fontFamily.sans],
                display: ['"Inter"', ...defaultTheme.fontFamily.sans],
                mono: ['"Inter"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'horizon-navy': '#001733',
                'signal-blue': '#006aed',
                'cyan-dawn': '#18dcdc',
                'slate-whisper': '#68748d',
                'graphite-dim': '#464e5d',
                fog: '#d1d6e0',
                mist: '#e6e9f0',
                hailstone: '#f3f4f8',
                'paper-white': '#ffffff',
                coal: '#000000',

                // Direct shorthand tokens
                navy: '#001733',
                signal: '#006aed',
                cyan: '#18dcdc',
                slate: '#68748d',
                graphite: '#464e5d',
                paper: '#ffffff',

                // Theme semantic mapping
                surface: '#f3f4f8',
                surfaceRaised: '#ffffff',
                accent: {
                    DEFAULT: '#006aed',
                    hover: '#0056c7',
                    dim: 'rgba(0,106,237,0.08)',
                },
                muted: '#68748d',
            },
            fontSize: {
                caption: ['12px', { lineHeight: '1.3', letterSpacing: '0px' }],
                'body-sm': ['14px', { lineHeight: '1.4', letterSpacing: '0px' }],
                body: ['16px', { lineHeight: '1.5', letterSpacing: '0px' }],
                subheading: ['20px', { lineHeight: '1.2', letterSpacing: '-0.6px' }],
                'subheading-lg': ['24px', { lineHeight: '1.2', letterSpacing: '-0.72px' }],
                'heading-sm': ['36px', { lineHeight: '1.1', letterSpacing: '-1.368px' }],
                heading: ['44px', { lineHeight: '1.0', letterSpacing: '-1.672px' }],
                'heading-lg': ['52px', { lineHeight: '0.97', letterSpacing: '-2.08px' }],
                display: ['64px', { lineHeight: '0.96', letterSpacing: '-2.56px' }],
                hero: ['90px', { lineHeight: '0.96', letterSpacing: '-3.6px' }],
            },
            borderRadius: {
                md: '4px',
                lg: '8px',
                cards: '8px',
                badges: '4px',
                buttons: '8px',
                iconbuttons: '9999px',
            },
            backgroundColor: {
                base: '#ffffff',
                paper: '#ffffff',
                hailstone: '#f3f4f8',
                navy: '#001733',
            },
            borderColor: {
                base: '#e6e9f0',
                mist: '#e6e9f0',
                fog: '#d1d6e0',
            },
        },
    },

    plugins: [forms],
};
