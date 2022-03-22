<template>
    <AppLayout>
        <b-form @submit="submit">
            <b-form-group id="input-group-first-name" label="Your First Name:" label-for="input-first-name">
                <b-form-input
                    id="input-first-name"
                    v-model="form.first_name"
                    placeholder="Enter first name"
                    required
                ></b-form-input>
                <b-form-invalid-feedback
                    class="text-danger"
                    v-if="$page.props.errors.first_name"
                    v-text="$page.props.errors.first_name"
                >
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group id="input-group-last-name" label="Your Last Name:" label-for="input-last-name">
                <b-form-input
                    id="input-last-name"
                    v-model="form.last_name"
                    placeholder="Enter last name"
                    required
                ></b-form-input>
                <b-form-invalid-feedback
                    class="text-danger"
                    v-if="$page.props.errors.last_name"
                    v-text="$page.props.errors.last_name"
                >
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group
                id="input-group-email"
                label="Email address:"
                label-for="input-email"
            >
                <b-form-input
                    id="input-email"
                    v-model="form.email"
                    type="email"
                    placeholder="Enter email"
                    required
                ></b-form-input>
                <b-form-invalid-feedback
                    class="text-danger"
                    v-if="$page.props.errors.email"
                    v-text="$page.props.errors.email"
                >
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-group
                label="Quiz Type"
            >
                <b-form-radio-group
                    v-model="form.type"
                    :options="types"
                ></b-form-radio-group>
            </b-form-group>
            <b-button block type="submit" size="lg" variant="primary" :disabled="form.processing">Start</b-button>
        </b-form>
    </AppLayout>
</template>

<script setup>
import AppLayout from "../Layouts/AppLayout";
import {useForm} from "@inertiajs/inertia-vue3";

let form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    type: 'binary'
});

let submit = () => {
    let response = form.post('quizzes');
    console.log(response);
}

</script>
<script>
export default {
    data() {
        return {
            types: [
                { text: 'Binary', value: 'binary'},
                { text: 'Multi Answer', value: 'multi'},
            ],
        }
    }
}
</script>
<style scoped>

</style>
