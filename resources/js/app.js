import './bootstrap';
import "perfect-scrollbar/css/perfect-scrollbar.css";

import swal from 'sweetalert2';
window.Swal = swal;

import Sortable from 'sortablejs';
window.Sortable = Sortable;

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

import PerfectScrollbar from "perfect-scrollbar";
window.PerfectScrollbar = PerfectScrollbar;

import editorjs from './editorjs';

Alpine.data("mainState", () => {

    const useTheme = () => {
        if (window.localStorage.getItem("dark")) {
            return JSON.parse(window.localStorage.getItem("dark"));
        }
        return (
            !!window.matchMedia &&
            window.matchMedia("(prefers-color-scheme: dark)").matches
        );
    };
    const setTheme = (value) => {
        window.localStorage.setItem("dark", value);
    };

    const loadingMask = {
        pageLoaded: false,
        showText: false,
        init() {
            window.onload = () => {
                this.pageLoaded = true;
            };
            this.animateCharge();
        },
        animateCharge() {
            setInterval(() => {
                this.showText = true;
                setTimeout(() => {
                    this.showText = false;
                }, 2000);
            }, 4000);
        },
    };

    const handleOutsideClick = (event) => {
        if (
            this.isSidebarOpen &&
            !event.target.closest(".sidebar") &&
            !event.target.closest(".sidebar-toggle")
        ) {
            this.isSidebarOpen = false;
        }
    };

    document.addEventListener("click", handleOutsideClick);


    return {
        loadingMask,
        isDarkMode: useTheme(),
        toggleTheme() {
            this.isDarkMode = !this.isDarkMode;
            setTheme(this.isDarkMode);
        },
        isSidebarOpen: sessionStorage.getItem("sidebarOpen") === "true",
        handleSidebarToggle() {
            this.isSidebarOpen = !this.isSidebarOpen;
            sessionStorage.setItem("sidebarOpen", this.isSidebarOpen.toString());
        },
        closeSidebarOnMobile() {
            if (window.innerWidth < 1024) {
                this.isSidebarOpen = false;
            }
        },
        isSidebarHovered: false,
        handleSidebarHover(value) {
            if (window.innerWidth < 1024) {
                return;
            }
            this.isSidebarHovered = value;
        },
        handleWindowResize() {
            if (window.innerWidth <= 1024) {
                this.isSidebarOpen = false;
            } else {
                this.isSidebarOpen = true;
            }
        },
    };
});

Livewire.start()