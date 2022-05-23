<template>
    <div id="app" class="fluid container mt-5">
        <div class="form-search" style=" max-width: 100%;
    margin-bottom: 2rem;
">
            <div class="w-100 mt-5">
            <input
                class="form-control mt-4"
                type="text"
                v-model="title"
                placeholder="title"
            />
            <textarea
              style="height: 16rem;"
                class="form-control mt-4"
                type="text"
                v-model="description"
                placeholder="description"
            />

            <input
                class="form-control  mt-4"
                type="text"
                v-model="instructions"
                placeholder="instructions"
            />
            <input
                type="text"
                class="form-control  mt-4"
                v-model="additional_info"
                placeholder="Additional info"
            />
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
            <div class="col-md-6 p-x-0 m-x-0">
                <h3 style="color: #777">Module</h3>
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
                <h3 style="color: #777">Lesson</h3>
                <div class="border-box m-x-0">
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
        <button class="gold-btn-transparent  float-left mt-4" @click="validateForm">
                Create
            </button>
         <div v-if="showSuccess">
                            <p  class="success-show">
                                    <b>Successfully Added!</b>

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
import "vue2-dropzone/dist/vue2Dropzone.min.css";

export default {
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
        getLessons() {
            this.lessonsLoading = true;
            axios
                .get(`/lessons?all=true`)
                .then(response => {
                    response.data.map((item, index) => {
                        return { name, order: index + 1, fixed: false };
                    });
                    this.lessons = response.data;
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
                this.title &&
                this.description &&
                    this.ids.length
            ) {
                return true;
            }

            this.errors = [];

            if (!this.title) {
                this.errors.push("Title is required.");
            }
            if (!this.description) {
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

            // let formattedPayload = {}
            var formData = new FormData();
            let payload = {
                lesson_ids: this.ids,
                title: this.title,
                description: this.description,
                instructions: this.instructions,
                additional_info: this.additional_info,
                category_id: this.category_id,
                    file:  this.$refs.myVueDropzone.getAcceptedFiles()[0],
            }
            if (!payload.file) {
                alert('Please choose image file');
                return;
            }
            for (var key in payload) {
                if (payload[key]) {
                    formData.append(key, payload[key]);
                }
            }

            // for (let key in payload) {
            //     if (payload[key]) {
            //         formattedPayload[key] = payload[key]
            //     }
            // }

            this.lessonsLoading = true;
            axios
                .post(`/api/create-module`, formData)
                .then(response => {
                    this.showSuccess = true;
                     setTimeout(() => {
                    this.showSuccess = false;
                }, 2000);

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
<style lang="scss">
.flip-list-move {
    transition: transform 0.5s;
}
.no-move {
    transition: transform 0s;
}
.ghost {
    opacity: 0.5;
    background: #c8ebfb;
}
.list-group {
    min-height: 1000px;
}
.list-group-item {
    cursor: move;
    margin: 10px 0;
    font-size: 14px;
}
.list-group-item + .list-group-item {
    border-top-width: 1px;
}
.list-group-item i {
    cursor: pointer;
}

#app .logo {
    text-align: center;
}
.border-box {
   overflow-y: auto;
    border: 1px solid #ced4da;
    padding: 10px;
    margin: 0 10px;
    height: 38.5rem;
}
.form-search label{
    font-size: 16px !important;
        color: #777;
        text-align: left;
}
.form-search .dropzone.dz-clickable .dz-message *{
     font-size: 16px;
}
.form-search .vue-dropzone>.dz-preview .dz-image{
width: 100px;
    height: 100px;
}
.form-search .dropzone .dz-preview.dz-image-preview{
    margin: 0;
}
.form-search .dropzone .dz-preview .dz-image img{
    width: 100px;
    height: 100px;
}
</style>
