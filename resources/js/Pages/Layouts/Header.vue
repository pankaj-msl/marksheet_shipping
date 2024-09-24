<template>
    <!-- ======= Header ======= -->
    <div class="header-navbar-shadow"></div>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a
                href="#"
                class="logo d-flex align-items-center hide-desktop"
            >
                <img
                    :src="data.client.logo"
                    alt=""
                />
            </a>
            <i class="bi bi-list toggle-sidebar-btn" @click="toggleSidebar"></i>
        </div>
        <!-- End Logo -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <!-- End Search Icon-->
                <li class="nav-item dropdown">
                    <a
                        class="nav-link nav-icon"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">4</span> </a
                    ><!-- End Notification Icon -->
                    <ul
                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
                    >
                        <li class="dropdown-header">
                            You have 4 new notifications
                            <a href="#"
                                ><span
                                    class="badge rounded-pill bg-primary p-2 ms-2"
                                    >View all</span
                                ></a
                            >
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li class="notification-item">
                            <div>
                                <h4>Lorem Ipsum</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>30 min. ago</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li class="notification-item">
                            <div>
                                <h4>Atque rerum nesciunt</h4>
                                <p>Quae dolorem earum veritatis oditseno</p>
                                <p>1 hr. ago</p>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>
                    </ul>
                    <!-- End Notification Dropdown Items -->
                </li>
                <!-- End Notification Nav -->

                <li class="nav-item dropdown pe-3">
                    <a
                        class="nav-link nav-profile d-flex align-items-center pe-0"
                        href="#"
                        data-bs-toggle="dropdown"
                    >
                        <img
                            src="https://randomuser.me/api/portraits/men/85.jpg"
                            alt="Profile"
                            class="rounded-circle"
                        /> </a
                    ><!-- End Profile Iamge Icon -->
                    <ul
                        class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"
                    >
                        <li class="dropdown-header">
                            <h6>{{ data.admin.user_fullName }}</h6>
                            <span>Admin</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider" />
                        </li>
                        <li>
                            <a
                                class="dropdown-item d-flex align-items-center"
                                href="#"
                            >
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                    <!-- End Profile Dropdown Items -->
                </li>
                <!-- End Profile Nav -->
            </ul>
        </nav>
        <!-- End Icons Navigation -->
    </header>
    <!-- End Header -->
    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <div class="university-logo">
            <a href="#" class="logo d-flex align-items-center">
                <img
                    :src="data.client.logo"
                    alt=""
                />
                <span class="d-none d-lg-block"
                    >{{ data.client.name }}</span
                >
            </a>
        </div>

        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <Link class="nav-link collapsed" :href="'/marksheet/dashboard'">
                    <i class="bi bi-tropical-storm"></i>
                    <span>Dashboard</span>
                </Link>
            </li>
            <li class="nav-item">
                <Link class="nav-link collapsed" :href="'/marksheet/index'">
                    <i class="bi bi-tropical-storm"></i>
                    <span>Marksheet Upload</span>
                </Link>
            </li>
            <!-- student -->
            <li class="nav-item">
                <Link class="nav-link collapsed" :href="'/shipments'">
                    <i class="bi bi-tropical-storm"></i>
                    <span>Shipment Tracking</span>
                </Link>
            </li>
            <!-- shipment tracking -->
        </ul>
    </aside>
    <!-- End Sidebar-->
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Link } from '@inertiajs/vue3';

defineProps({
    data: {
        type: Object,
        required: true
    }
});

const isHeaderScrolled = ref(false);
const isBackToTopActive = ref(false);

const select = (el, all = false) => {
    el = el.trim();
    if (all) {
        return [...document.querySelectorAll(el)];
    } else {
        return document.querySelector(el);
    }
};

const toggleSidebar = () => {
    document.body.classList.toggle("toggle-sidebar");
};

const toggleSearchBar = () => {
    const searchBar = select(".search-bar");
    if (searchBar) {
        searchBar.classList.toggle("search-bar-show");
    }
};

const onScrollHandler = () => {
    const position = window.scrollY + 200;
    const navbarlinks = select("#navbar .scrollto", true);
    navbarlinks.forEach((navbarlink) => {
        if (!navbarlink.hash) return;
        const section = select(navbarlink.hash);
        if (!section) return;
        if (
            position >= section.offsetTop &&
            position <= section.offsetTop + section.offsetHeight
        ) {
            navbarlink.classList.add("active");
        } else {
            navbarlink.classList.remove("active");
        }
    });

    if (window.scrollY > 100) {
        isHeaderScrolled.value = true;
        isBackToTopActive.value = true;
    } else {
        isHeaderScrolled.value = false;
        isBackToTopActive.value = false;
    }
};

onMounted(() => {
    const header = select("#header");
    if (header) {
        window.addEventListener("scroll", onScrollHandler);
    }

    const needsValidation = select(".needs-validation", true);
    needsValidation.forEach((form) => {
        form.addEventListener(
            "submit",
            function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add("was-validated");
            },
            false
        );
    });

    const datatables = select(".datatable", true);
    datatables.forEach((datatable) => {
        new simpleDatatables.DataTable(datatable);
    });

    const mainContainer = select("#main");
    if (mainContainer) {
        setTimeout(() => {
            new ResizeObserver(() => {
                select(".echart", true).forEach((getEchart) => {
                    echarts.getInstanceByDom(getEchart).resize();
                });
            }).observe(mainContainer);
        }, 200);
    }
});
</script>

<style scoped>
@media only screen and (min-width: 1200px) and (max-width: 5000px) {
    .hide-desktop {
        display: none !important;
    }
}
</style>
