<script setup>
    import { router } from '@inertiajs/vue3'
    import ModalWrapper from "@/Pages/Modals/ModalWrapper.vue";
    import IconButton from "@/Pages/Button/IconButton.vue";

    const props = defineProps(['product']);
    const emit = defineEmits(['delete', 'edit', 'close']);

    // Sends delete request
    const delete_product = function () {
        emit('delete');
        router.delete('products/delete/' + props.product.id)
    }

</script>

<template>
    <modal-wrapper>
        <div class="product_card">
            <h2 class="product_title">{{ product.name }}</h2>
            <p class="product_info">
                <span class="label_type">Артикул: </span>
                {{ product.article }}
            </p>
            <p class="product_info">
                <span class="label_type">Название: </span>
                {{ product.article }}
            </p>
            <p class="product_info">
                <span class="label_type">Статус: </span>
                {{ (product.status === 'available' ? 'Доступен' : 'Недоступен' ) }}
            </p>
            <p v-for="data in JSON.parse(product.data)" class="product_info">
                <span class="label_type">{{ data.type }}: </span>
                {{ data.value }}
            </p>
        </div>
        <div class="product_buttons">
            <div class="action_buttons">
                <icon-button :type="'edit'" @click="emit('edit')" />
                <icon-button :type="'delete'" @click="delete_product" />
            </div>
            <icon-button :type="'close'" @click="emit('close')" />
        </div>
    </modal-wrapper>
</template>

<style scoped>

    .product_title {
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 20px;
        color: #ffffff;
        text-transform: uppercase;
    }
    .product_card {
        display: flex;
        flex-direction: column;
    }

    .product_buttons {
        display: flex;
        column-gap: 20px;
        align-items: center;
    }

    .product_info {
        color: #ffffff;
    }

    .action_buttons {
        display: flex;
        column-gap: 10px;
    }

    .label_type {
        margin-right: 15px;
        color: #ffffff;
        opacity: 70%;
    }
</style>
