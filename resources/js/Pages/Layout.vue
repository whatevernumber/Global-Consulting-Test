<script setup>
    import { Link, router, usePage } from "@inertiajs/vue3";

    const page = usePage();
    const user = page.props.user;

</script>

<template>
    <div class="page_wrapper">
        <div class="side_nav_wrapper">
            <div class="logo-block_wrapper">
                <div class="logo_wrapper">
                    <img src="/resources/img/logo.svg" width="100" height="40" alt="Company logo">
                </div>
            <p class="logo_title">Потому что интернет нужен</p>
            </div>
            <nav class="side_nav">
                <Link :class="['link', 'link_side', { 'active': $page.url.startsWith('/products') }]" href="/products">Продукты</Link>
            </nav>
        </div>
        <div class="main_wrapper">
            <header class="main_header">
                <nav>
                    <Link :class="['link', 'link_header', { 'active': $page.url.startsWith('/products') }]" href="/products">Продукты</Link>
                </nav>
                <div class="user_info">
                    <p class="user_name">{{ user.name }}</p>
                    <p class='logout_button' @click="router.post('/logout')">Выйти</p>
                </div>
            </header>
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>

    .link_header {
        padding: 15px 5px 22px;
    }

    .link_side {
        color: #ffffff;
        opacity: 70%;
        text-align: right;
        margin-left: auto;
    }

    .link_header.active {
        border-bottom: 4px solid #ED1C24;
    }

    .link_side.active,
    .link_header.active {
        color: #ED1C24;
    }

    .link_side:hover,
    .link_header:hover {
        color: salmon;
    }

    .side_nav_wrapper {
        min-height: 100vh;
        width: 300px;
        background-color: #4a5568;
    }

    .side_nav {
        margin-top: 5px;
        margin-left: 60px;
    }

    .page_wrapper {
        display: flex;
    }

    .main_wrapper {
        flex-grow: 1;
    }

    .main_header {
        padding: 20px 15px 10px;
        display: flex;
        justify-content: space-between;
        background-color: #f7fafc;
    }

    .logo-block_wrapper {
        display: flex;
        column-gap: 10px;
    }

    .logo_wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80px;
        width: 150px;
        background-color: #f7fafc;
        border-bottom-right-radius: 25px;
    }

    .logo_title {
        padding-top: 5px;
        padding-right: 20px;
        text-align: center;
        color: #edf2f7;
    }

    .logout_button {
        opacity: 70%;
        font-size: 10px;
        color: #ED1C24;
        cursor: pointer;
    }

    .logout_button:hover {
        background-color: lavenderblush;
    }

    .user_name {
        margin-bottom: 5px;
        color: #a0aec0;
        opacity: 70%;
        font-size: 14px;
    }

    .user_info {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

</style>
