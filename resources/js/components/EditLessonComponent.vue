<template>
    <div>
        <loading :active.sync="lessonsLoading" :can-cancel="true"> </loading>
        <div class="d-flex justify-space-between create-module-page">
            <h1 v-if="module" class="heading-primary">
                {{ module.title }}
            </h1>
            <h1 v-else class="heading-primary">All Lessons</h1>
            <div style="width: 18.69rem" class="input-group">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-search"></i>
                    </div>
                </span>
                <input
                    v-on:keyup.enter="searchLessons"
                    class="form-control py-2 border-left-0 border"
                    type="search"
                    v-model="search"
                    placeholder="Search"
                    id="example-search-input"
                />
            </div>
        </div>
        <div :key="i" v-for="(item, i) in formatedLessons" class="lessons">
            <div class="lesson-edit d-flex justify-space-between">
                <span class="bold">
                    <!-- <span
                        ><i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        <i
                            style="margin-left: -2px;"
                            class="fa fa-ellipsis-v"
                            aria-hidden="true"
                        ></i
                    ></span> -->
                    Lessson {{ i + 1 }}: {{ item.title }}
                </span>
                <div>
                    <a :href="`/admin/update-lesson/${item.id}`">Modify</a>
                    <a class="delete-lesson" @click="deleteLesson(item.id)"
                        >Delete</a
                    >
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    props: ["module", "lessons"],
    data: () => ({
        lessonsLoading: false,
        showError: false,
        results: [],
        formatedLessons: [],
        search: "",
        lessonsLoading: false,
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
                this.searchLessons();
            }, 800);
        }
    },
    methods: {
        searchLessons() {
            this.lessonsLoading = true;
            axios
                .get(`/lessons?search=${this.search}`)
                .then(response => {
                    this.formatedLessons = response.data.data;
                    console.log(this.formatedLessons);
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.lessonsLoading = false;
                });
        },
        deleteLesson(id) {
            confirm("Are you sure you want to delete this lesson?") &&
                axios
                    .delete(`/api/delete-lesson/${id}`)
                    .then(response => {
                        // this.results.splice(index, 1);
                        window.location = "/admin/lessons";
                    })
                    .catch(err => {
                        console.log(err);
                        alert("Something went wrong!");
                    });
        },
        deleteModal(index) {
            this.showError = true;
        },
        deleteItem(index) {
            this.results.splice(index, 1);
            this.showError = false;
        }
    },
    created() {
        this.formatedLessons = this.lessons;
    }
};
</script>
