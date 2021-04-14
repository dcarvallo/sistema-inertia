<template>
    <div class="h-screen flex justify-center content-center">
     
      <div class="self-center py-3 card px-20 flex flex-col justify-center content-center" >
       
       

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <div class="card-header">
          <h3 class="font-bold text-2xl">Inicio de sesión</h3>
        </div>
        <br>
         <jet-validation-errors class="mb-4" />
        <form @submit.prevent="submit">
            <div>
                <label class="text-white" for="username" >Usuario</label>
                <jet-input id="username" type="username" class="p-2 w-full rounded bg-white border border-gray-600" v-model="form.username" autofocus required autocomplete="off"/>
            </div>

            <div class="mt-4">
                <label class="text-white" for="password">Password</label>
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
              
                <button class="ml-4 bg-yellow-400 text-gray-700 p-2 rounded hover:bg-yellow-300" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Ingresar
                </button>
            </div>
        </form>
    </div>
  </div>
</template>

<script>
    import JetInput from '@/Jetstream/Input'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetInput,
            JetValidationErrors
        },

        props: {
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    username: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
<style>
  html,body{
    background-image: url('/img/fondologin.jpg');
    background-size: cover;
    background-repeat: no-repeat;
    height: 100%;
    font-family: 'Numans', sans-serif;
  }

  .container{
    height: 100%;
    align-content: center;
  }

  .card{
    min-height: 320px;
    margin-top: auto;
    margin-bottom: auto;
    width: 400px;
    background-color: rgba(0,0,0,0.5) !important;
  }

  .card-header h3{
    color: white;
  }

</style>