<template>
    <div>
        <div class="form-search">
            <div class="input-group">
                <span class="input-group-prepend">
                    <div class="input-group-text bg-transparent border-right-0">
                        <i class="fa fa-search"></i>
                    </div>
                </span>
                <input
                    v-on:keyup.enter="searchData"
                    class="form-control py-2 border-left-0 border"
                    type="search"
                    v-model="search"
                    placeholder="Search"
                    id="example-search-input"
                />
            </div>
            <div class="dropdown topic">
                <button
                    class="btn dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    Topic
                </button>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                    <div v-for="(category, index) in categories"  :id="category.id" class="form-check">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            :value="category.id"
                            v-model="selectedCategories"
                            :id="category.name"
                        />
                        <label  class="form-check-label" :for="category.name"
                        >{{  category.name }}</label
                        >
                    </div>

                </div>
            </div>
            <div class="dropdown sort">
                <button
                    class="btn  dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    Sort
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div class="form-check">
                        <input
                            type="radio"
                            class="form-check-input"
                            v-model="sortBy"
                            value="popular"

                            id="popular"
                        />
                        <label class="form-check-label" for="popular"
                        >Popular</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                            type="radio"
                            class="form-check-input"
                            value="nameAsc"
                            v-model="sortBy"
                            id="nameAsc"
                        />
                        <label class="form-check-label" for="nameAsc"
                        >Name, A-Z</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                            type="radio"
                            class="form-check-input"
                            id="nameDesc"
                            value="nameDesc"

                            v-model="sortBy"

                        />
                        <label class="form-check-label" for="nameDesc"
                        >Name, Z-A</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                            type="radio"
                            class="form-check-input"
                            id="newest"
                            value="newest"
                            v-model="sortBy"

                        />
                        <label class="form-check-label" for="newest"
                        >Newest</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                            type="radio"
                            class="form-check-input"
                            v-model="sortBy"
                            value="oldest"

                            id="oldest"
                        />
                        <label class="form-check-label" for="oldest"
                        >Oldest</label
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="modules">
            <loading :active.sync="lessonsLoading" :can-cancel="true">
            </loading>
<!--            <h3>Select a module to get started.</h3>-->
            <div class="d-grid-content">
                <a
                    v-for="(quiz, i) in formatedQuizzes"
                    :key="i"
                    :href="`quizzes/${quiz.id}`"
                    class="module">
                    <div class="image">
                        <img :src="quiz.lesson.cover_image" alt="" />
                    </div>
                    <span class="heading-ternary">{{ quiz.title }}</span>
                </a>
            </div>
            <a @click="searchData(currentPage + 1)" class="default-btn">{{trans.get('strings.Show more')}}</a>
        </div>
    </div>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import {Helper} from '../mixins/mixin';

export default {
    props: ["quizzes"],
    mixins: [Helper],


    data: () => ({
        lessonsLoading: false,
        formatedQuizzes: [],
        search: "",
        currentPage: 1,
        lastPage: 1
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
                this.searchData();
            }, 800);
        }
    },
    methods: {
        searchData(page) {
            this.lessonsLoading = true;
            let url = '';
            if (!page) {
                url = `/quizzes?`;
            } else {
                url = `/quizzes?page=${page}&`;
                this.currentPage = page;

            }
            if (this.search) {
                url += `search=${this.search}&`
            }
            if (this.packedSelectedCategories) {
                url += `categories=${this.packedSelectedCategories}&`
            }
            if (this.sortBy) {
                url += `sortBy=${this.sortBy}`
            }
            axios
                .get(url)
                .then(response => {
                    if (page) {
                        console.log(response.data.data)
                        this.formatedQuizzes.push(...response.data.data)

                    } else {
                        this.formatedQuizzes = response.data.data;

                    }
                    console.log(this.formatedQuizzes);
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
        this.formatedQuizzes = this.quizzes.data;
        this.getCategories()
        this.lastPage = this.quizzes.last_page;

    }
};
</script>
