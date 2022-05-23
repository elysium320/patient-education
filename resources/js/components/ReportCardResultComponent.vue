<template>
    <div>
        <div class="score">
            <div class="score-progress">
                <progress-bar
                    :options="options"
                    :value="Math.floor(results.percentage)"
                    duration="2000"
                />
            </div>
            <div class="info">
                <h3 class="title">
                     {{trans.get('strings.You got')}} {{ results.total_correct }} {{trans.get('strings.out of')}}
                    {{ results.total_questions }} {{trans.get('strings.correct')}}
                </h3>
                <p v-if="Math.floor(results.percentage) == 100" class="desc">
                    ={{trans.get('strings.congrats')}}
                </p>
                <p
                    v-if="
                        Math.floor(results.percentage) > 50 &&
                            Math.floor(results.percentage) <= 90
                    "
                    class="desc"
                >
                    {{trans.get('strings.try_again')}}
                </p>
                <p
                    v-if="
                        Math.floor(results.percentage) > 20 &&
                            Math.floor(results.percentage) <= 50
                    "
                    class="desc"
                >
                    Not Bad, but you can do it better! Click below to rewatch
                    the video and retake the quiz.
                </p>
                <p v-if="Math.floor(results.percentage) < 20" class="desc">
                    {{trans.get('strings.fail')}}
                </p>
                <div class="d-flex">
                    <a :href="`/lessons/${results.quiz_questions.quiz.lesson_id}`" class="gold-btn">
                        {{trans.get('strings.Rewatch video')}}
                    </a>
                    <a
                        v-if="Math.floor(results.percentage) < 100"
                        style="margin-left:5px"
                        @click="goBack()"
                        class="gold-btn"
                    >
                        {{trans.get('strings.Retake quiz')}}
                    </a>

                    <a
                        v-if="Math.floor(results.percentage) == 100"
                        @click="goNext()"
                        class="default-btn ml-3"
                    >{{trans.get('strings.Next lesson')}}</a
                    >
                </div>
            </div>
        </div>
        <div class="results">
            <span class="title">{{trans.get('strings.Your results')}}</span>
            <div class="result-holder">
                <div
                    v-for="(result, i) in results.quiz_questions
                        .taken_questions"
                    :key="i"
                    class="result"
                >
                    <div class="type">
                        <div
                            v-if="
                                getLabel(
                                    result.correct_answers,
                                    result.chosen_answers
                                )
                            "
                            class="correct"
                        >
                            {{trans.get('strings.correct')}}
                        </div>
                        <div v-else class="incorrect">
                            {{trans.get('strings.incorrect')}}
                        </div>
                    </div>
                    <div class="res">
                        <div>
                            <span
                                v-if="
                                   i+1 >= 2
                                "
                            >
                                {{ i + 1 }}. {{ result.actual_question }}
                            </span>
                            <span v-else>
                                {{ i + 1 }}. {{ result.actual_question }}
                            </span>
                        </div>
                        <!-- <span>{{ i + 1 }}. {{ result.actual_question }} ?</span> -->

                        <span v-if="Array.isArray(result.correct_answers)">
                            <span
                                v-for="(correctAnswer,
                                i) in result.correct_answers"
                                class="correct-answer"
                                :key="i"
                            >
                                <div class="correct">
                                    {{ correctAnswer.content }}
                                </div>
                            </span>
                        </span>
                        <span class="correct-answer" v-else>
                            <span class="correct">
                                {{ result.correct_answers }}
                            </span>
                        </span>

                        <span
                            v-for="(answer, i) in result.chosen_answers"
                            class="correct-answer"
                            :key="i"
                        >
                            <div
                                v-if="!answer.correct"
                                style="color:red"
                                class="incorrect"
                            >
                                {{ answer.given_answer.content }}
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex next-btn">
            <!-- <a href="/quizzes" class="default-btn mr-4">Take Quiz</a> -->
            <!-- <a href="/lessons" class="default-btn">Next: Take Survey</a> -->
        </div>
        <div
            class="d-flex align-center justify-space-between lesson-navigation"
        >
            <!-- <h2 class="slider-title">Complete</h2>
            <h2 class="slider-title">Up Next…</h2> -->
        </div>
        <slider-component
            v-if="module.lessons.length"
            :lessons="module.lessons"
        ></slider-component>
    </div>
</template>
<script>
export default {
    props: ["quiz", "module"],
    components: {},
    data: () => ({
        results: {
            quiz_questions: {}
        },

        options: {
            text: {
                color: "black",
                shadowEnable: true,
                shadowColor: "#000000",
                fontFamily: "Helvetica",
                dynamicPosition: false,
                hideText: false
            },
            progress: {
                color: "#D79D3E",
                backgroundColor: "#F4E4C7"
            },
            layout: {
                height: 250,
                width: 250,

                zeroOffset: 0,
                strokeWidth: 10,
                progressPadding: 0,
                type: "circle"
            }
        }
    }),
    computed: {},
    created() {
        console.log('this.tras', this.trans.messages)
        console.log('Trans has', this.trans.has('strings.Lesson'), this.trans.has('strings.en'))
        this.getResults();
    },
    methods: {
        goBack() {
            window.location.href = `/quizzes/${this.results.quiz_questions.quiz_id}`
        },
        goNext() {
            window.location.href = `/quizzes/${this.results.quiz_questions.quiz_id+1}`
        },
        getLabel(correct, chosenAnswers) {
            let isTrue = true;

            if (Array.isArray(correct)) {
                correct.map(correctItem => {
                    console.log(
                        correctItem
                    );
                    if (Array.isArray(chosenAnswers)) {
                        if (chosenAnswers.findIndex(x => x.answer === correctItem.id) === -1) {
                            isTrue = false
                        }
                    }
                });
            } else {
                if (correct === chosenAnswers[0].correct) {
                    isTrue = true;
                }
            }

            return isTrue;
        },
        getResults() {
            axios
                .get(`/quiz/get-results/${this.quiz}`)
                .then(response => {
                    this.results = response.data;
                    // console.log(this.results.quiz_questions.taken_questions);
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>
<style lang="scss"></style>
