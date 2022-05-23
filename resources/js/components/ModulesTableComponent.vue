<template>
    <div>
        <loading :active.sync="lessonsLoading" :can-cancel="true"> </loading>

        <div class="d-flex justify-space-between create-module-page">
            <h1 class="heading-primary">
                Modules
            </h1>
            <div class="input-group">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-search"></i>
                    </div>
                </span>
                <input
                    v-on:keyup.enter="searchModules"
                    class="form-control py-2 border-left-0 border"
                    type="search"
                    v-model="search"
                    placeholder="Search"
                    id="example-search-input"
                />
            </div>
        </div>
        <div v-for="(lesson, i) in lessons" :key="i" class="lessons">
            <div class="lesson d-flex justify-space-between">
                <span class="bold">
                    {{ lesson.title }} /
                    <span>
                        {{ lesson.lessons_count }}
                        {{
                            lesson.lessons_count == 1 ? "Lesson" : "Lessons"
                        }}</span
                    >
                </span>
                <a :href="`/admin/modules/update-module/${lesson.id}`">Modify</a>

            </div>
            <div class="d-flex justify-space-between">
                <div class="status online">
                    <span class="dot green"></span>
                    Online
                </div>
                <div class="date">
                    <span
                        >Created on
                        {{
                            new Date(lesson.created_at)
                                .toLocaleString()
                                .slice(0, 10)
                        }}
                        | Last Modified on
                        {{
                            new Date(lesson.updated_at)
                                .toLocaleString()
                                .slice(0, 10)
                        }}
                    </span
                    >
                </div>
            </div>
        </div>
        <!-- <div class="lessons">
            <div class="lesson d-flex justify-space-between">
                <span class="bold"> Asthma / <span> 10 Lessons</span> </span>
                <a href="/admin/modules/1/lessons">Modify</a>
            </div>
            <div class="d-flex justify-space-between">
                <div class="status offline">
                    <span class="dot red"></span>
                    Offline
                </div>
                <div class="date">
                    <span
                        >Created on 10/30/2020 | Last Modified on
                        01/24/2021</span
                    >
                </div>
            </div>
        </div> -->
    </div>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    // props: ["results"],
    data: () => ({
        lessonsLoading: false,
        showError: false,
        results: [],
        lessons: [],
        search: ""
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
                this.searchModules();
            }, 800);
        }
    },
    methods: {
        searchModules () {
            this.lessonsLoading = true;
            axios
                .get(`/api/module-with-lesson?search=${this.search}`)
                .then(response => {
                    this.lessons = response.data;
                 })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.lessonsLoading = false;
                });
        },
        deleteModal(index) {
            this.showError = true;
        },
        deleteItem(index) {
            this.results.splice(index, 1);
            this.showError = false;
        },
        getLessons() {
            this.lessonsLoading = true;
            axios
                .get(`/api/module-with-lesson`)
                .then(response => {
                    this.lessons = response.data;
                    console.log(this.lessons, "less");
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.lessonsLoading = false;
                });
        }
    },
    created() {
        this.getLessons();
    }
};
</script>
