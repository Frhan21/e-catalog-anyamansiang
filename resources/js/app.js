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
    if (event.target.closest('[data-theme-toggle]')) {
        const dark = !document.documentElement.classList.contains('dark');
        document.documentElement.classList.toggle('dark', dark);
        try {
            localStorage.setItem('theme', dark ? 'dark' : 'light');
        } catch {}
    }

    const copyButton = event.target.closest('[data-share-copy]');
    if (copyButton) {
        const fallback = () => window.prompt('Salin tautan produk:', copyButton.dataset.url);
        if (!navigator.clipboard) {
            fallback();
            return;
        }
        navigator.clipboard.writeText(copyButton.dataset.url)
            .then(() => { copyButton.textContent = 'Tautan tersalin'; })
            .catch(fallback);
    }
});

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if (!storedTheme()) applyTheme();
});

document.addEventListener('livewire:navigated', applyTheme);
