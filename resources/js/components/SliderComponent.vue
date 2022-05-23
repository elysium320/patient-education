<template>
    <vue-glide ref="glide" data-glide-el="track" v-bind="carouselOptions">
        <vue-glide-slide
            v-for="(lesson, i) in lessons"
            class="programs__list-item"
            :key="i"
        >
            <div
                @click="goToPage(lesson)"
                :style="{
                    backgroundImage: ' url(' + `${lesson.cover_image}` + ')'
                }"
                class="bg-image"
            ></div>
            <div @click="goToPage(lesson)" class="lesson-num">
                Lesson {{ i + 1 }}
            </div>
            <div @click="goToPage(lesson)" class="title">
                <span>{{ lesson.title }}</span>
                <div class="date-duration">
                    <span>{{ lesson.date }}</span>
                </div>
            </div>
        </vue-glide-slide>

        <template data-glide-el="controls" slot="control">
            <button
                class="left-control glide__arrow glide__arrow--left"
                data-glide-dir="<"
            >
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
            </button>
            <button
                class="glide__arrow glide__arrow--right right-control "
                data-glide-dir=">"
            >
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </button>
        </template>
        <!-- <template
                slot="control"
                class="glide__bullets"
                data-glide-el="controls[nav]"
            >
                <button class="glide__bullet" data-glide-dir="=0"></button>
                <button class="glide__bullet" data-glide-dir="=1"></button>
                <button class="glide__bullet" data-glide-dir="=2"></button>
            </template> -->
    </vue-glide>
</template>
<script>
import { Glide, GlideSlide } from "vue-glide-js";
export default {
    props: ["lessons"],
    components: {
        [Glide.name]: Glide,
        [GlideSlide.name]: GlideSlide
    },
    data: () => ({
        programs: [
            {
                image: "heart.png",
                name: "Lesson 1: What is the Heart?"
            },
            {
                image: "heart.png",
                name: "Lesson 2: What is the Heart?"
            },
            {
                image: "heart.png",
                name: "Lesson 3: What is the Heart?"
            },
            {
                image: "heart.png",
                name: "Lesson 4: What is the Heart?"
            },
            {
                image: "heart.png",
                name: "Lesson 5: What is the Heart?"
            },
            {
                image: "heart.png",
                name: "Lesson 6: What is the Heart?"
            }
        ],
        carouselOptions: {
            autoplay: false,
            type: "slider",
            perView: 3,
            startAt: 0,
            gap: 60,
            bound: true,
            keyboard: true,
            animationDuration: 600,
            animationTimingFunc: "linear",
            focusAt: 0,
            breakpoints: {
                425: {
                    perView: 1
                }
            }
        }
    }),
    computed: {},
    created() {},
    methods: {
        goToPage(lesson) {
            console.log("hey");
            window.location = `/lessons/${lesson.id}`;
        }
    }
};
</script>
<style lang="scss">
.slider-title {
    font: normal normal bold 2.5rem/ 3rem Helvetica;
    letter-spacing: 0px;
    color: #033d33;
    text-align: left;
}
.glide {
    width: 110.9rem !important;
    position: relative;
    margin: auto;
    & .left-control,
    .right-control {
        background: transparent;
        border: none;
        & i {
            font-size: 28px;
        }
    }
    .left-control {
        position: absolute;
        left: -50px;
        top: 50%;
        transform: translate(0px, -50%);
    }
    .right-control {
        position: absolute;
        right: -50px;
        top: 50%;
        transform: translate(0px, -50%);
    }

    .bg-image {
        width: 100% !important;
        height: 14.69rem !important;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }

    .title {
        padding: 0.625rem 1.313rem;
        height: 4.938rem;
        border: 2px solid #0e181053;
        text-align: left;
        & span {
            font: normal normal 600 1.563rem/2.25rem "Fira Sans";
            letter-spacing: 0px;
            color: #0e1810;
        }
        .date-duration {
            display: flex;
            justify-content: space-between;
            align-items: center;
            & span {
                font: normal normal normal 1rem/1.438rem "Fira sans";
                letter-spacing: 0px;
                color: #033d33;
            }
        }
    }
}
.glide__wrapper {
    padding: 15vh 0;
}
.glide__track {
    overflow: hidden;
    height: 36.6vh;
    margin: auto;
}
.glide__slide {
    cursor: pointer;
    -webkit-transition: all 200ms ease;
    transition: all 200ms ease;
    -webkit-transform-origin: 50% 50%;
    transform-origin: 50% 50%;
    -webkit-transform: translate3d(0, 0, 0);
    transform: translate3d(0, 0, 0);
    // width: 30.38rem !important;
    height: 19.63rem !important;
    background-position: center;
    position: relative;
    &:before {
        content: "";
        position: absolute;
        pointer-events: none;
        left: 0;
        cursor: pointer;
        right: 0;
        top: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
    }
    &.glide__slide--active {
        & .lesson-num {
            display: none;
        }
        &:before {
            background: transparent;
        }
    }
}
.lesson-num {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font: normal normal bold 3.125rem/3.75rem Helvetica;
    letter-spacing: 0px;
    color: rgb(255 255 255 / 0.5);
}
</style>
