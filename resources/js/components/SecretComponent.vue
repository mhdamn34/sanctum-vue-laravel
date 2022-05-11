<template>
    <div class="container">
        <!-- Login Form -->
        <div class="row mt-4">
            <div class="col col-6 offset-3" v-if="!secrets.length">
            
                <div class="row" v-if="errorMessage">
                    <div class="alert alert-danger">
                        <!-- <p>{{ errorMessage }}</p> -->
                        <p> Error </p>
                    </div>
                </div>
                
                <div class="row" v-if="successMessage">
                    <div class="alert alert-success">
                        <!-- <p>{{ successMessage }}</p> -->
                        <p>eee</p>
                    </div>
                </div>
                
                <form action="#" @submit.prevent="handleLogin">
                <h3>Sign In</h3>

                    <div class="form-row">
                        <input 
                        type="email" 
                        name="email" 
                        class="form-control" 
                        v-model="formData.email" 
                        placeholder="Email"
                        :class="{'is-invalid' : submitted && $v.formData.email.$error}"
                        />
                        <div v-if="submitted && $v.formData.email.$error" class="alert alert-danger">
                        <span v-if="!$v.formData.email.required"> Email is Required</span>
                        <span v-if="!$v.formData.email.minLength"> Enter Minimum 22 character</span>
                        <span v-if="$v.formData.email.minLength && !$v.formData.email.email"> Enter valid Email address</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control" 
                            v-model="formData.password" 
                            placeholder="password"
                            />
                            <div class="row" v-if="submitted && !$v.formData.password.required">
                                <span class="alert alert-danger">Password is required</span>
                            </div>  
                    </div>
                    <div class="form-row">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Secret list -->
        <div class="row mt-4" v-if="secrets.length" > 
            <div class="col-6 offset-3">
                <h3>My Secrets</h3><br> 
                <button class="btn-secondary" @click="getSecrets"> Get Secrets Data</button>
                <div class="secret" v-for="(secret, index) in secrets" :key="index">
                    <em v-text="secret.created_at"></em><br>
                    <strong v-text="secret.secret"></strong>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';

    export default{
        setup () {
             return { $v: useVuelidate() }
        },
        data(){
            return{
                secrets : [],
                formData: {
                    email : '',
                    password : ''
                },
                errorMessage: "",
                successMessage: "",
                submitted:false
            }
        },
        validations:{
            formData:{
                email: {
                    required,
                    minLength: minLength(10),
                    email
                },
                password: {
                    required
                }
            }
        },
        methods: {
            handleLogin(){
                this.$v.$touch();
                if (this.$v.$invalid) {
                    return; // stop here if form is invalid
                }
                // send axios request to the login route
                axios.get('/sanctum/csrf-cookie').then(response => {
                    // console.log(response)
                    axios.post('/login', this.formData).then(response => {
                        this.submitted = true;
                        // this.successMessage =  response;
                        // this.errorMessage = ""; 
                        this.getSecrets();
                    })
                    .catch((error) => {
                        this.errorMessage = error;
                        this.successMessage = "";
                    });
                });
            },
            getSecrets(){
                axios.get('/api/secrets').then(response => {
                    console.log(response);
                    this.secrets =  response.data;
                });
            }
        }
    }
</script>

<style>
    .form-row{
        margin-bottom: 8px;
    }
    .alert-danger {
  color: red;
}
</style>