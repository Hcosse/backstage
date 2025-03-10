document.addEventListener('DOMContentLoaded', () => {
    // Smooth scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Effet fade-in sur le conteneur principal
    const container = document.querySelector('.content');
    if (container) {
        container.style.opacity = 0;
        let opacity = 0;
        const fadeInInterval = setInterval(() => {
            opacity += 0.05;
            container.style.opacity = opacity;
            if (opacity >= 1) clearInterval(fadeInInterval);
        }, 20);
    }

    // Animation hover sur les éléments de la liste d'événements
    document.querySelectorAll('.event-list li').forEach(item => {
        item.addEventListener('mouseover', () => {
            item.style.transform = 'scale(1.02)';
            item.style.transition = 'transform 0.3s';
        });
        item.addEventListener('mouseout', () => {
            item.style.transform = 'scale(1)';
        });
    });

    // (Les onglets du dashboard sont gérés via une fonction inline dans la vue)
});
