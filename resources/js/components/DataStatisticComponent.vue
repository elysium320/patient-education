<template>
    <div>
    <input
      type="text"
      placeholder="Search by Name or Country"
      v-model="filter"
      class="search-input"
    />
    <table>
        <tr>
            <th>Quiz ID</th>
            <th>Name</th>
            <th>Country</th>
            <th>Correct</th>
            <th>Wrong</th>
            <th>Total</th>
            <th>Started At</th>
            <th>Finished At</th>
            <th>Created At</th>
        </tr>
        <tr :key="index" v-for="(result, index) in filteredRows">
            <td>{{ result.id }}</td>
            <td>{{ result.quiz ? result.quiz.title : 'N/A' }}</td>
            <td>{{  result.country }}</td>
            <td>{{  result.total_correct_count }}</td>
            <td>{{ Math.max(0,(result.taken_questions_count - result.total_correct_count)) }}</td>
            <td>{{  result.taken_questions_count }}</td>
            <td>{{  new Date(result.started_at).toLocaleString('en-US', { timeZone: 'America/Los_Angeles' }) }}</td>
            <td>{{  new Date(result.finished_at).toLocaleString('en-US', { timeZone: 'America/Los_Angeles' }) }}</td>
            <td>{{  new Date(result.created_at).toLocaleString('en-US', { timeZone: 'America/Los_Angeles' }) }}</td>

        </tr>

    </table>
    </div>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    props: ["results"],
    data: () => ({
        lessonsLoading: false,
        filter: "",

    }),
    components: {
        Loading
    },
    computed: {
        filteredRows() {
            return this.results.filter((row) => {
                const country = row.country.toString().toLowerCase();
                const name = row.quiz.title.toString().toLowerCase();
                const total_correct_count = row.total_correct_count.toString().toLowerCase();
                const wrong = (Math.max(0,(row.taken_questions_count - row.total_correct_count))).toString();
                const started_at = new Date(row.started_at).toLocaleString('en-US', { timeZone: 'America/Los_Angeles' })
                const finished_at = new Date(row.finished_at).toLocaleString('en-US', { timeZone: 'America/Los_Angeles' });
                const created_at = new Date(row.created_at).toLocaleString('en-US', { timeZone: 'America/Los_Angeles' })

                const searchTerm = this.filter.toLowerCase();

                return (
                country.includes(searchTerm) || name.includes(searchTerm) || total_correct_count.includes(searchTerm) || wrong.includes(searchTerm) || started_at.includes(searchTerm) || finished_at.includes(searchTerm) || created_at.includes(searchTerm)
                );
        });
    },
    },
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

    },
    created() {
        console.log(this.results)
        this.results = this.results.slice(0,100)
    }
};
</script>
<style lang="scss">
.search-input {
    width: 400px;
    height: 40px;
    margin-bottom: 10px;
}
</style>