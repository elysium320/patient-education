<template>
    <div>
        <div class="create-module">
            <div class="indicators">
                <a class="indicator">
                    <span>
                        Description & Details
                    </span>
                    <div
                        class="line"
                        :class="{
                            active: this.currentStep == 1,
                            filled: this.currentStep > 1
                        }"
                    ></div>
                </a>
                <a class="indicator">
                    <span>
                        Video & Images
                    </span>
                    <div
                        class="line"
                        :class="{
                            active: this.currentStep == 2,
                            filled: this.currentStep > 2
                        }"
                    ></div>
                </a>
                <a class="indicator">
                    <span>
                        Quiz Questions & Answers
                    </span>
                    <div
                        class="line"
                        :class="{
                            active: this.currentStep == 3,
                            filled: this.currentStep > 3
                        }"
                    ></div>
                </a>
                <a class="indicator">
                    <span>
                        Review & Complete
                    </span>
                    <div
                        class="line"
                        :class="{
                            active: this.currentStep == 4,
                            filled: this.currentStep > 4
                        }"
                    ></div>
                </a>
            </div>
            <div v-if="currentStep == 1" class="module-holder">
                <loading :active.sync="step1Loading" :can-cancel="true">
                </loading>

                <h3 class="module-heading">
                    Add Details & Descriptions
                </h3>
                <form role="form" data-toggle="validator">
                    <div class="d-flex w-100 ">
                        <div class="form-group mr">
                            <label for="exampleInputEmail1"
                                >Title of the Lesson</label
                            >
                            <input
                                type="text"
                                required
                                v-model="lesson_title"
                                data-error="Field is required"
                                class="form-control width-half"
                                :maxlength="max"
                                placeholder="Enter Title"
                            />
                             <div class="input-group-addon mt-1" v-text="(max - lesson_title.length)"></div>
                            <div class="help-block with-errors"></div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1"
                                >Category</label
                            >
                            <select
                                class="form-control width-half"
                                id="exampleFormControlSelect1"
                                v-model="lesson_category"
                            >
                                <option
                                    v-for="(category, index) in categories"
                                    :key="index"
                                    :value="category.id"
                                    >{{ category.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"
                            >Description</label
                        >
                        <textarea
                            required
                            placeholder="Enter Description"
                            class="form-control"
                            v-model="lesson_description"
                            id="exampleFormControlTextarea1"
                            rows="3"
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"
                            >Instructions</label
                        >
                        <textarea
                            required
                            placeholder="Enter Instructions"
                            class="form-control"
                            v-model="lesson_instructions"
                            id="exampleFormControlTextarea1"
                            rows="3"
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"
                            >Additional Information or Help</label
                        >
                        <textarea
                            placeholder="Enter Additional Information or Help"
                            class="form-control"
                            v-model="lesson_additional"
                            id="exampleFormControlTextarea1"
                            rows="3"
                        ></textarea>
                    </div>
                </form>
                <div v-if="showError">
                    <p  class="error-show">
                        <b>Please correct the following error(s):</b>
                        <ul>
                            <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
                        </ul>
                    </p>
                </div>
                <div class="d-flex justify-space-between">
                    <a href="/admin" class=" transparent-btn">
                        Back: Admin Home
                    </a>
                    <div @click.prevent="validateStep1" class="default-btn">
                        Next: Add Video & Images
                    </div>
                </div>
            </div>
            <div v-if="currentStep == 2" class="module-holder">
                <h3 class="module-heading">
                    Add Video & Images
                </h3>
                <div class="d-flex mb-5 ">
                    <div>
                        <label for="">Upload Cover Photo</label>
                        <vue-dropzone
                            ref="myVueDropzone"
                            id="dropzone"
                            v-model="fileImage"
                            :options="dropzoneOptions"
                        ></vue-dropzone>
                        <!-- <button @click="uploadPhoto()" class="default-btn mt-5">
                            Upload Photo
                        </button> -->
                        <div v-if="showSuccess">
                            <p  class="success-show">
                                    <b>Successfully uploaded!</b>

                            </p>
                        </div>
                    </div>

                    <div class="ml-sm-5 w-100">
                        <div class="upload-file">
                            <label>Upload From File</label>

                            <input
                                accept=".mp4"
                                v-on:change="setVideo"
                                type="file"
                            />
                            <span class="browse">Video file.Mp4, VMV, AVI</span>
                        </div>
                        <div v-show="progressVisible"  class="upload-file">
                            <label v-if="progress < 100" for="file"
                                >Uploading progress: {{ progress }}%
                            </label>
                            <label v-else for="file">Done</label>
                            <progress id="file" :value="progress" max="100">
                            </progress>
                        </div>
                        <h3 class="mb-3">OR</h3>
                        <div class="form-group">
                            <label for="exampleInputEmail1"
                                >Upload with URL</label
                            >
                            <textarea
                                type="text"
                                class="form-control"
                                v-model="external_url"
                                placeholder="Enter Youtube Embed IFRAME"
                            />
                        </div>
                        <!-- <button :disabled="(!videoFile && !external_url) || videoButtonDisabled" class="default-btn mt-3">
                            Upload Video
                        </button> -->
                          <div v-if="showSuccessVideo">
                            <p  class="success-show">
                                    <b>Successfully uploaded!</b>

                            </p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-space-between pt-5">
                    <div @click.prevent="goToStep(1)" class="transparent-btn">
                        Back: Add Description
                    </div>
                    <div @click.prevent="validateMedia()" class="default-btn">
                        Next: Add Quiz Questions
                    </div>

                </div>
                   <div v-if="showErrorValidate">
                    <p  class="error-show">
                        <b>You have to upload Video!</b>

                    </p>
                </div>
            </div>
            <div v-if="currentStep == 3" class="module-holder">
                <h3 class="module-heading">
                    Add Quiz Questions & Answers
                </h3>
                <div v-if="showError">
                    <p  class="error-show">
                        <b>All input fields are required!</b>

                    </p>
                </div>
                <form v-for="(question, questionIndex) in questions" :key="questionIndex">
                    <div class="d-flex w-100 ">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1"
                                >Question Type</label
                            >
                            <select
                                class="form-control width-half"
                                id="exampleFormControlSelect1"
                                v-model="question.type"
                            >
                                <option
                                    v-for="(type, index) in questionTypes"
                                    :key="index"
                                    :value="type.id"
                                    >{{ type.type }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"
                            >Question</label
                        >
                        <validation-provider
                            rules="required"
                            v-slot="{ errors }"
                        >
                            <textarea
                                placeholder="Enter Question"
                                class="form-control height-fixed"
                                v-model="question.question"
                                id="exampleFormControlTextarea1"
                                rows="3"
                            ></textarea>

                            <span>{{ errors[0] }}</span>
                        </validation-provider>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1"
                            >Question Description(Optional)</label
                        >
                        <textarea
                            placeholder="Enter Question Description"
                            class="form-control"
                            v-model="question.description"
                            id="exampleFormControlTextarea1"
                            rows="3"
                        ></textarea>
                    </div>
                    <div class="form-group" v-if="question.type != 3">
                        <label for="exampleFormControlTextarea1"
                            >Answer(s) (required)</label
                        >
                        <div
                            v-for="(answer, questionIndex) in question.answers"
                            :key="questionIndex"
                            class="d-flex justify-space-between new-row"
                        >
                            <validation-provider
                                rules="required"
                                class="w-100"
                                style="position:relative;"
                                v-slot="{ errors }"
                            >
                                <textarea
                                    v-if="question.type != 3"
                                    v-model="answer.answer"
                                    placeholder="Enter Answer"
                                    class="form-control height-fixed width-crop"
                                    id="exampleFormControlTextarea1"
                                    rows="3"
                                ></textarea>
                                <template v-else>
                                     <textarea
                                              v-model="answer.answer"
                                             placeholder="True"
                                             class="form-control height-fixed width-crop"
                                             id="exampleFormControlTextarea1"
                                              disabled="disabled"
                                             rows="3"
                                     ></textarea>
                                    <textarea
                                             v-model="answer.answer"
                                            placeholder="False"
                                            class="form-control height-fixed width-crop"
                                            id="exampleFormControlTextarea1"
                                             disabled="disabled"
                                            rows="3"
                                    ></textarea>
                                </template>

                                <span class="error-field">{{ errors[0] }}</span>
                            </validation-provider>
                            <div class="d-flex">
                            <div class="form-check form-check-inline">
                                     <input
                                            v-if="question.type == 1"
                                            class="form-check-input"
                                            type="radio"
                                            v-model="question.correct"
                                            name="inlineRadioOptions"
                                            id="inlineRadio1"
                                            :value="questionIndex"
                                    />
                                    <input
                                            v-else
                                            class="form-check-input"
                                            type="checkbox"
                                            v-model="question.correct_multiple"
                                            name="inlineRadioOptions"
                                            id="inlineRadio1"
                                            :value="questionIndex"
                                    />



                            </div>
                            <button v-if="answer.deleteBtn" class="delete" @click.prevent="deleteAnswer(questionIndex)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        </div>
                        </div>
                    </div>
                    <div class="d-flex">
                    <div v-if="question.type != 3" class="d-flex">
                         <a @click="addNewAnswer(questionIndex)" class="add">
                            + Add Another Answer
                        </a>
                    </div>
                        <button v-if="question.deleteQuestion" class="delete ml-sm-5" @click.prevent="deleteQuestion(questionIndex)">
                            <i class="fas fa-trash-alt"></i> Delete Question
                        </button>
                        </div>
                         <div
                                 v-if="question.type == 3"
                                 class="form-check form-check-inline">
                             true
                            <input
                                     class="form-check-input"
                                    type="radio"
                                    v-model="question.correct"
                                    name="inlineRadioOptions"
                                    id="inlineRadio1"
                                    :value="true"
                            />
                             false
                             <input
                                      class="form-check-input"
                                     type="radio"
                                     v-model="question.correct"
                                     name="inlineRadioOptions"
                                     id="inlineRadio1"
                                     :value="false"
                             />




                        </div>

                 </form>
                <div class="d-flex display-b justify-space-between">
                    <div @click.prevent="goToStep(2)" class="transparent-btn">
                        Back: Add Video & Images
                    </div>
                    <div class="d-flex display-b">
                        <div @click="addNewQuestion" class="transparent-btn mr">
                            + Add Another Question
                        </div>
                        <button
                            @click.prevent="saveAndReviewLesson"
                            class="default-btn"
                        >
                            Next: Save & Review Lesson
                        </button>
                    </div>
                </div>
            </div>
            <div v-if="currentStep == 4" class="module-holder">
                <h3 class="module-heading">
                    Preview
                </h3>
                <div class="d-flex">
                    <div class="video-review">
                        <img :src="finalData.cover_image" alt="" />
                    </div>
                    <div class="ml-sm-5 video-review">
                        <video v-if="finalData.videos.length > 0 && finalData.videos[0].external_url == 'null'" controls>
                            <source
                            :src="finalData.video_url"
                                type="video/mp4">
                        </video>
                        <div v-html="finalData.videos[0].external_url"></div>
                    </div>
                </div>
                <div class="test-review">
                    <h2 class="test-title">
                       {{finalData.title}}
                    </h2>
                    <span class="test-desc">
                       {{finalData.description}}
                    </span>

                     <span class="test-desc">
                       {{finalData.instructions}}
                    </span>
                     <span class="test-desc">
                       {{finalData.additional_info}}
                    </span>
                    <div  v-if="finalData.quizzes && finalData.quizzes[0].questions">
                    <div :key="index" v-for="(question, index) in finalData.quizzes[0].questions" class="test-qa">
                        <h3>Q{{index+1}}: {{ question.question }} </h3>
                        <template v-if="question.answers && question.answers.length">

                            <div :key="i" v-for="(answer, i) in question.answers">
                                A{{i+1}}: {{ answer.content }}
                                <span v-if="answer.correct_answer_id == answer.answer_id " class="correct-answ">(A)</span>
                            </div>
                        </template>

                        <template v-else>
                                 A: {{ question.correct_answer == "0" ? "FALSE" : "TRUE" }}
                          </template>

                    </div>

                    </div>


                    </div>
               <div class="d-flex justify-flex-end mt">
                 <div @click.prevent="goToStep(3)" class="white-btn mr">
                    Back: Quiz Questions & Answers
                  </div>
                    <div @click="showModal = true" class="default-btn">
                        Save & Upload
                    </div>
                </div>

            </div>
            <transition name="fade">
                <div class="modal" v-if="showModal" @close="showModal = false">
                    <div class="modal__backdrop" @click="closeModal()" />

                    <div class="modal__dialog">
                        <div class="modal__body">
                            <h3 class="modal-title">
                                "Heart Failure Education" Module saved &
                                uploaded!
                            </h3>
                            <p class="modal-desc">
                                It may take up to 30 min before it's visible on
                                your website.
                            </p>
                            <div class="d-flex justify-center">
                                <a
                                    href="/admin"
                                    class="gold-btn-transparent mr-sm-4"
                                >
                                    Return Admin Home
                                </a>
                                <a @click="seeLivePage()" class="gold-btn">
                                    See Live Page
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import vue2Dropzone from "vue2-dropzone";
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import { ValidationProvider, extend } from "vee-validate";
import { required } from "vee-validate/dist/rules";

extend("required", {
    ...required,
    message: "This field is required"
});

export default {
    components: {
        vueDropzone: vue2Dropzone,
        Loading,
        ValidationProvider
    },
    data: () => ({
        progressVisible: false,
        max: 150,
        uploaded: 0,
        showSuccessVideo: false,
        savedLesson: null,
        showSuccess: false,
        currentStep: 1,
        lesson_title: '',
        step1Loading: false,
        showError: false,
        step2Loading: false,
        videoButtonDisabled: false,
        external_url: '',
        questions: [
            {
                type: 1,
                question: null,
                description: null,
                correct: 0,
                deleteBtn: false,
                correct_multiple: [],
                answers: [
                    {
                        answer: null
                    }
                ]
            }
        ],
        show: false,
        showModal: false,
        fileImage: null,
        module_id: 1,
        errors: [],
        downloadProgress: false,
        videoFile: null,
        uploadSelected: false,
        showErrorValidate: false,
        step1: {
            name: "",
            email: ""
        },
        dropzoneOptions: {
            url: "https://httpbin.org/post",
            thumbnailWidth: 150,
            maxFilesize: 5,
            maxFiles: 1,
            headers: {"My-Awesome-Header": "header value"}
        },
        lesson_category: 1,
        lesson_description: null,
        lesson_instructions: null,
        lesson_additional: null,
        questionTypes: [],
        radio: null,
        step2: {
            city: "",
            state: ""
        },
        chunks: [],
        output: [],
        categories: [],

        finalData: {},
    }),
    computed: {
        formData() {
            let formData = new FormData();

            formData.set("is_last", this.chunks.length === 1);
            formData.set("file", this.chunks[0], `${this.videoFile.name}`);
            formData.set("lesson_id", this.savedLesson.id);


            return formData;
        },
        progress() {
            if (this.videoFile) {

                return this.uploaded;
                // return Math.floor((this.uploaded * 100) / this.videoFile.size);
            }
            return 0;
        },
        config() {
            return {
                method: "POST",
                data: this.formData,
                url: "/api/lessons/video",
                headers: {
                    "Content-Type": "application/octet-stream"
                },
                onUploadProgress: progressEvent => {
                    if (progressEvent.loaded === progressEvent.total) {
                        var percentCompleted = Math.round(
                            (progressEvent.loaded / this.videoFile.size) * 100
                        );


                        this.uploaded += percentCompleted;
                    }
                }
            };
        }
    },
    created() {
        this.getCategories();
         this.getQuestionTypes();

    },
    mounted() {
        window.onbeforeunload = function() {
            return "Are you sure you want to navigate away?";
        }
    },

    methods: {
        validateMedia() {
              if (!this.videoFile && !this.external_url) {
                this.showErrorValidate = true;
                   setTimeout(() => {
                    this.showErrorValidate = false;
                    }, 2000);
                return
            }
              var formData = new FormData();
            let data = {
                file:  this.$refs.myVueDropzone.getAcceptedFiles()[0],
                lesson_id: this.savedLesson.id
            };

            if (!data.file) {
                alert('Please choose image file');
                return;
            }


            for (var key in data) {
                if (data[key]) {
                    formData.append(key, data[key]);
                }
            }
            axios
                .post("/api/lessons/image", formData)
                .then(() => {



                    this.showSuccess = true;
                      setTimeout(() => {
                    this.showSuccess = false;
                    }, 2000);

                })
                .catch(function(error) {
                    console.log(error);
                });

                this.uploadVideo();
//                this.getQuestionTypes();


        },
        seeLivePage() {
            window.onbeforeunload = null;
            window.location = '/lessons';
        },
        uploadVideo() {
            if (this.external_url) {
                this.step2Loading = true;
                this.uploadExternalVideo();
            } else if(this.videoFile) {
                this.progressVisible = true

                this.createChunks();

            }
        },
        saveAndReviewLesson(e) {
            e.preventDefault();
            let valid = true;
            this.questions.map((item, index) => {
                if (!item.question) valid = false;
                if (item.type == 2 && !item.correct_multiple.length) {
                    valid = false
                }
                item.answers.map(answer => {
                    if (item.type != 3) {
                        if (!answer.answer) {
                            valid = false;
                        }

                    }
                });
            });

            if (valid) {
                this.createQuiz().then(this.getQuizData).then(() => {
                    this.goToStep(4);
                })

            } else {
                this.showError = true;
                    setTimeout(() => {
                    this.showError = false;
                    }, 2000);
            }
        },
        validateStep1() {
            if (this.checkForm1()) {
                this.saveLessonAndGoToStep2();
            }

        },
        setVideo(e) {
            this.videoFile = e.target.files[0]
        },
        getCategories() {
            axios
                .get("/api/categories")
                .then(response => {
                    this.categories = response.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        saveLessonAndGoToStep2() {

            this.step1Loading = true;
            let payload = {
                'title': this.lesson_title,
                'description': this.lesson_description,
                'category_id': this.lesson_category
            }

            if (this.lesson_additional) {
                payload.additional_info = this.lesson_additional;
            }

            if (this.lesson_instructions) {
                payload.instructions = this.lesson_instructions

            }
            if (this.savedLesson) {
                alert('Edit not ready yet!')
                this.goToStep(2)
            } else {
                axios
                    .post("/api/lessons", payload)
                    .then(response => {
                        this.savedLesson = response.data
                        this.goToStep(2);

                    })
                    .catch(err => {
                        console.log(err);
                    })
                    .finally(() => {
                        this.step1Loading = false;
                    });
            }

        },
        uploadExternalVideo() {
            axios
                .post("/api/lessons/external-video", {lesson_id: this.savedLesson.id, external_url: this.external_url})
                .then(response => {
                    console.log(response);
                       this.showSuccessVideo = true;
                      setTimeout(() => {
                    this.showSuccessVideo = false;
                          this.goToStep(3)

                      }, 1000);
                })
                .catch(error => {
                    alert(error.response.data.errors.external_url)
                }).finally(() => {
                this.step2Loading = false
            })
        },
         getQuizData() {
           return axios
                .get(`/api/lessons/${this.savedLesson.id}`)
                .then(response => {
                    this.finalData = response.data;
                    console.log(this.finalData, 'final');

                })
                .catch(err => {
                    console.log(err);
                });
        },
        getQuestionTypes() {
            axios
                .get("/api/question-types")
                .then(response => {
                    this.questionTypes = response.data;
                })
                .catch(err => {
                    console.log(err);
                });
        },
        // uploadPhoto() {

        //     var formData = new FormData();
        //     let data = {
        //         file:  this.$refs.myVueDropzone.getAcceptedFiles()[0],
        //         lesson_id: this.savedLesson.id
        //     };

        //     if (!data.file) {
        //         alert('Please choose image file');
        //         return;
        //     }


        //     for (var key in data) {
        //         if (data[key]) {
        //             formData.append(key, data[key]);
        //         }
        //     }
        //     axios
        //         .post("/api/lessons/image", formData)
        //         .then(() => {



        //             this.showSuccess = true;
        //               setTimeout(() => {
        //             this.showSuccess = false;
        //             }, 2000);

        //         })
        //         .catch(function(error) {
        //             console.log(error);
        //         });
        // },
        createQuiz() {
            let payload = {lesson_id: this.savedLesson.id, questions: this.questions}
          return  axios
                .post("/api/questions", payload)
                .then(function (response) {

                })
                .catch(function(error) {
                    console.log(error);
                });
        },

        goToStep: function (step) {
            this.currentStep = step;
        },
        checkForm1: function(e) {
            if (
                this.lesson_title &&
                this.lesson_category &&
                this.lesson_description
            ) {
                return true;
            }

            this.errors = [];

            if (!this.lesson_title) {
                this.errors.push("Title is required.");
            }
            if (!this.lesson_category) {
                this.errors.push("Category is required.");
            }

            if (!this.lesson_description) {
                this.errors.push("Description is required.");
            }


            // e.preventDefault();
            return false;
        },
        addNewQuestion: function() {
            this.questions.push({
                type: 1,
                question: null,
                description: null,
                correct: 0,
                deleteBtn: false,
                deleteQuestion: true,
                correct_multiple: [

                ],
                answers: [
                    {
                        answer: null
                    }
                ]
            });
        },
        addNewAnswer: function(questionIndex) {

            if (
                this.questions[questionIndex] &&
                this.questions[questionIndex].answers
            ) {
                this.questions[questionIndex].answers.push({
                    answer: null,
                    correct: false,
                    deleteBtn: true,
                });
            }
        },
         deleteAnswer: function(questionIndex) {
               this.questions.map((item) => {
                   item.answers.splice(questionIndex, 1)

                })
        },
        deleteQuestion: function(questionIndex) {
                 // axios
                 //    .delete(`/api/delete-question/${questionIndex}`)
                 //    .then(response => {
                 //
                 //    })
                 //    .catch(err => {
                 //        console.log(err);
                 //        alert("Something went wrong!");
                 //    });
               this.questions.splice(questionIndex, 1)


        },
        closeModal() {
            this.showModal = false;
            document.querySelector("body").classList.remove("overflow-hidden");
        },
        openModal() {
            this.showModal = true;
            document.querySelector("body").classList.add("overflow-hidden");
        },

        select() {
            this.videoFile = this.file;
            this.createChunks();
        },
        upload() {
            axios(this.config)
                .then(response => {

                    this.chunks.shift();
                    if (!this.chunks.length) {
                        this.showSuccessVideo = true;
                        setTimeout(() => {
                            this.showSuccessVideo = false;
                            this.goToStep(3);

                        }, 1000);

                    }
                })
                .catch(() => {
                    alert("Upload was unsuccessful");
                    this.videoButtonDisabled = false
                });
        },
        createChunks() {
            this.videoButtonDisabled = true;
            let size = 2000000,
                chunks = Math.ceil(this.videoFile.size / size);

            console.log(size, this.videoFile.size);

            for (let i = 0; i < chunks; i++) {
                this.chunks.push(
                    this.videoFile.slice(
                        i * size,
                        Math.min(i * size + size, this.videoFile.size),
                        this.videoFile.type
                    )
                );
            }
        }
    },
    watch: {
        chunks(n) {
            if (n.length > 0) {
                this.upload();
            }
        },

        errors() {
            if (this.errors.length) {
                this.showError = true;
                setTimeout(() => {
                    this.showError = false;
                }, 2000);
            }
        },
        progress() {
            if (this.progress >= 100) {
                this.videoButtonDisabled = false;
                // this.videoFile = null;
                this.showSuccess = true;
                  setTimeout(() => {
                    this.showSuccess = false;
                }, 2000);

            }
        }
    }
};
</script>
