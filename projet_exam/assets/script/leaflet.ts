import L from "leaflet";
import {ICenterCoordinate} from "./i-center-coordinate";

function initCenterMap(): void {
    const mapContainer: HTMLDivElement = document.querySelector('#map');
    if (mapContainer) {
        const coordinates: ICenterCoordinate[] = JSON.parse(mapContainer.dataset.mapData);

        let map = L.map('map', {
            center: L.latLng(45.7772, 3.0870),
            zoom: 9,
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        L.Icon.Default.mergeOptions({
            iconRetinaUrl: '/build/images/leaflet/marker-icon-2x.png',
            iconUrl: '/build/images/leaflet/marker-icon.png',
            shadowUrl: '/build/images/leaflet/marker-shadow.png',
        });

        coordinates.forEach((coordinate) => {
            L.marker([coordinate.latitude, coordinate.longitude]).addTo(map)
                .bindTooltip(coordinate.centerName, { permanent: false, direction: "top" });
        });
    }
}

window.addEventListener('load', () => {
    initCenterMap();
});
