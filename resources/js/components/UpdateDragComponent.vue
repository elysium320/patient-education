<template>
    <div id="app" class="fluid container mt-5">
        <div class="form-search" style=" max-width: 100%; margin-bottom: 2rem;">
             <div class="w-100 mt-5">
            <input
                class="form-control mt-4"
                type="text"
                v-model="formattedModule.title"
                placeholder="title"
            />
            <textarea
                style="height: 16rem;"
                class="form-control mt-4"
                type="text"
                v-model="formattedModule.description"
                placeholder="description"
            />

            <input
                class="form-control mt-4"
                type="text"
                v-model="formattedModule.instructions"
                placeholder="instructions"
            />
            <input
                type="text"
                class="form-control mt-4"
                v-model="formattedModule.additional_info"
                placeholder="Additional info"
            />
            <div class="uploaded-img">
                 <img  :src="this.formattedModule.profile" alt="">
            </div>
                 <div style="text-align: left;" class=" mt-4">
                     <label for="">Upload Cover Photo</label>
                     <vue-dropzone
                         ref="myVueDropzone"
                         id="dropzone"
                         v-model="fileImage"
                         :options="dropzoneOptions"
                     ></vue-dropzone>
                 </div>

                </div>

            <div class="d-flex w-100 justify-center mt-4">
                <div class="col-md-6 m-x-0 p-x-0">
                    <h3>Module</h3>
                    <div class="border-box m-x-0">
                        <draggable
                            element="span"
                            v-model="list2"
                            v-bind="dragOptions"
                            :move="onMove"
                        >
                            <transition-group name="no" class="list-group" tag="ul">
                                <li
                                    class="list-group-item"
                                    v-for="element in list2"
                                    :key="element.id"
                                >
                                    <i
                                        :class="
                                            element.fixed
                                                ? 'fa fa-anchor'
                                                : 'glyphicon glyphicon-pushpin'
                                        "
                                        @click="element.fixed = !element.fixed"
                                        aria-hidden="true"
                                    ></i>
                                    {{ element.title }}
                                    <span class="badge">{{ element.order }}</span>
                                </li>
                            </transition-group>
                        </draggable>
                    </div>
                </div>

                <div class="col-md-6 m-x-0">
                    <h3>Lesson</h3>
                    <div class="border-box m-x-0 ">
                        <draggable
                            class="list-group"
                            tag="ul"
                            v-model="lessons"
                            v-bind="dragOptions"
                            :move="onMove"
                            @start="isDragging = true"
                            @end="isDragging = false"
                        >
                            <transition-group type="transition" :name="'flip-list'">
                                <li
                                    class="list-group-item"
                                    v-for="element in lessons"
                                    :key="element.id"
                                >
                                    <i
                                        :class="
                                            element.fixed
                                                ? 'fa fa-anchor'
                                                : 'glyphicon glyphicon-pushpin'
                                        "
                                        @click="element.fixed = !element.fixed"
                                        aria-hidden="true"
                                    ></i>
                                    {{ element.title }}
                                    <span class="badge">{{ element.order }}</span>
                                </li>
                            </transition-group>
                        </draggable>
                    </div>
                </div>
            </div>

        </div>
          <div class="d-flex mt-4">
            <button class="default-btn mr-5" @click="validateForm">
                UPDATE
            </button>

            <button class="gold-btn-transparent" @click="deleteModule">
                DELETE
            </button>
            </div>
         <div v-if="showSuccess">
                            <p  class="success-show">
                                    <b>Successfully Updated!</b>

                            </p>
                        </div>
          <div v-if="showError">
                    <p style="height: 150px" class="error-show">
                        <b>Please correct the following error(s):</b>
                        <ul>
                            <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
                        </ul>
                    </p>
                </div>
    </div>

</template>
<script>
import draggable from "vuedraggable";
import vue2Dropzone from "vue2-dropzone";

