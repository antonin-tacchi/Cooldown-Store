// Script complet pour la barre de recherche avec iframe alignée sous l'input
(function() {
    // Supprimer tout ancien conteneur qui pourrait exister
    const oldFrame = document.querySelector('#search-results-frame');
    if (oldFrame) {
        oldFrame.remove();
    }
    
    // Sélectionner les éléments de base
    const searchContainer = document.querySelector('.search-container');
    const searchInput = document.querySelector('.search-input');
    const searchButton = document.querySelector('.search-button');
    
    // Vérifier que les éléments essentiels existent
    if (!searchContainer || !searchInput || !searchButton) {
        console.error('Éléments de recherche manquants!');
        return;
    }
    
    // Créer une iframe pour isoler le contenu des styles CSS de la page
    const iframe = document.createElement('iframe');
    iframe.id = 'search-results-frame';
    iframe.style.cssText = `
        position: absolute;
        border: none;
        width: 400px;
        height: 300px;
        background-color: transparent;
        z-index: 999999;
        display: none;
        border-radius: 0 0 8px 8px;
        overflow: hidden;
    `;
    document.body.appendChild(iframe);
    
    // Fonction pour mettre à jour la position de l'iframe
    function updateFramePosition() {
        const containerRect = searchContainer.getBoundingClientRect();
        
        // Positionner l'iframe exactement sous l'input (pas sous le bouton)
        iframe.style.top = (containerRect.bottom + window.scrollY) + 'px';
        iframe.style.left = (containerRect.left + window.scrollX) + 'px';
        iframe.style.width = containerRect.width + 'px';
        
        console.log('Position iframe mise à jour:', 
            'top:', iframe.style.top, 
            'left:', iframe.style.left, 
            'width:', iframe.style.width);
    }
    
    // Initialiser l'iframe avec un contenu HTML de base
    function initFrame() {
        const frameDoc = iframe.contentDocument || iframe.contentWindow.document;
        frameDoc.open();
        frameDoc.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                    body {
                        margin: 0;
                        padding: 0;
                        background-color: rgba(0, 0, 0, 0.8);
                        font-family: Arial, sans-serif;
                        color: white;
                        overflow-y: auto;
                    }
                    #results-container {
                        width: 100%;
                        max-height: 300px;
                        overflow-y: auto;
                    }
                    .result-item {
                        padding: 12px 20px;
                        cursor: pointer;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                        transition: background-color 0.2s;
                    }
                    .result-item:hover, .result-item.active {
                        background-color: rgba(255, 255, 255, 0.2);
                    }
                    .result-item:last-child {
                        border-bottom: none;
                    }
                    .no-results {
                        padding: 12px 20px;
                        color: rgba(255, 255, 255, 0.7);
                        font-style: italic;
                    }
                    strong {
                        color: white;
                        font-weight: bold;
                    }
                </style>
            </head>
            <body>
                <div id="results-container"></div>
            </body>
            </html>
        `);
        frameDoc.close();
    }
    
    // Initialiser le contenu de l'iframe
    initFrame();
    
    // Fonction pour afficher les résultats dans l'iframe
    function displayResults(results, query) {
        const frameDoc = iframe.contentDocument || iframe.contentWindow.document;
        const container = frameDoc.getElementById('results-container');
        
        if (!container) {
            console.error('Conteneur de résultats non trouvé dans l\'iframe');
            return;
        }
        
        container.innerHTML = '';
        
        if (!results || results.length === 0) {
            const noResults = frameDoc.createElement('div');
            noResults.className = 'no-results';
            noResults.textContent = 'Aucun résultat';
            container.appendChild(noResults);
        } else {
            results.forEach(result => {
                const item = frameDoc.createElement('div');
                item.className = 'result-item';
                
                // Mettre en évidence la requête
                const name = result.name;
                const highlightedName = query && name.toLowerCase().includes(query.toLowerCase()) 
                    ? name.replace(new RegExp(query, 'gi'), match => `<strong>${match}</strong>`)
                    : name;
                
                item.innerHTML = highlightedName;
                
                // Ajouter le clic
                item.addEventListener('click', function() {
                    window.location.href = `?controller=product&action=detail&id=${result.id}`;
                });
                
                // Gestion du survol
                item.addEventListener('mouseover', function() {
                    const activeItems = container.querySelectorAll('.active');
                    activeItems.forEach(el => el.classList.remove('active'));
                    this.classList.add('active');
                });
                
                container.appendChild(item);
            });
        }
        
        // Mettre à jour la position et afficher l'iframe
        updateFramePosition();
        iframe.style.display = 'block';
        
        // Ajuster la hauteur de l'iframe selon le contenu
        const height = Math.min(container.scrollHeight + 10, 300);
        iframe.style.height = height + 'px';
    }
    
    // Événement de clic sur le bouton de recherche
    searchButton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        const isExpanded = searchContainer.classList.contains('expanded');
        
        if (!isExpanded) {
            // Ouvrir la barre
            searchContainer.classList.add('expanded');
            iframe.style.display = 'none';
            setTimeout(() => searchInput.focus(), 300);
        } else {
            // Soumettre ou fermer
            if (searchInput.value.trim()) {
                window.location.href = `?controller=product&action=list&search=${encodeURIComponent(searchInput.value.trim())}`;
            } else {
                searchContainer.classList.remove('expanded');
                iframe.style.display = 'none';
            }
        }
    });
    
    // Gérer la saisie dans le champ de recherche
    let debounceTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        
        const query = this.value.trim();
        
        if (query.length < 2) {
            iframe.style.display = 'none';
            return;
        }
        
        // Attendre un peu avant de rechercher
        debounceTimer = setTimeout(function() {
            // Données de test pour vérification immédiate
            const testResults = [
                { id: 1, name: query + " - Produit 1" },
                { id: 2, name: query + " - Produit 2" },
                { id: 3, name: query + " - Produit 3" }
            ];
            
            console.log('Affichage des résultats de test:', testResults);
            displayResults(testResults, query);
            
            // Version API commentée - à décommenter quand tout fonctionne
            fetch(`?controller=product&action=search&q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Résultats API:', data);
                    displayResults(Array.isArray(data) && data.length > 0 ? data : testResults, query);
                })
                .catch(error => {
                    console.error('Erreur API:', error);
                    displayResults(testResults, query);
                });
        }, 300);
    });
    
    // Navigation au clavier dans les résultats
    searchInput.addEventListener('keydown', function(e) {
        if (iframe.style.display !== 'block') return;
        
        const frameDoc = iframe.contentDocument || iframe.contentWindow.document;
        const container = frameDoc.getElementById('results-container');
        if (!container) return;
        
        const items = container.querySelectorAll('.result-item');
        if (items.length === 0) return;
        
        let activeItem = container.querySelector('.active');
        let activeIndex = -1;
        
        if (activeItem) {
            for (let i = 0; i < items.length; i++) {
                if (items[i] === activeItem) {
                    activeIndex = i;
                    break;
                }
            }
        }
        
        // Touche flèche bas
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            
            if (activeItem) {
                activeItem.classList.remove('active');
            }
            
            activeIndex = (activeIndex + 1) % items.length;
            items[activeIndex].classList.add('active');
            searchInput.value = items[activeIndex].textContent;
        }
        
        // Touche flèche haut
        else if (e.key === 'ArrowUp') {
            e.preventDefault();
            
            if (activeItem) {
                activeItem.classList.remove('active');
            }
            
            activeIndex = activeIndex <= 0 ? items.length - 1 : activeIndex - 1;
            items[activeIndex].classList.add('active');
            searchInput.value = items[activeIndex].textContent;
        }
        
        // Touche Échap
        else if (e.key === 'Escape') {
            iframe.style.display = 'none';
        }
    });
    
    // Gérer la touche Entrée
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            
            const frameDoc = iframe.contentDocument || iframe.contentWindow.document;
            if (frameDoc) {
                const activeItem = frameDoc.querySelector('.active');
                if (activeItem && iframe.style.display === 'block') {
                    // Simuler un clic sur l'élément actif
                    activeItem.click();
                    return;
                }
            }
            
            // Sinon, faire une recherche globale
            if (this.value.trim()) {
                window.location.href = `?controller=product&action=list&search=${encodeURIComponent(this.value.trim())}`;
            }
        }
    });
    
    // Fermer en cliquant ailleurs
    document.addEventListener('click', function(e) {
        const isClickInside = searchContainer.contains(e.target);
        const isClickInsideFrame = iframe.contentWindow && iframe.contentWindow.document.body.contains(e.target);
        
        if (!isClickInside && !isClickInsideFrame) {
            searchContainer.classList.remove('expanded');
            iframe.style.display = 'none';
            searchInput.value = '';
        }
    });
    
    // Ajuster la position de l'iframe au redimensionnement
    window.addEventListener('resize', function() {
        if (iframe.style.display === 'block') {
            updateFramePosition();
        }
    });
    
    console.log('Initialisation terminée avec iframe alignée');
})();