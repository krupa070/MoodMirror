// Smooth scroll to sections
function scrollToSection(id) {
    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}

// Mobile menu toggle (basic implementation)
function toggleMobileMenu() {
    // You can expand this to show/hide a mobile menu
    console.log('Mobile menu toggled');
}

// Carousel functionality
let currentSlide = 0;
const track = document.getElementById('carouselTrack');
const cards = document.querySelectorAll('.team-card');
const totalCards = cards.length;

// Get how many cards to show based on screen size
function getCardsToShow() {
    if (window.innerWidth >= 1024) return 3;
    if (window.innerWidth >= 640) return 2;
    return 1;
}

// Get max slides based on screen size
function getMaxSlides() {
    return totalCards - getCardsToShow();
}

// Update carousel position
function updateCarousel() {
    const cardsToShow = getCardsToShow();
    const cardWidth = cards[0].offsetWidth;
    const gap = 24; // 1.5rem gap
    const offset = currentSlide * (cardWidth + gap);
    track.style.transform = `translateX(-${offset}px)`;
    
    // Update button states
    const prevBtn = document.querySelector('.carousel-btn-prev');
    const nextBtn = document.querySelector('.carousel-btn-next');
    
    prevBtn.disabled = currentSlide === 0;
    nextBtn.disabled = currentSlide >= getMaxSlides();
}

// Slide carousel
function slideCarousel(direction) {
    const maxSlides = getMaxSlides();
    
    currentSlide += direction;
    
    // Clamp the current slide
    if (currentSlide < 0) {
        currentSlide = 0;
    } else if (currentSlide > maxSlides) {
        currentSlide = maxSlides;
    }
    
    updateCarousel();
}

// Handle window resize
let resizeTimer;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        // Reset to first slide if current position is invalid
        const maxSlides = getMaxSlides();
        if (currentSlide > maxSlides) {
            currentSlide = maxSlides;
        }
        updateCarousel();
    }, 250);
});

// Initialize carousel on page load
window.addEventListener('load', () => {
    updateCarousel();
});
