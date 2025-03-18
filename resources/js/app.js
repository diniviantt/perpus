import Swal from "sweetalert2";
import "./bootstrap";
import Aos from "aos";
import Alpine from "alpinejs";
import { createIcons, icons } from "lucide";

lucide.createIcons();

Alpine.store("modal", {
    testing: false,
    modalUser: false,
    modalAddUser: false,
    modalUpload: false,
    modalPeminjaman: false,
    modalBuku: false,
    modalPerpanjangan: false,
});

window.Alpine = Alpine;
Alpine.start();

Aos.init();
window.Swal = Swal;
