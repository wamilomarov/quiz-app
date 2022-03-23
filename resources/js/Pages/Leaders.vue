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

    <b-pagination
        v-model="leaders.meta.current_page"
        :total-rows="leaders.meta.total"
        :per-page="leaders.meta.per_page"
    ></b-pagination>
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
    mounted() {
        console.log(this.leaders)
    },
    data() {
        return {
            items: [
                { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
                { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
                { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
                { age: 38, first_name: 'Jami', last_name: 'Carney' }
            ]
        }
    }
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
