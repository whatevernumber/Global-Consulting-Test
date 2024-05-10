<script setup>

import {Link, useForm, Head} from "@inertiajs/vue3";

import BlueButton from "@/Pages/Button/BlueButton.vue";

const form = useForm({
    email: '',
    password: ''
})

</script>

<template>
    <Head title="Логин"/>
    <div class="form_wrapper">
        <form class='login_form' @submit.prevent="form.post('/login')">
            <div>
                <label class="login_label">
                    <span class="form_title">Электронная почта</span>
                    <input :class="['login_input', { input_error: form.errors.email }]" name="email" required
                           v-model="form.email">
                </label>
                <div class='validation_error' v-if="form.errors.email">{{ form.errors.email[0] }}</div>
            </div>
            <div>
                <label class="login_label">
                    <span class="form_title">Пароль</span>
                    <input :class="['login_input', { input_error: form.errors.password }]" type="password"
                           name="password" required v-model="form.password">
                </label>
                <div class='validation_error' v-if="form.errors.password">{{ form.errors.password[0] }}</div>
            </div>
            <blue-button :name="'Войти'" :type="'submit'"/>
        </form>
        <p class="registration_text">Нет учётной записи?
            <Link class='registration_link' href="/registration">Зарегистрироваться</Link>
        </p>
    </div>
</template>


<style scoped>
.form_wrapper {
    margin: 100px auto;
    width: 400px;
    height: 300px;
}

form {
    display: flex;
    flex-direction: column;
    row-gap: 15px;
    align-items: center;
}

.form_title {
    text-transform: lowercase;
}

.login_label {
    display: flex;
    flex-direction: column;
    row-gap: 5px;
    align-items: center;
}

.login_input {
    padding: 5px;
    min-width: 300px;
    border: 2px solid #718096;
    border-radius: 5px;
}

.registration_text {
    font-size: 12px;
    margin-top: 15px;
    text-align: center;
}

.registration_link {
    color: #ED1C24;
}

.registration_link:hover {
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
