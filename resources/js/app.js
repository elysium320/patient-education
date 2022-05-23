/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import Vue from "vue";
import Lang from 'lang.js';
import translations from '../lang/translations.js';
window.Vue = require("vue");
window.$ = require("jquery");
window.JQuery = require("jquery");
window.ProgressBar = require("vuejs-progress-bar");
window.VueGlide = require("vue-glide-js");
window.VueGlideCss = require("vue-glide-js/dist/vue-glide.css");

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "quiz-component",
    require("./components/SingleQuizComponent.vue").default
);
Vue.component(
    "module-component",
    require("./components/CreateModuleComponent.vue").default
);
Vue.component(
    "update-module-component",
    require("./components/UpdateModuleComponent.vue").default
);
Vue.component(
    "all-lessons-component",
    require("./components/AllLessonsComponent.vue").default
);
Vue.component(
    "all-modules-component",
    require("./components/AllModulesComponent.vue").default
);
Vue.component(
    "all-quizzes-component",
    require("./components/AllQuizzesComponent.vue").default
);
Vue.component(
    "result-component",
    require("./components/ReportCardResultComponent.vue").default
);
Vue.component(
    "data-component",
    require("./components/DataStatisticComponent.vue").default
);
Vue.component(
    "profile-component",
    require("./components/AdminProfileComponent.vue").default
);
Vue.component(
    "modules-component",
    require("./components/ModulesTableComponent.vue").default
);
Vue.component(
    "quizzes-component",
    require("./components/QuizzesTableComponent.vue").default
);
Vue.component(
    "drag-component",
    require("./components/DragComponent.vue").default
);
Vue.component(
    "update-drag-component",
    require("./components/UpdateDragComponent.vue").default
);
Vue.component(
    "create-account-component",
    require("./components/CreateAccountComponent.vue").default
);
Vue.component(
    "edit-lesson-component",
    require("./components/EditLessonComponent.vue").default
);
Vue.component(
    "slider-component",
    require("./components/SliderComponent.vue").default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 const default_locale = window.default_locale;
 const fallback_locale = window.fallback_locale;

Vue.use(ProgressBar);
Vue.use(VueGlide);
Vue.use(VueGlideCss);

console.log('locale', default_locale);

Vue.prototype.trans = new Lang({messages: translations, locale: default_locale, fallback: fallback_locale});

const app = new Vue({
    el: "#app",
});
