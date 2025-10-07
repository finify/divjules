// Initialize mobile menu and other interactive elements
function initMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuBtn && mobileMenu) {
        // Remove existing listeners to avoid duplicates
        const newMenuBtn = mobileMenuBtn.cloneNode(true);
        mobileMenuBtn.parentNode.replaceChild(newMenuBtn, mobileMenuBtn);

        newMenuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const currentMobileMenu = document.getElementById('mobile-menu');
            const currentMobileMenuBtn = document.getElementById('mobile-menu-btn');

            if (currentMobileMenu &&
                !currentMobileMenu.contains(event.target) &&
                currentMobileMenuBtn &&
                !currentMobileMenuBtn.contains(event.target)) {
                currentMobileMenu.classList.add('hidden');
            }
        });
    }
}

function initSmoothScroll() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Mobile Menu Toggle - Run on both DOMContentLoaded and Livewire loaded
document.addEventListener('DOMContentLoaded', function() {
    initMobileMenu();
    initSmoothScroll();
});

// Re-initialize when Livewire navigates
document.addEventListener('livewire:navigated', function() {
    initMobileMenu();
    initSmoothScroll();
});

// Re-initialize when Livewire loads
document.addEventListener('livewire:load', function() {
    initMobileMenu();
    initSmoothScroll();
});

// Universities Page - Filter functionality
if (document.getElementById('country-filter')) {
    const countryFilter = document.getElementById('country-filter');
    const typeFilter = document.getElementById('type-filter');
    const rankingFilter = document.getElementById('ranking-filter');
    const searchInput = document.getElementById('search-input');
    const universityCards = document.querySelectorAll('.university-card');
    const resultsCount = document.getElementById('results-count');

    function filterUniversities() {
        const countryValue = countryFilter.value;
        const typeValue = typeFilter.value;
        const rankingValue = rankingFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        let visibleCount = 0;

        universityCards.forEach(card => {
            const cardCountry = card.getAttribute('data-country');
            const cardType = card.getAttribute('data-type');
            const cardRanking = card.getAttribute('data-ranking');
            const cardText = card.textContent.toLowerCase();

            const matchesCountry = !countryValue || cardCountry === countryValue;
            const matchesType = !typeValue || cardType === typeValue;
            const matchesRanking = !rankingValue || cardRanking === rankingValue;
            const matchesSearch = !searchValue || cardText.includes(searchValue);

            if (matchesCountry && matchesType && matchesRanking && matchesSearch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (resultsCount) {
            resultsCount.textContent = visibleCount;
        }
    }

    countryFilter.addEventListener('change', filterUniversities);
    typeFilter.addEventListener('change', filterUniversities);
    rankingFilter.addEventListener('change', filterUniversities);
    searchInput.addEventListener('input', filterUniversities);
}

// Courses Page - Filter functionality
if (document.getElementById('level-filter')) {
    const levelFilter = document.getElementById('level-filter');
    const fieldFilter = document.getElementById('field-filter');
    const durationFilter = document.getElementById('duration-filter');
    const searchInput = document.getElementById('search-input');
    const courseCards = document.querySelectorAll('.course-card');
    const resultsCount = document.getElementById('results-count');
    const categoryButtons = document.querySelectorAll('.category-btn');

    function filterCourses() {
        const levelValue = levelFilter.value;
        const fieldValue = fieldFilter.value;
        const durationValue = durationFilter.value;
        const searchValue = searchInput.value.toLowerCase();

        let visibleCount = 0;

        courseCards.forEach(card => {
            const cardLevel = card.getAttribute('data-level');
            const cardField = card.getAttribute('data-field');
            const cardDuration = card.getAttribute('data-duration');
            const cardText = card.textContent.toLowerCase();

            const matchesLevel = !levelValue || cardLevel === levelValue;
            const matchesField = !fieldValue || cardField === fieldValue;
            const matchesDuration = !durationValue || cardDuration === durationValue;
            const matchesSearch = !searchValue || cardText.includes(searchValue);

            if (matchesLevel && matchesField && matchesDuration && matchesSearch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (resultsCount) {
            resultsCount.textContent = visibleCount;
        }
    }

    // Category button filter
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');

            // Update active button
            categoryButtons.forEach(btn => {
                btn.classList.remove('bg-purple-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
            this.classList.remove('bg-gray-200', 'text-gray-700');
            this.classList.add('bg-purple-600', 'text-white');

            // Filter courses
            if (category === 'all') {
                fieldFilter.value = '';
            } else {
                fieldFilter.value = category;
            }
            filterCourses();
        });
    });

    levelFilter.addEventListener('change', filterCourses);
    fieldFilter.addEventListener('change', filterCourses);
    durationFilter.addEventListener('change', filterCourses);
    searchInput.addEventListener('input', filterCourses);
}

// Blog Page - Category filter
if (document.querySelectorAll('.category-filter').length > 0) {
    const categoryFilters = document.querySelectorAll('.category-filter');
    const blogCards = document.querySelectorAll('.blog-card');

    categoryFilters.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.getAttribute('data-category');

            // Update active button
            categoryFilters.forEach(btn => {
                btn.classList.remove('bg-purple-600', 'text-white');
                btn.classList.add('bg-gray-200', 'text-gray-700');
            });
            this.classList.remove('bg-gray-200', 'text-gray-700');
            this.classList.add('bg-purple-600', 'text-white');

            // Filter blog posts
            blogCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');
                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
}

// Contact Form Submission
if (document.getElementById('contact-form')) {
    const contactForm = document.getElementById('contact-form');

    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Get form data
        const formData = new FormData(contactForm);
        const data = Object.fromEntries(formData);

        // Here you would typically send the data to a server
        console.log('Contact form data:', data);

        // Show success message
        alert('Thank you for your message! We will get back to you within 24 hours.');

        // Reset form
        contactForm.reset();
    });
}

// Add animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all cards for animation
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card-hover');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});

// Form validation helper
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePhone(phone) {
    const re = /^[\d\s\-\+\(\)]+$/;
    return re.test(phone);
}

// Add form validation to all forms
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const emailInputs = form.querySelectorAll('input[type="email"]');
        const phoneInputs = form.querySelectorAll('input[type="tel"]');

        let isValid = true;

        emailInputs.forEach(input => {
            if (input.value && !validateEmail(input.value)) {
                isValid = false;
                input.classList.add('border-red-500');
                alert('Please enter a valid email address');
            } else {
                input.classList.remove('border-red-500');
            }
        });

        phoneInputs.forEach(input => {
            if (input.value && !validatePhone(input.value)) {
                isValid = false;
                input.classList.add('border-red-500');
                alert('Please enter a valid phone number');
            } else {
                input.classList.remove('border-red-500');
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });
});

// Sticky header scroll effect
let lastScroll = 0;
const header = document.querySelector('nav');

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll <= 0) {
        header.classList.remove('shadow-lg');
    } else {
        header.classList.add('shadow-lg');
    }

    lastScroll = currentScroll;
});

