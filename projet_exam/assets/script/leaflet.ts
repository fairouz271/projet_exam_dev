import L from "leaflet";

import 'leaflet/dist/leaflet.css';

const map = L.map('map', {
    center: L.latLng(45.7772, 3.0870),
    zoom: 9,
});

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href=""></a> '
}).addTo(map);
