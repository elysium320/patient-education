<template>
    <div class="create-account d-flex">
        <div class="profile-img">
            <img src="/img/male-placeholder.png" alt="" />
            <div class="white-space">
                <div class="add-new">
                    <span>+</span>
                </div>
            </div>
        </div>
        <div class="form">
            <input v-model="name" type="text" placeholder="Name" />
            <input v-model="email" type="email" placeholder="Email" />
            <input v-model="password" type="password" placeholder="Password" />
            <a @click="validateForm" class="default-btn">Create Account</a>
        </div>
        <div v-if="showSuccess">
            <p style="z-index: 999999;" class="success-show">
                <b>Successfully Added!</b>
            </p>
        </div>
        <div v-if="showError">
            <p style="height: 150px;z-index: 999999;" class="error-show">
                <b>Please correct the following error(s):</b>
                <ul>
                    <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
                </ul>
            </p>
        </div>
    </div>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    data: () => ({
        lessonsLoading: false,
        name: "",
        errors: [],
        showError: false,
        showSuccess: false,
        email: "",
        password: "",
        user: []
    }),
     watch: {
           errors() {
            if (this.errors.length) {
                this.showError = true;
                setTimeout(() => {
                    this.showError = false;
                }, 2000);
            }
        },
     },
    methods: {
          checkForm: function(e) {
            if (
                this.name &&
                this.email &&
               this.password
            ) {
                return true;
            }

            this.errors = [];

            if (!this.name) {
                this.errors.push("Name is required.");
            }
            if (!this.email) {
                this.errors.push("Email is required.");
            }

            if (!this.password) {
                this.errors.push("Password is required.");
            }

            return false;
        },
         validateForm(){
             if (this.checkForm()) {
                this.createUser();
            }
        },
        createUser() {
            this.lessonsLoading = true;
            axios
                .post(`/api/admin/create-account`, {
                    password: this.password,
                    email: this.email,
                    name: this.name
                })
                .then(response => {
                    this.user = response.data;
                    this.showSuccess = true;
                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {
                    this.showSuccess = false;
                    this.lessonsLoading = false;
                });
        }
    }
};
</script>
