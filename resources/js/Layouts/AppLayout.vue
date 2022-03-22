<template>
    <Nav/>
    <b-container>

        <slot/>
    </b-container>
</template>

<script>
import Nav from "../Shared/Nav";

export default {
    name: "Quizzy",
    components: {Nav}
}
</script>

<style scoped>

</style>