// Newsletter form
const newsletterForms = document.querySelectorAll('form');
newsletterForms.forEach(form => {
    if (form.querySelector('input[type="email"][placeholder*="email"]')) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = form.querySelector('input[type="email"]').value;
            if (validateEmail(email)) {
                alert('Thank you for subscribing to our newsletter!');
                form.reset();
            } else {
                alert('Please enter a valid email address.');
            }
        });
    }
});

// Video Testimonial Modal Functions
let currentSlide = 0;

// Make functions globally accessible
window.openVideoModal = function(videoUrl) {
    const modal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoFrame');

    if (modal && videoFrame) {
        videoFrame.src = videoUrl + '?autoplay=1';
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

window.closeVideoModal = function() {
    const modal = document.getElementById('videoModal');
    const videoFrame = document.getElementById('videoFrame');

    if (modal && videoFrame) {
        modal.classList.remove('active');
        videoFrame.src = '';
        document.body.style.overflow = 'auto';
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('videoModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeVideoModal();
            }
        });
    }
});

// Testimonial Slider Functions
window.showSlide = function(n) {
    const slides = document.querySelectorAll('.testimonial-slide');
    const dots = document.querySelectorAll('.slider-dot');

    if (!slides.length) return;

    if (n >= slides.length) { currentSlide = 0; }
    if (n < 0) { currentSlide = slides.length - 1; }

    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => {
        dot.classList.remove('bg-purple-600');
        dot.classList.add('bg-gray-300');
    });

    if (slides[currentSlide]) {
        slides[currentSlide].classList.add('active');
    }
    if (dots[currentSlide]) {
        dots[currentSlide].classList.remove('bg-gray-300');
        dots[currentSlide].classList.add('bg-purple-600');
    }
}

