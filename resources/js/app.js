import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// resources/js/app.js

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';  // Assure-toi d'inclure le CSS de Leaflet

// Initialisation de la carte
document.addEventListener('DOMContentLoaded', () => {
    const map = L.map('map').setView([51.505, -0.09], 13); // Change ces coordonnées pour la localisation souhaitée

    // Ajoute une couche de carte (exemple avec OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
});
