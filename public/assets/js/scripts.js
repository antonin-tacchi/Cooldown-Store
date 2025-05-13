
const burger = document.getElementById('burger-menu');
const mobileNav = document.getElementById('mobile-nav');
const overlay = document.getElementById('mobile-overlay');
const closeBtn = document.getElementById('close-mobile-nav');

function toggleMobileMenu(open) {
    if (open) {
        mobileNav.classList.add('open');
        overlay.classList.add('show');
    } else {
        mobileNav.classList.remove('open');
        overlay.classList.remove('show');
    }
}

burger.addEventListener('click', () => toggleMobileMenu(true));
closeBtn.addEventListener('click', () => toggleMobileMenu(false));
overlay.addEventListener('click', () => toggleMobileMenu(false));



// Carrousel hero automatique avec départ aléatoire (entièrement JS)
document.addEventListener('DOMContentLoaded', function() {
    // Éléments du carrousel
    const slides = document.querySelectorAll('.carousel-slide');
    
    // Ne rien faire s'il n'y a pas assez de slides
    if (slides.length <= 1) {
        return;
    }
    
    // Cacher tous les slides au début
    slides.forEach(slide => {
        slide.style.display = 'none';
    });
    
    // Générer un index aléatoire
    let currentSlide = Math.floor(Math.random() * slides.length);
    const slideCount = slides.length;
    
    // Fonction pour changer de slide
    function goToSlide(index) {
        // Cacher tous les slides
        slides.forEach(slide => {
            slide.classList.remove('active');
            slide.style.display = 'none';
        });
        
        // Ajuster l'index si nécessaire
        if (index < 0) index = slideCount - 1;
        if (index >= slideCount) index = 0;
        
        // Afficher le slide actuel
        slides[index].classList.add('active');
        slides[index].style.display = 'block';
        
        // Mettre à jour l'index du slide actuel
        currentSlide = index;
    }
    
    // Initialiser avec un slide aléatoire
    goToSlide(currentSlide);
    
    // Fonction pour passer au slide suivant
    function nextSlide() {
        goToSlide(currentSlide + 1);
    }
    
    // Changement automatique de slide toutes les 4 secondes
    setInterval(nextSlide, 10000);
});