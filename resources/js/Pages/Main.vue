<script setup>

import {ref} from "vue";
import { Link, Head } from "@inertiajs/vue3";

import Layout from "@/Pages/Layout.vue";
import ModalShow from "@/Pages/Modals/ModalShow.vue";
import ModalEdit from "@/Pages/Modals/ModalEdit.vue";
import ModalSuccess from "@/Pages/Modals/ModalSuccess.vue";
import BlueButton from "@/Pages/Button/BlueButton.vue";

const props = defineProps(['products', 'statuses']);

let success = ref(); // defines if the action was successful;
let current_product = ref();
let is_editing = ref();
let is_adding = ref();

// clears the chosen product after the edition process
let update_current_product = function () {
    current_product.value = null;
}

// clears all the variables after successful placement\edition
let clear_variables = function () {
    success.value = true;
    is_editing.value = false;
    is_adding.value = false;
    current_product.value = false;
}

// closes the success window
let close_success = function () {
    success.value = false;
}

// closes the edit/add window when user clicks 'close'
let clear_edit = function () {
    is_editing.value = false;
    is_adding.value = false;
}

</script>

<template>
    <Head title="Продукты" />
    <layout>
        <div class="main_wrapper">
            <div class="table_wrapper">
                <table>
                    <tr>
                        <th>
                            Артикул
                        </th>
                        <th>
                            Название
                        </th>
                        <th>
                            Статус
                        </th>
                        <th>
                            Атрибуты
                        </th>
                    </tr>
                    <tr v-for="product in props.products.data" v-on:click="current_product = product" class="product_row">
                        <td>
                            <p>
                            {{ product.article }}
                            </p>
                        </td>
                        <td>
                            {{ product.name }}
                        </td>
                        <td>
                            {{ (product.status_id === 1 ? 'Доступен' : 'Недоступен' ) }}
                        </td>
                        <td>
                            <p v-for="data in JSON.parse(product.data)">
                                <span class="attribute_title">{{ data.type }}: </span> {{ data.value }}
                            </p>
                        </td>
                    </tr>
                </table>
                <ul v-if="products.total > 0" class="paginate_list">
                    <li v-for="link in products.links">
                        <a
                            :href="link.url" :class="[ 'paginate_link', {disabled: (link.url === null), active: parseInt(link.label) === products.current_page}]">
                       <span>
                           {{
                               link.label.includes('pagination') ? (link.label === 'pagination.next' ? 'Вперёд' : 'Назад') : link.label
                           }}
                       </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="add_button_wrapper">
                <blue-button :name="'Добавить'" @click="is_adding = true" />
                <div class="filter_list">
                    <p>Показать:</p>
                    <ul class="sort_list">
                        <li class="sort_item">
                            <Link href="/products" :only="['products']" :class="['sort_link', { active: !$page.url.includes('available')}]">Все</Link>
                        </li>
                        <li class="sort_item">
                            <Link href="/products/available" :only="['products']" :class="['sort_link', { active: $page.url.startsWith('/products/available')}]" >Только доступные</Link>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </layout>
    <div v-if="current_product || is_adding || success" class="overlay"></div>
    <div v-if="current_product && !is_editing">
        <modal-show :product="current_product" @delete="update_current_product" @edit="is_editing = true" @close="current_product = null"/>
    </div>
    <div v-if="(is_editing || is_adding)">
        <modal-edit :product="current_product ?? []" :statuses="statuses" @saved="clear_variables" @close="clear_edit" />
    </div>
    <div v-if="success">
        <modal-success @close_success="success = false" />
    </div>
</template>

<style scoped>

    .main_wrapper {
        padding-right: 20px;
        display: flex;
        justify-content: space-between;
    }

    .table_wrapper {
        width: 65%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table tr {
        background-color: #f7fafc;
        border-bottom: 2px solid #C4C4C4;
    }

    table td {
        padding: 15px 10px;
        text-align: center;
        font-size: 16px;
        color: #6E6E6F;
    }

    table th {
        padding: 5px;
        background-color: #cbd5e0;
        color: #6E6E6F;
        font-size: 12px;
        font-weight: normal;
        text-transform: uppercase;
    }

    .product_row {
        cursor: pointer;
    }

    .product_row:hover {
        background-color: #dbeaf5;
    }

    .product_row:hover > td {
        color: #0FC5FF;
    }

    .paginate_list {
        margin: 10px auto;
        display: flex;
        justify-content: center;
        column-gap: 5px;
    }

    .paginate_link {
        display: block;
        padding: 5px;
    }

    .paginate_link:hover {
        background-color: #dbeaf5;
    }

    .sort_list {
        display: flex;
        flex-direction: column;
        flex-wrap: wrap;
    }

    .sort_link {
        font-size: 10px;
    }

    .sort_link:hover {
        color: salmon;
    }

    .filter_list {
        margin-top: 15px;
    }

    .active {
        color: #ED1C24;
        cursor: none;
        pointer-events: none;

    }

    .disabled {
        cursor: none;
        pointer-events: none;
        color: #a0aec0;
    }

    .success_response {
        color: lightsalmon;
    }

    .add_button_wrapper {
        margin: 25px 0;
        width: 150px;
    }

    .overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
        z-index: 1;
    }

</style>
