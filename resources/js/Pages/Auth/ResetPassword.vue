<template>
 <app-layout>
    <jet-authentication-card>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="mt-4">
                <jet-label for="password" value="Password actual" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.actual" required autocomplete="new-password" />
            </div>
            <div class="mt-4">
                <jet-label for="nuevo" value="Nuevo password" />
                <jet-input id="nuevo" type="password" class="mt-1 block w-full" v-model="form.nuevo" required autocomplete="Nuevo passowrd" />
            </div>

            <div class="mt-4">
                <jet-label for="nuevo_confirmation" value="Confirmar Password" />
                <jet-input id="nuevo_confirmation" type="password" class="mt-1 block w-full" v-model="form.nuevo_confirmation" required autocomplete="nuevo-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Cambiar contraseña
                </jet-button>
            </div>
        </form>
    </jet-authentication-card>
   </app-layout>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors,
            AppLayout
        },

        props: {
            token: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: this.token,
                    actual: '',
                    nuevo: '',
                    nuevo_confirmation: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('cambiar.password.update'), {
                    // onFinish: () => this.form.reset('nuevo', 'nuevo_confirmation'),
                })
            }
        }
    }
</script>
