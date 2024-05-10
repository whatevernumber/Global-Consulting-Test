<script setup>

import {useForm} from "@inertiajs/vue3";
import {Link, Head} from "@inertiajs/vue3";

import BlueButton from "@/Pages/Button/BlueButton.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
});

</script>

<template>
    <Head title="Регистрация"/>
    <div class="form_wrapper">
        <form class='registration_form' @submit.prevent="form.post('/register')">
            <div>
                <label class="registration_label">
                    <span class="form_title">Имя пользователя</span>
                    <input :class="['registration_input', { input_error: form.errors.name }]" name="name" required
                           v-model="form.name">
                </label>
                <div class='validation_error' v-if="form.errors.name">{{ form.errors.name[0] }}</div>
            </div>
            <div>
                <label class="registration_label">
                    <span class="form_title">Электронная почта</span>
                    <input :class="['registration_input', { input_error: form.errors.email }]" type="email" name="email"
                           required v-model="form.email">
                </label>
                <div class='validation_error' v-if="form.errors.email">{{ form.errors.email[0] }}</div>
            </div>
            <div>
                <label class="registration_label">
                    <span class="form_title">Пароль</span>
                    <input class='registration_input'
                           :class="['registration_input', { input_error: form.errors.password }]" type="password"
                           name="password" required v-model="form.password">
                </label>
                <div class='validation_error' v-if="form.errors.password">{{ form.errors.password[0] }}</div>
            </div>
            <div>
                <label class="registration_label">
                    <span class="form_title">Повторите пароль</span>
                    <input class='registration_input' type="password" name="password_confirmation" required
                           v-model="form.password_confirmation">
                </label>
                <div class='validation_error'
                     :class="['registration_input', { input_error: form.errors.password_confirmation }]"
                     v-if="form.errors.password_confirmation">{{ form.errors.password_confirmation }}
                </div>
            </div>
            <blue-button :name="'Зарегистрироваться'" :type="'submit'"/>
        </form>
        <p class="login_text">Есть учётная запись?
            <Link class='login_link' href="/login">Войти</Link>
        </p>
    </div>
</template>

<style scoped>

.form_wrapper {
    margin: 100px auto;
    width: 400px;
    height: 300px;
}

.form_title {
    text-transform: lowercase;
}

.registration_form {
    padding: 5px;
    display: flex;
    flex-direction: column;
    row-gap: 15px;
    align-items: center;
}

.registration_label {
    display: flex;
    flex-direction: column;
    row-gap: 5px;
    align-items: center;
}

.registration_input {
    padding: 5px;
    min-width: 300px;
    border: 2px solid #718096;
    border-radius: 5px;
}

.login_text {
    font-size: 12px;
    margin-top: 15px;
    text-align: center;
}

.login_link {
    color: #ED1C24;
}

.login_link:hover {
    color: #4a5568;
}

.input_error {
    border: 2px solid #ED1C24;
}

.validation_error {
    font-size: 14px;
    color: salmon;
    text-transform: lowercase;
}
</style>
