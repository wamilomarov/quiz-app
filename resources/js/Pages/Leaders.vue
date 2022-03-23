<template>
    <AppLayout>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Score</th>
                <th>Duration</th>
            </tr>
            <tr v-for="leader in leaders.data">
                <td>{{leader.name}}</td>
                <td>{{leader.email}}</td>
                <td>{{leader.total_score}}</td>
                <td>{{leader.duration}}</td>
            </tr>
        </table>
    </AppLayout>
</template>

<script>
import AppLayout from "../Layouts/AppLayout";
export default {
    name: "Leaders",
    props: {
        leaders: Object
    },
    components: {AppLayout},
}
</script>

<style scoped>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 2em;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
