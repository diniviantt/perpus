import Swal from "sweetalert2";
import "./bootstrap";
import Aos from "aos";
import Alpine from "alpinejs";

Alpine.store("modal", {
    testing: false,
    modalUser: false,
});

window.Alpine = Alpine;
Alpine.start();

Aos.init();
window.Swal = Swal;
