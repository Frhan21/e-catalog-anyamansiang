import './sliders';
import './animations';

const systemTheme = () => window.matchMedia('(prefers-color-scheme: dark)').matches;
const storedTheme = () => {
    try {
        return localStorage.getItem('theme');
    } catch {
        return null;
    }
};
const applyTheme = () => {
    const theme = storedTheme();
    document.documentElement.classList.toggle('dark', theme ? theme === 'dark' : systemTheme());
};

document.addEventListener('click', (event) => {
    if (!event.target.closest('[data-theme-toggle]')) return;

    const dark = !document.documentElement.classList.contains('dark');
    document.documentElement.classList.toggle('dark', dark);
    try {
        localStorage.setItem('theme', dark ? 'dark' : 'light');
    } catch {}
});

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if (!storedTheme()) applyTheme();
});

document.addEventListener('livewire:navigated', applyTheme);
