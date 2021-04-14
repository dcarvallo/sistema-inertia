<template>
    <div v-if="hasErrors">
        <!-- <div class="font-medium text-red-600">Whoops! Something went wrong.</div> -->

        <ul class="bg-red-100 border-l-4 border-red-500 text-red-700 text-xs my-2 p-2">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        computed: {
            errors() {
                return this.$page.props.errors
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            },
        }
    }
</script>
