<template>
    <AppLayout>
        <section v-if="$page.props.quiz.data.submitted_at == null">
            <b-row class="mb-3">
                <b-col>
                    <b-button @click="submit" variant="success" :disabled="form.processing">Complete</b-button>
                    <b-form-invalid-feedback
                        class="text-danger"
                        v-if="$page.props.errors.length > 0"
                        v-text="$page.props.errors[0]"
                    >
                    </b-form-invalid-feedback>
                </b-col>
                <b-col>
                    <h4 class="text-warning">Remaining Time -
                        {{ displayHours }} : {{ displayMinutes }} : {{ displaySeconds }}
                    </h4>
                </b-col>

            </b-row>

            <b-tabs content-class="mt-3">
                <b-tab v-for="(question, index) in quiz.data.questions" :key="index" :title='++index'>
                    <h4 v-html="question.text"></h4>
                    <hr>
                    <b-form-group v-for="answer in question.answers">
                        <b-form-radio v-model="question.selected_answer" :value=answer.id>{{ answer.text }}
                        </b-form-radio>
                    </b-form-group>
                </b-tab>
            </b-tabs>

        </section>
        <section v-else>
            <b-list-group>
                <b-list-group-item>Name: {{ quiz.data.first_name }} {{ quiz.data.last_name }}</b-list-group-item>
                <b-list-group-item>Email: {{ quiz.data.email }}</b-list-group-item>
                <b-list-group-item>Duration: {{ quiz.data.duration }}</b-list-group-item>
                <b-list-group-item>Total score: {{ quiz.data.total_score }}</b-list-group-item>
                <b-list-group-item>Unanswered questions: {{ quiz.data.unanswered_count }}</b-list-group-item>
            </b-list-group>
            <Link href="/" class="btn btn-primary mt-3">Restart</Link>


        </section>

    </AppLayout>
</template>

<script>
import AppLayout from "../Layouts/AppLayout";
import {Link} from "@inertiajs/inertia-vue3";
import {useForm} from "@inertiajs/inertia-vue3";
import moment from "moment";

export default {
    name: "Quiz",
    props: {
        quiz: {
            data: {
                id: Number,
                uuid: String,
                email: String,
                first_name: String,
                submitted_at: String,
                duration: String,
                last_name: String,
                total_score: Number,
                unanswered_count: Number,
                created_at: String,
                questions: [
                    {
                        id: Number,
                        answers: [
                            {
                                id: Number,
                                text: String
                            }
                        ],
                        text: String,
                    }
                ]
            }
        }
    },
    mounted() {
        this.showRemaining();
    },
    setup(props) {
        let form = useForm({
            answers: []
        });

        let submit = () => {
            props.quiz.data.questions.forEach(function (question) {
                if (question.selected_answer) {
                    form.answers.push({
                        question_id: question.id,
                        answer_id: question.selected_answer
                    });
                }
            });

            form.post("/quizzes/" + props.quiz.data.uuid);
        }

        return {form, submit};
    },
    data() {
        return {
            displayHours: '00',
            displayMinutes: '00',
            displaySeconds: '00',
        }
    },
    methods: {
        showRemaining() {
            const timer = setInterval(() => {
                let _seconds = 1000;
                let _minutes = _seconds * 60;
                let _hours = _minutes * 60;

                const now = moment();
                const end = moment(this.quiz.data.created_at).add(5, 'm');
                const distance = end.diff(now, 'ms', true);

                if (distance <= 0) {
                    clearInterval(timer);
                    this.submit();
                    return;
                }
                const hours = Math.floor(distance / _hours);
                const minutes = Math.floor((distance % _hours) / _minutes);
                const seconds = Math.floor((distance % _minutes) / _seconds);
                this.displayHours = hours < 10 ? "0" + hours : hours;
                this.displayMinutes = minutes < 10 ? "0" + minutes : minutes;
                this.displaySeconds = seconds < 10 ? "0" + seconds : seconds;
            }, 1000);
        }
    },
    components: {AppLayout, Link}
}
</script>

<style scoped>

</style>
