// define a mixin object
export const Helper = {
    data() {
      return {
          categories: [],
          selectedCategories: [],
          sortBy: '',
          categoryTimer: null
      }
    },
    computed: {
        packedSelectedCategories() {
            if (!this.selectedCategories.length) {
                return ''
            }

            return this.selectedCategories.join(',')
        }
    },
    methods: {
        getCategories(page) {
            this.lessonsLoading = true;
            let url = '/api/categories';

            axios
                .get(url)
                .then(response => {
                    this.categories = response.data
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.lessonsLoading = false;
                });
        }

    },
    watch: {
        selectedCategories() {
            if (this.categoryTimer) {
                clearTimeout(this.categoryTimer);
                this.categoryTimer = null;
            }
            this.categoryTimer = setTimeout(() => {
                this.searchData();
            }, 500);
        },
        sortBy() {
            if (this.categoryTimer) {
                clearTimeout(this.categoryTimer);
                this.categoryTimer = null;
            }
            this.categoryTimer = setTimeout(() => {
                this.searchData();
            }, 500);
        },

    },
}
