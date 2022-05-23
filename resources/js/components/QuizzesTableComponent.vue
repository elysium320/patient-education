<template>
    <table>
        <tr>
            <th>Title</th>
            <th>Lesson Title</th>
            <th>Lesson Description</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <tr :key="index" v-for="(result, index) in results">
            <td>{{ result.title }}</td>
            <td v-if="result.lession != null">{{ result.lession.title }}</td>
            <td v-else>No Data</td>
            <td v-if="result.lession != null">
                {{ result.lession.description }}
            </td>
            <td v-else>
                No data
            </td>

            <td v-if="result.lession != null">
                {{
                    new Date(result.lession.created_at)
                        .toLocaleString()
                        .slice(0, 10)
                }}
            </td>
            <td v-else>
                No data
            </td>
            <td>
                <div @click="deleteModal(result.id)">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </div>
            </td>
        </tr>
    </table>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    data: () => ({
        lessonsLoading: false,
        showError: false,
        results: []
    }),
    components: {
        Loading
    },
    computed: {},
    watch: {
        search() {
            if (this.timer) {
                clearTimeout(this.timer);
                this.timer = null;
            }
            this.timer = setTimeout(() => {
                this.searchLessons();
            }, 800);
        }
    },
    methods: {
        deleteModal(id) {
            console.log(id);

            this.showError = true;
            confirm("Are you sure you want to delete this item?") &&
                axios
                    .delete(`/api/delete-quiz/${id}`)
                    .then(response => {
                        // this.results.splice(index, 1);
                        this.getQuizzes();
                    })
                    .catch(err => {
                        console.log(err);
                    });
        },
        getQuizzes() {
            axios
                .get(`/api/quizzes`)
                .then(response => {
                    this.results = response.data.data;
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    created() {
        this.getQuizzes();
    }
};
</script>
