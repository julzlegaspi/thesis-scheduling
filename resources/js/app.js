import './bootstrap';

import 'flowbite';

// sidebar functionality
const sidebar = document.getElementById('sidebar');

const toggleSidebarMobile = (
    sidebar,
    sidebarBackdrop,
    toggleSidebarMobileHamburger,
    toggleSidebarMobileClose
) => {
    sidebar.classList.toggle('hidden');
    sidebarBackdrop.classList.toggle('hidden');
    toggleSidebarMobileHamburger.classList.toggle('hidden');
    toggleSidebarMobileClose.classList.toggle('hidden');
};

const toggleSidebarMobileEl = document.getElementById(
    'toggleSidebarMobile'
);
const sidebarBackdrop = document.getElementById('sidebarBackdrop');
const toggleSidebarMobileHamburger = document.getElementById(
    'toggleSidebarMobileHamburger'
);
const toggleSidebarMobileClose = document.getElementById(
    'toggleSidebarMobileClose'
);

toggleSidebarMobileEl.addEventListener('click', () => {
    toggleSidebarMobile(
        sidebar,
        sidebarBackdrop,
        toggleSidebarMobileHamburger,
        toggleSidebarMobileClose
    );
});

sidebarBackdrop.addEventListener('click', () => {
    toggleSidebarMobile(
        sidebar,
        sidebarBackdrop,
        toggleSidebarMobileHamburger,
        toggleSidebarMobileClose
    );
});

 // On page load or when changing themes, best to add inline in `head` to avoid FOUC
 if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark')
}

var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

// Change the icons inside the button based on previous settings
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    themeToggleLightIcon.classList.remove('hidden');
} else {
    themeToggleDarkIcon.classList.remove('hidden');
}

var themeToggleBtn = document.getElementById('theme-toggle');

themeToggleBtn.addEventListener('click', function() {

    // toggle icons inside button
    themeToggleDarkIcon.classList.toggle('hidden');
    themeToggleLightIcon.classList.toggle('hidden');

    // if set via local storage previously
    if (localStorage.getItem('color-theme')) {
        if (localStorage.getItem('color-theme') === 'light') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        }

    // if NOT set via local storage previously
    } else {
        if (document.documentElement.classList.contains('dark')) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    }
    
});