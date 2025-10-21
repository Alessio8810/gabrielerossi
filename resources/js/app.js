// Livewire SPA transitions
document.addEventListener('livewire:navigating', () => {
    // Add loading state
    document.body.classList.add('loading');
});

document.addEventListener('livewire:navigated', () => {
    // Remove loading state
    document.body.classList.remove('loading');
    
    // Scroll to top on navigation
    window.scrollTo(0, 0);
});