window.changeSlide = function(n) {
    currentSlide += n;
    window.showSlide(currentSlide);
}

window.setSlide = function(n) {
    currentSlide = n;
    window.showSlide(currentSlide);
}

// Auto-advance testimonial slider every 5 seconds
setInterval(function() {
    if (document.querySelector('.testimonial-slider')) {
        window.changeSlide(1);
    }
}, 5000);

// Escape key to close modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        window.closeVideoModal();
        window.closeReviewModal();
    }
});

// Review Modal Functions
window.openReviewModal = function() {
    const modal = document.getElementById('reviewModal');
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

window.closeReviewModal = function() {
    const modal = document.getElementById('reviewModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// Close review modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const reviewModal = document.getElementById('reviewModal');
    if (reviewModal) {
        reviewModal.addEventListener('click', function(e) {
            if (e.target === reviewModal) {
                closeReviewModal();
            }
        });
    }
});

// Star Rating System
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#starRating i');
    const ratingValue = document.getElementById('ratingValue');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingValue.value = rating;

            // Update star colors
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-500');
                } else {
                    s.classList.remove('text-yellow-500');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
});

// Review Form Submission
document.addEventListener('DOMContentLoaded', function() {
    const reviewForm = document.getElementById('reviewForm');

    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const ratingValue = document.getElementById('ratingValue').value;

            if (!ratingValue) {
                alert('Please select a rating');
                return;
            }

            // Get form data
            const formData = new FormData(reviewForm);
            const data = Object.fromEntries(formData);

            // Here you would typically send the data to a server
            console.log('Review form data:', data);

            // Show success message
            alert('Thank you for your review! Your feedback is valuable to us and will be published after review.');

            // Reset form and close modal
            reviewForm.reset();

            // Reset stars
            document.querySelectorAll('#starRating i').forEach(star => {
                star.classList.remove('text-yellow-500');
                star.classList.add('text-gray-300');
            });

            closeReviewModal();
        });
    }
});

// Universities Slider Navigation Controls
let uniSliderSpeed = 60;

window.slowDownUniSlider = function() {
    const track = document.getElementById('universitiesSliderTrack');
    if (track) {
        uniSliderSpeed = 80;
        track.style.animation = `scroll ${uniSliderSpeed}s linear infinite`;

        // Visual feedback
        const btn = event.target.closest('button');
        if (btn) {
            btn.style.background = '#7c3aed';
            btn.style.color = 'white';
            setTimeout(() => {
                btn.style.background = '';
                btn.style.color = '';
            }, 300);
        }
    }
}

window.speedUpUniSlider = function() {
    const track = document.getElementById('universitiesSliderTrack');
    if (track) {
        uniSliderSpeed = 40;
        track.style.animation = `scroll ${uniSliderSpeed}s linear infinite`;

        // Visual feedback
        const btn = event.target.closest('button');
        if (btn) {
            btn.style.background = '#7c3aed';
            btn.style.color = 'white';
            setTimeout(() => {
                btn.style.background = '';
                btn.style.color = '';
            }, 300);
        }
    }
}

// Smooth touch/drag interaction for universities slider
document.addEventListener('DOMContentLoaded', function() {
    const sliderTrack = document.getElementById('universitiesSliderTrack');

    if (sliderTrack) {
        let isDragging = false;
        let startX = 0;
        let currentX = 0;

        sliderTrack.addEventListener('mouseenter', function() {
            this.style.animationPlayState = 'paused';
        });

        sliderTrack.addEventListener('mouseleave', function() {
            if (!isDragging) {
                this.style.animationPlayState = 'running';
            }
        });

        // Touch events for mobile
        sliderTrack.addEventListener('touchstart', function(e) {
            isDragging = true;
            startX = e.touches[0].clientX;
            this.style.animationPlayState = 'paused';
        });

        sliderTrack.addEventListener('touchmove', function(e) {
            if (!isDragging) return;
            currentX = e.touches[0].clientX;
            const diff = currentX - startX;
            // Add subtle resistance
            this.style.transform = `translateX(${diff * 0.3}px)`;
        });

        sliderTrack.addEventListener('touchend', function() {
            isDragging = false;
            this.style.transform = '';
            this.style.animationPlayState = 'running';
        });
    }
});

console.log('Divjules Education Consultancy - Website Loaded Successfully');