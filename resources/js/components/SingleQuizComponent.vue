<template>
    <div>
        <div v-if="errorShow" class="error-show">
            <b>Please select answer.</b>
        </div>
        <div class="quiz-holder">
            <div v-for="(question, i) in formattedQuestions" :key="i">
                <div v-show="currentStep === i">
                    <h3 class="quiz-heading">
                        {{ i + 1 }}. {{ question.question }}
                    </h3>
                    <div
                        v-for="(answer, index) in question.answers"
                        v-bind:key="index"
                        class="questions"
                    >
                        <div class="question">
                            <div
                                v-if="question.type == 1 || question.type == 2"
                                class="form-check form-check-inline"

                            >
                                <input
                                    v-if="question.type == 1"
                                    class="form-check-input1"
                                    type="radio"
                                    size="20"
                                    name="inlineRadioOptions"
                                    id="inlineRadio1"
                                    v-model="question.chosen_answer"
                                    :value="answer.answer_id"

                                />
                                <input
                                    v-if="question.type == 2"
                                    class="form-check-input1"
                                    type="checkbox"
                                    name="inlineRadioOptions"
                                    id="inlineRadio1"
                                    v-model="question.chosen_answer"
                                    :value="answer.answer_id"
                                />
                                <label
                                    class="form-check-label"
                                    for="inlineRadio1"
                                    >{{ answer.content }}</label
                                >
                            </div>
                            <div v-else class="form-check form-check-inline">
                                <label
                                    class="form-check-label"
                                    for="inlineRadio1"
                                    >{{ answer.content }}</label
                                >
                                <input
                                    class="form-check-input1"
                                    type="radio"
                                    name="inlineRadioOptions"
                                    id="inlineRadio1"
                                    v-model="question.correct_answer"
                                    :value="true"
                                />
                                <label
                                    class="form-check-label"
                                    for="inlineRadio2"
                                    >{{ answer.content }}</label
                                >
                                <input
                                    class="form-check-input1"
                                    type="radio"
                                    name="inlineRadioOptions"
                                    id="inlineRadio2"
                                    v-model="question.correct_answer"
                                    :value="false"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="questions">
                        <div v-if="question.type == 3" class="question">
                            <div class="form-check form-check-inline">
                                <label
                                    class="form-check-label"
                                    for="inlineRadio1"
                                    >True</label
                                >
                                <input
                                    class="form-check-input1"
                                    type="radio"
                                    name="inlineRadioOptions"
                                    id="inlineRadio1"
                                    v-model="question.correct_answer"
                                    :value="true"
                                />
                                <label
                                    class="form-check-label"
                                    for="inlineRadio2"
                                    >False</label
                                >
                                <input
                                    class="form-check-input1"
                                    type="radio"
                                    name="inlineRadioOptions"
                                    id="inlineRadio2"
                                    v-model="question.correct_answer"
                                    :value="false"

                                />
                            </div>
                        </div>
                    </div>
                    <div class="d-sm-flex justify-space-between">
                        <div>
                            <button
                                :disabled="disabled"
                                @click.prevent="goToStep(currentStep + 1)"
                                class="default-btn"
                            >
                                {{trans.get('strings.Submit')}}
                            </button>
                        </div>
                        <div
                            class="d-flex align-center"
                            v-if="!previousDisabled"
                        >
                            <div
                                @click.prevent="goToStep(currentStep - 1)"
                                class="default-btn-gold"
                                style="width: fit-content"
                            >
                                {{trans.get('strings.Previous')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["quiz"],
    data: () => ({
        showModal: false,
        formattedQuestions: [],
        currentStep: 0,
        started_at: "",
        disabled: false,
        errorShow: false,
        step1: {
            name: "",
            email: ""
        },
        step2: {
            city: "",
            state: ""
        },
        newArray: []
    }),
    computed: {
        previousDisabled() {
            return this.currentStep === 0;
        }
    },

    methods: {
        submitQuiz: function() {
            let payload = {
                questions: []
            };
            this.formattedQuestions.map((item, index) => {
                payload.questions.push({
                    id: item.id,
                    chosen_answers: item.chosen_answer,
                    correct_answer: item.correct_answer
                });
            });

            payload.quiz_id = this.quiz.id;
            payload.started_at = this.started_at;
            axios
                .post("/api/quiz-results", payload)
                .then(response => {
                    if (response.data && response.data.id) {
                        window.location = `/quiz/report-card/${response.data.id}`;
                    } else {
                        // alert("Service Unavailable!");
                    }
                })
                .catch(err => {
                    console.log(err);
                });
        },
        goToStep: function(step) {
            if (step < this.formattedQuestions.length && step >= 0) {
                if (
                    !(
                        (this.formattedQuestions[this.currentStep].chosen_answer && this.formattedQuestions[this.currentStep].chosen_answer.length) || this.formattedQuestions[this.currentStep].chosen_answer) &&
                    step > this.currentStep
                ) {
                    this.errorShow = true;
                    setTimeout(() => {
                        this.errorShow = false;
                    }, 1000);
                    return;
                }


                console.log(Array.isArray(this.formattedQuestions[this.currentStep].chosen_answer));
                if (Array.isArray(this.formattedQuestions[this.currentStep].chosen_answer) && !this.formattedQuestions[this.currentStep].chosen_answer.length) {
                    this.errorShow = true;
                    setTimeout(() => {
                        this.errorShow = false;
                    }, 1000);
                    return;
                }

                this.currentStep = step;
            }

            if (step >= this.formattedQuestions.length) {
                if (
                    !(
                        (this.formattedQuestions[this.currentStep]
                            .chosen_answer &&
                            this.formattedQuestions[this.currentStep]
                                .chosen_answer.length) ||
                        this.formattedQuestions[this.currentStep].chosen_answer
                    ) &&
                    step >= this.formattedQuestions.length
                ) {
                    this.errorShow = true;
                    setTimeout(() => {
                        this.errorShow = false;
                    }, 1000);
                    return;
                }

                this.submitQuiz();
            }
        },
        closeModal() {
            this.showModal = false;
            document.querySelector("body").classList.remove("overflow-hidden");
        },
        openModal() {s
            this.showModal = true;
            document.querySelector("body").classList.add("overflow-hidden");
        }
    },
    created() {
        this.started_at = new Date();
        console.log(this.started_at, "ulaz");
        this.formattedQuestions = this.quiz.questions;
        this.formattedQuestions.map((item, i) => {
            if (item.type == 1) {
                this.formattedQuestions[i].chosen_answer = null;
            } else {
                this.formattedQuestions[i].chosen_answer = [];
            }
        });
    }
};
</script>

<style lang="scss">
.modal {
    overflow-x: hidden;
    overflow-y: auto;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    display: block;
    left: 0;
    z-index: 9;
    &__backdrop {
        background-color: rgba(0, 0, 0, 0.3);
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 1;
    }
    &__dialog {
        background-color: #ffffff;
        position: relative;
        width: 600px;
        margin: 50px auto;
        display: flex;
        flex-direction: column;
        border-radius: 5px;
        z-index: 2;
        @media screen and (max-width: 992px) {
            width: 90%;
        }
    }
    &__close {
        width: 30px;
        height: 30px;
    }
    &__header {
        padding: 20px 20px 10px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }
    &__body {
        padding: 10px 20px 10px;
        overflow: auto;
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }
    &__footer {
        padding: 10px 20px 20px;
        & a:not(:last-child) {
            margin-right: 10px;
        }
    }
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}

input[type=radio],
input[type=checkbox] {
  box-sizing: border-box;
  padding: 0;
  line-height: normal;
  transform: scale(2);
  min-width: 30px;
}

/* #inlineRadio1{
    transform: scale(2);
}


#inlineRadio2{
    transform: scale(2);
} */




</style>
