<script setup>
import ModalWrapper from "@/Pages/Modals/ModalWrapper.vue";
import BlueButton from "@/Pages/Button/BlueButton.vue";

const emit = defineEmits(['close_success']);

</script>

<template>
    <modal-wrapper>
        <div class="message_wrapper">
            <p class="success_text">Изменения успешно сохранены</p>
            <blue-button :name="'Хорошо'" @click="$emit('close_success')"/>
        </div>
    </modal-wrapper>
</template>

<style scoped>

.message_wrapper {
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.success_text {
    margin-bottom: 20px;
    font-size: 16px;
    color: #ffffff;
}
</style>