export default {
    props: ['module'],
    components: {
        draggable,
        vueDropzone: vue2Dropzone,

    },
    data() {
        return {
            fileImage: null,
            dropzoneOptions: {
                url: "https://httpbin.org/post",
                thumbnailWidth: 150,
                maxFilesize: 5,
                maxFiles: 1,
                headers: {"My-Awesome-Header": "header value"}
            },
            formattedModule: {lessons: []},
            showError: false,
            errors: [],
            title: null,
            description: null,
            instructions: null,
            additional_info: null,
            category_id: 1,
            showSuccess: false,
            lessonsLoading: false,
            lessons: [],
            list2: [],
            editable: true,
            isDragging: false,
            delayedDragging: false
        };
    },
    methods: {
        deleteModule() {
            confirm("Are you sure you want to delete this module?") &&
            axios
                .post(`/api/delete-module/${this.module.id}`)
                .then(response => {
                    // this.results.splice(index, 1);
                     window.location = '/admin/modules';
                })
                .catch(err => {
                    console.log(err);
                    alert('Something went wrong!')
                });
        },
        getLessons() {
            this.lessonsLoading = true;
            axios
                .get(`/lessons?all=true`)
                .then(response => {
                    response.data.map((item, index) => {
                        return { name, order: index + 1, fixed: false };
                    });
                    this.lessons = response.data.filter((item, i) => {
                        if (this.list2.findIndex(x => x.id === item.id) === -1) {
                            return item;
                        }
                    });
                     console.log(this.lessons);
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.lessonsLoading = false;
                });
        },
         checkForm: function(e) {
            if (
                this.formattedModule.title &&
                this.formattedModule.description &&
                    this.ids.length
            ) {
                return true;
            }

            this.errors = [];

            if (!this.formattedModule.title) {
                this.errors.push("Title is required.");
            }
            if (!this.formattedModule.description) {
                this.errors.push("Description is required.");
            }

            if (!this.ids.length) {
                this.errors.push("You need to add some lessons");
            }

            return false;
        },
        validateForm(){
             if (this.checkForm()) {
                this.storeModule();
            }
        },
        storeModule() {

            var formData = new FormData();

            let payload = {
                id: this.module.id,
                lesson_ids: this.ids,
                title: this.formattedModule.title,
                description: this.formattedModule.description,
                instructions: this.formattedModule.instructions,
                additional_info: this.formattedModule.additional_info,
                category_id: this.formattedModule.category_id,
                file:  this.$refs.myVueDropzone.getAcceptedFiles()[0],

            }


            for (var key in payload) {
                if (payload[key]) {
                    formData.append(key, payload[key]);
                }
            }

            this.lessonsLoading = true;
            axios
                .post(`/api/update-module`, formData)
                .then(response => {
                    this.showSuccess = true;
                     setTimeout(() => {
                    this.showSuccess = false;
                    location.reload();
                }, 1500);

                })
                .catch(err => {
                    console.log(err.response, err.response.data);
                    if (err.response && err.response.data) {
                        alert (err.response.data.message)
                    }

                })
                .finally(() => {
                    this.lessonsLoading = false;
                });
        },
        orderList() {
            this.lessons = this.lessons.sort((one, two) => {
                return one.order - two.order;
            });
        },
        onMove({ relatedContext, draggedContext }) {
            const relatedElement = relatedContext.element;
            const draggedElement = draggedContext.element;
            return (
                (!relatedElement || !relatedElement.fixed) &&
                !draggedElement.fixed
            );
        }
    },
    created() {
        this.formattedModule = this.module;
        this.list2 = this.formattedModule.lessons.map(item => item)
        this.getLessons();
    },
    computed: {
        ids() {
            let lessonIds = [];
            this.list2.map(item => {
                lessonIds.push(item.id);
            });
            return lessonIds.join(",");
        },
        dragOptions() {
            return {
                animation: 0,
                group: "description",
                disabled: !this.editable,
                ghostClass: "ghost"
            };
        },
        listString() {
            return JSON.stringify(this.lessons, null, 2);
        },
        list2String() {
            return JSON.stringify(this.list2, null, 2);
        }
    },
    watch: {
           errors() {
            if (this.errors.length) {
                this.showError = true;
                setTimeout(() => {
                    this.showError = false;
                }, 2000);
            }
        },
        isDragging(newValue) {
            if (newValue) {
                this.delayedDragging = true;
                return;
            }
            this.$nextTick(() => {
                this.delayedDragging = false;
            });
        }
    }
};
</script>

