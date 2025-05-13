<?php require_once 'app/views/layouts/header.php'; ?>

<main class="admin-page">
    <div class="container">
        <div class="admin-header">
            <h1>Tableau de bord administrateur</h1>
        </div>
        
        <div class="admin-container">
            <!-- Menu latéral admin -->
            <div class="admin-sidebar">
                <nav class="admin-nav">
                    <a href="?controller=admin&action=dashboard" class="active">Tableau de bord</a>
                    <a href="?controller=admin&action=products">Gestion des produits</a>
                    <a href="?controller=admin&action=categories">Gestion des catégories</a>
                    <a href="?controller=admin&action=orders">Gestion des commandes</a>
                    <a href="?controller=admin&action=users">Gestion des utilisateurs</a>
                    <a href="index.php">Retour au site</a>
                </nav>
            </div>
            
            <!-- Contenu principal -->
            <div class="admin-content">
                <div class="dashboard-stats">
                    <div class="stat-card">
                        <div class="stat-icon">📦</div>
                        <div class="stat-data">
                            <div class="stat-number">150</div>
                            <div class="stat-title">Produits</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">🛒</div>
                        <div class="stat-data">
                            <div class="stat-number">32</div>
                            <div class="stat-title">Commandes</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">👥</div>
                        <div class="stat-data">
                            <div class="stat-number">85</div>
                            <div class="stat-title">Utilisateurs</div>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-icon">💰</div>
                        <div class="stat-data">
                            <div class="stat-number">4 580 €</div>
                            <div class="stat-title">Revenus du mois</div>
                        </div>
                    </div>
                </div>
                
                <div class="dashboard-section">
                    <h2>Dernières commandes</h2>
                    <div class="dashboard-table-container">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#1235</td>
                                    <td>Jean Dupont</td>
                                    <td>95,80 €</td>
                                    <td>15/04/2023</td>
                                    <td><span class="status-badge processing">En traitement</span></td>
                                </tr>
                                <tr>
                                    <td>#1234</td>
                                    <td>Marie Martin</td>
                                    <td>120,50 €</td>
                                    <td>14/04/2023</td>
                                    <td><span class="status-badge shipped">Expédiée</span></td>
                                </tr>
                                <tr>
                                    <td>#1233</td>
                                    <td>Pierre Durand</td>
                                    <td>45,90 €</td>
                                    <td>13/04/2023</td>
                                    <td><span class="status-badge delivered">Livrée</span></td>
                                </tr>
                                <tr>
                                    <td>#1232</td>
                                    <td>Sophie Lambert</td>
                                    <td>78,30 €</td>
                                    <td>12/04/2023</td>
                                    <td><span class="status-badge delivered">Livrée</span></td>
                                </tr>
                                <tr>
                                    <td>#1231</td>
                                    <td>Luc Bernard</td>
                                    <td>150,20 €</td>
                                    <td>11/04/2023</td>
                                    <td><span class="status-badge delivered">Livrée</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="dashboard-action">
                        <a href="?controller=admin&action=orders" class="button button-secondary">Voir toutes les commandes</a>
                    </div>
                </div>
                
                <div class="dashboard-section">
                    <h2>Produits populaires</h2>
                    <div class="dashboard-table-container">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Catégorie</th>
                                    <th>Prix</th>
                                    <th>Stock</th>
                                    <th>Ventes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Cyberpunk 2077</td>
                                    <td>PC</td>
                                    <td>59,90 €</td>
                                    <td>15</td>
                                    <td>45</td>
                                </tr>
                                <tr>
                                    <td>The Last of Us Part II</td>
                                    <td>PlayStation</td>
                                    <td>69,90 €</td>
                                    <td>8</td>
                                    <td>38</td>
                                </tr>
                                <tr>
                                    <td>Animal Crossing New Horizons</td>
                                    <td>Nintendo</td>
                                    <td>54,90 €</td>
                                    <td>12</td>
                                    <td>32</td>
                                </tr>
                                <tr>
                                    <td>FIFA 2023</td>
                                    <td>Xbox</td>
                                    <td>69,90 €</td>
                                    <td>20</td>
                                    <td>28</td>
                                </tr>
                                <tr>
                                    <td>Minecraft</td>
                                    <td>PC</td>
                                    <td>29,90 €</td>
                                    <td>50</td>
                                    <td>25</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="dashboard-action">
                        <a href="?controller=admin&action=products" class="button button-secondary">Gérer les produits</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once 'app/views/layouts/footer.php'; ?>