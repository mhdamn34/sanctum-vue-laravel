<template>
    <div class="container">
        <!-- Login Form -->
        <div class="row mt-4">
            <div class="col col-6 offset-3" v-if="!secrets.length">
                <form action="#" @submit.prevent="handleLogin">
                <h3>Sign In</h3>
                    <div class="form-row">
                        <input type="email" name="email" class="form-control" v-model="formData.email" placeholder="Email">
                    </div>
                    <div class="form-row">
                        <input type="password" name="password" class="form-control" v-model="formData.password" placeholder="password">
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
    export default{
        data(){
            return{
                secrets : [],
                formData: {
                    email : '',
                    password : ''
                }
            }
        },
        methods: {
            handleLogin(){
                // send axios request to the login route
                axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.post('/login', this.formData).then(response => {
                        this.getSecrets();
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
</style>