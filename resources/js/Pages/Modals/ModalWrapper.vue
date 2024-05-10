<template>
    <div class="modal">
        <slot></slot>
    </div>
</template>

<style scoped>

.modal {
    z-index: 10;
    position: absolute;
    top: 20%;
    left: 40%;
    width: 550px;
    min-height: 300px;
    padding: 25px 20px;
    background-color: #374050;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

</style>
