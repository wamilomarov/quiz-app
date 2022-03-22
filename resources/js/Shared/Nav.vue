<template>
    <b-nav class="mb-5 pb-3 pt-3" id="b-nav">
        <h2 class="ms-3">QUIZZY</h2>

            <Link as="button" class="btn btn-light ms-auto me-3">New Quiz</Link>

            <Link as="button" class="btn btn-light me-3">Leaders Board</Link>
    </b-nav>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "Nav",
    components: {
        Link
    }
}
</script>

<style scoped>
#b-nav {
    background-color: #bacbe6;
}
</style>
