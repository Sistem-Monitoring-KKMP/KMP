import { MapContainer, TileLayer, Marker, Popup } from "react-leaflet";
import "leaflet/dist/leaflet.css";
import L from 'leaflet';
import icon from 'leaflet/dist/images/marker-icon.png';
import iconShadow from 'leaflet/dist/images/marker-shadow.png';


let DefaultIcon = L.icon({
    iconUrl: icon,
    shadowUrl: iconShadow,
    iconSize: [25, 41],
    iconAnchor: [12, 41]
});

L.Marker.prototype.options.icon = DefaultIcon;

type mapData = {
    id: number;
    nama: string;
    lat: number;
    lng: number;
    cdi: number;
    bdi: number;
    odi: number;
    alamat: string;
    status: string;
};

export default function MyMap({ data }: { data: mapData[] }) {

    const center: [number, number] = data.length
        ? [data[0].lat, data[0].lng]
        : [-6.595038, 106.816635]; // Pusat Kota BBogor
    return (
        <MapContainer center={center} zoom={13} style={{ height: "400px", width: "100%", borderRadius: "0.5rem" }}>
            <TileLayer
                attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            />

            {data.map((item) => (
                <Marker key={item.id} position={[item.lat, item.lng]}>
                    <Popup>
                        <div className="p-1">
                            <h3 className="font-bold text-sm mb-1">{item.nama}</h3>
                            <p className="text-xs text-gray-600 mb-2">{item.alamat}</p>
                            <div className="grid grid-cols-3 gap-2 text-center text-xs">
                                <div className="bg-blue-50 p-1 rounded">
                                    <div className="font-semibold text-blue-700">CDI</div>
                                    <div>{item.cdi}</div>
                                </div>
                                <div className="bg-green-50 p-1 rounded">
                                    <div className="font-semibold text-green-700">BDI</div>
                                    <div>{item.bdi}</div>
                                </div>
                                <div className="bg-purple-50 p-1 rounded">
                                    <div className="font-semibold text-purple-700">ODI</div>
                                    <div>{item.odi}</div>
                                </div>
                            </div>
                            <div className="mt-2 text-xs">
                                <span className={`px-2 py-0.5 rounded-full ${item.status === 'Aktif' ? 'bg-green-100 text-green-800' :
                                        item.status === 'TidakAktif' ? 'bg-red-100 text-red-800' :
                                            'bg-yellow-100 text-yellow-800'
                                    }`}>
                                    {item.status}
                                </span>
                            </div>
                        </div>
                    </Popup>
                </Marker>
            ))}
        </MapContainer>
    );
}
