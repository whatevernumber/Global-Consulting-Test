<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import {reactive, ref} from "vue";

import ModalWrapper from "@/Pages/Modals/ModalWrapper.vue";
import IconButton from "@/Pages/Button/IconButton.vue"
import BlueButton from "@/Pages/Button/BlueButton.vue";

const props = defineProps(['product', 'statuses'])
const emit = defineEmits(['saved', 'close']);

const page = usePage();
const admin = page.props.user.admin; // checks if the user is admin true|false

let inputs = ref(
    []
);

const form = useForm({
    _method: props.product.id ? 'patch' : '',
    article: props.product.article ?? '',
    name: props.product.name ?? '',
    status_id: props.product.status ?? '1',
    data: {},
});

if (props.product.data) {
    JSON.parse(props.product.data).forEach((data) => {
        let entry = {};
        entry['type'] = data.type;
        entry['value'] = data.value;
        inputs.value.push(entry);
    });
}

// Prepares Attributes data
const prepare_json = function () {

    // Clears empty attributes
    inputs.value = inputs.value.filter((el) => {
        return el.value && el.type;
    });

    return JSON.stringify(inputs.value)
}

let path = '/products/create'

// Changes url for updating requests
if (props.product.id) {
    path = '/products/update/' + props.product.id;
}

// Adds new Attribute
const add_new_field = function () {
    inputs.value.push({'type': '', 'value': ''});
}

// Removes an Attribute
const remove_field = function (index) {
    inputs.value.splice(index, 1);
}

</script>

<template>
    <modal-wrapper>
        <div class="form_wrapper">
            <h2 class="header">{{ product.id ? 'Редактировать ' : 'Добавить продукт' }}
                <span v-if="product.name" class="product_name">{{ product.name }}</span>
            </h2>
            <form class='add_form' @submit.prevent="form.transform((data) => ({
                ...data,
               data: prepare_json(),
            }))
            .post(path, {
                onSuccess:  page => {
                    // Emit fires only the there are no validation errors in the props, otherwise it will fire at any response, even
                    // if the validation failed
                    if (Object.keys(page.props.errors).length === 0) {
                        $emit('saved');
                        form.reset()
                    }
                },
            })">
                <div>
                    <label class="form_label">
                        <span class="label_title">Артикул</span>
                        <input v-model="form.article" :disabled="(product.id && !admin )"
                               :class="['input', 'main_input', { input_error: form.errors.article }]" required>
                    </label>
                    <div class='validation_error' v-if="form.errors.article">{{ form.errors.article[0] }}</div>
                </div>
                <div>
                    <label class="form_label">
                        <span class="label_title">Название</span>
                        <input v-model="form.name" :class="['input', 'main_input', { input_error: form.errors.name }]"
                               required>
                    </label>
                    <div class='validation_error' v-if="form.errors.name">{{ form.errors.name[0] }}</div>
                </div>
                <div>
                    <label class="form_label">
                        <span class="label_title">Статус</span>
                        <select v-model="form.status_id" :class="['select', { input_error: form.errors.status_id }]">
                            <option v-for="status in statuses" :value="status.id">
                                {{ status.name }}
                            </option>
                        </select>
                    </label>
                    <div class='validation_error' v-if="form.errors.status_id">{{ form.errors.status_id[0] }}</div>
                </div>
                <div v-if="inputs.length">
                    <h3 class="attributes_header">Атрибуты</h3>
                    <fieldset v-for="(input, index) of inputs" class="attributes_field">
                        <label class="form_label">
                            <span class="label_title">Название</span>
                            <input v-model="input.type" class="input additional_input">
                        </label>
                        <label class="form_label">
                            <span class="label_title">Значение</span>
                            <input v-model="input.value" class="input additional_input">
                        </label>
                        <div class="delete_button_wrapper">
                            <icon-button :type="'delete'" :size="'small'" @click="remove_field(index)"/>
                        </div>
                    </fieldset>
                </div>
                <div class="add_attribute_wrapper">
                    <p class="add_new_button" @click="add_new_field">+ Добавить атрибут</p>
                </div>
                <blue-button :name="product.id ? 'Сохранить' : 'Добавить'" :type="'submit'"/>
            </form>
        </div>
        <icon-button :type="'close'" @click="emit('close')"/>
    </modal-wrapper>
</template>

<style scoped>

.add_form {
    display: flex;
    flex-direction: column;
    row-gap: 15px;
}

.form_label {
    display: flex;
    flex-direction: column;
}

.label_title {
    margin-bottom: 8px;
    font-size: 10px;
    color: #ffffff;
}

input, select {
    width: 470px;
    padding: 5px;
    border-radius: 5px;
}

select {
    font-size: 12px;
    appearance: none;
    outline: none;
    border-bottom: 1px solid #a0aec0;
    background-image: url("/resources/img/svg/dropdown.svg");
    background-repeat: no-repeat;
    background-position: right 0.7rem top 50%;
    background-size: 0.65rem auto;
}

option {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.additional_input {
    width: 219px;
}

.attributes_field {
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.attributes_field:last-of-type {
    margin-bottom: 0;
}

input[disabled] {
    font-weight: bold;
    color: #4a5568;
}

.header,
.attributes_header {
    margin-bottom: 15px;
    font-size: 20px;
    font-weight: bold;
    color: #ffffff;
}

.attributes_header {
    font-size: 14px;
}

.product_name {
    text-transform: uppercase;
}

.add_attribute_wrapper {
    width: 95px;
}

.add_new_button {
    font-size: 10px;
    color: #0FC5FF;
    border-bottom: 1px dashed #0FC5FF;
    cursor: pointer;
}

.add_new_button:hover {
    opacity: 70%;
}

.delete_button_wrapper {
    margin-top: 4%;
}

.validation_error {
    font-size: 14px;
    color: salmon;
    text-transform: lowercase;
}

.input_error {
    border: 2px solid #ED1C24;
}

</style>
