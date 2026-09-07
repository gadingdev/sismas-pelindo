import './bootstrap';

// ==========================================
// BOOTSTRAP JS
// ==========================================
import * as bootstrap from 'bootstrap';

// ==========================================
// FONT AWESOME
// ==========================================
import '@fortawesome/fontawesome-free/js/fontawesome';
import '@fortawesome/fontawesome-free/js/solid';
import '@fortawesome/fontawesome-free/js/regular';
import '@fortawesome/fontawesome-free/js/brands';

// ==========================================
// REGISTER GAMBAR UNTUK VITE (biar logo bisa dipake)
// ==========================================
import.meta.glob([
    '../images/**',
]);

// ==========================================
// SWEET ALERT
// ==========================================
import Swal from 'sweetalert2';
window.Swal = Swal;

// ==========================================
// SIGNATURE PAD
// ==========================================
import SignaturePad from 'signature_pad';
window.SignaturePad = SignaturePad;


// ==========================================
// (OPSIONAL) REGISTER COMPONENT VUE/ALPINE
// ==========================================
// import Alpine from 'alpinejs';
// window.Alpine = Alpine;
// Alpine.start();