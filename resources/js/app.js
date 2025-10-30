import './bootstrap';
import 'flowbite';
import 'laravel-datatables-vite';
import { Notyf } from 'notyf';
import sort from '@alpinejs/sort'



Alpine.plugin(sort)

const notyf = new Notyf({
    duration: 3000,
    position: {
        x: 'right',
        y: 'bottom',
    },
});
if (!window.notyf) {
    window.notyf = notyf;
}