<template>
    <div class="">
        <form method="POST">

 <div class="create-account d-flex">
        <div class="profile-img">
            <img src="/img//male-placeholder.png" alt="" />
            <div class="white-space">
                <div class="add-new">
                    <span>+</span>
                </div>
            </div>
            <p>Update Photo</p>
        </div>
        <div class="form">
            <input type="text" placeholder="Name" />
            <input v-model="formattedEmail" type="email" placeholder="Email" />
              <validation-provider
                           rules="required"
                            ref="password"
                            v-slot="{ errors }"
                        >
                             <input
                                type="password"
                                required
                                v-model="password"
                                placeholder="Enter Password"
                            />

                            <span>{{ errors[0] }}</span>
                    </validation-provider>
            <validation-provider
                           rules="required"
                            v-slot="{ errors }"
                        >
                              <input
                                type="password"
                                required
                                v-model="confirm"
                                placeholder="Confirm Password"
                            />

                            <span>{{ errors[0] }}</span>
                    </validation-provider>
                    <div class="d-flex justify-flex-end">
                        <div class="d-flex flex-column align-center justify-flex-end">
                        <button href="#" style="width: fit-content;" @click.prevent="submit" class="default-btn">Update Profile</button>
                        <a href="#">Delete Account</a>
                        </div>
                    </div>
        </div>
    </div>
       <div v-if="showSuccess">
            <p style="z-index: 999999;" class="success-show">
                <b>Successfully Updated!</b>
            </p>
        </div>
              <div v-if="showError">
                    <p  class="error-show">
                        <b>Please correct the following error(s):</b>
                        <ul>
                            <li v-for="(error,index) in errors" :key="index">{{ error }}</li>
                        </ul>
                    </p>
                </div>

        </form>
    </div>
</template>
<script>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import { ValidationProvider, extend } from "vee-validate";
import { required, confirmed } from "vee-validate/dist/rules";

extend("required", {
    ...required,
    message: "This field is required"
});

export default {
    props: ['email', 'id'],
      components: {
        Loading,
        ValidationProvider
    },
    data: () => ({
        showSuccess: false,
        password: '',
        formattedEmail: '',
        showError: false,
        confirm: '',
        errors: [],
    }),
    created() {
            this.formattedEmail = this.email
    },
    methods:{
        updateUser() {
            axios
                .post(`/api/users/update`, {
                    password: this.password,
                    password_confirmation: this.confirm,
                    user_id: this.id
                })
                .then(response => {
                    this.formatedLessons = response.data;
                    this.showSuccess = true;
                     setTimeout(() => {
                    this.showSuccess = false;
                }, 2000);

                })
                .catch(err => {
                    console.log(err);
                })
                .finally(() => {

                    this.lessonsLoading = false;
                });
        },
         checkValidation: function(e) {
            if (
                this.email &&
                this.password &&
                this.confirm
            ) {
                 if (this.password !== this.confirm) {
                this.errors = ["Passwords don't match."]
                return false;
            }
                this.updateUser();
                return true;
            }

            this.errors = [];

            if (!this.email) {
                this.errors.push("Email is required.");
            }
            if (!this.password) {
                this.errors.push("Password is required.");
            }

            if (!this.confirm) {
                this.errors.push("Confirm Password is required.");
            }



            // e.preventDefault();
            return false;
        },
        submit(){
              if (this.checkValidation()) {

            }
        },

    },
    watch:{
          errors() {
            if (this.errors.length) {
                this.showError = true;
                setTimeout(() => {
                    this.showError = false;
                }, 2000);
            }
        },

    }
};
</script>
<style lang="scss">
.form-holder {
    max-width: 25.81rem;
    margin: auto;
    text-align: left;
    display: block;
    margin-top: 4.188rem;
    margin-bottom: 6.375rem;
}
</style>
