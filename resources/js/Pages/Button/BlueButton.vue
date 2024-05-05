<script setup>
    const props = defineProps(['name', 'type']);

</script>

<template>
    <button class='button' :type="props.type ?? null">
        {{ name }}
    </button>
</template>

<style scoped>

    .button {
        width: 136px;
        padding: 10px 5px;
        text-align: center;
        border-radius: 5px;
        color: #ffffff;
        background-color: #0FC5FF;
    }

    .button:hover {
        opacity: 80%;
    }

</style>
