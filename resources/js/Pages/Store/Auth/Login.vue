<template>
  <div class="h-screen flex justify-center items-center">
    <!-- add logo here  nad its text "Tree Mall" -->
    <form class="mx-auto w-1/4" @submit.prevent="submit">
     <h1 class="text-2xl font-semibold text-center underline italic">Tree Mall</h1>
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
            Email
          </label>
          <Input
            class="appearance-none block w-full mx-auto text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            id="email"
            v-model="form.email"
            type="email"
            :class="{ 'border-red-500': errors.email }" />
          <p v-if="errors.email" class="text-red-500 text-xs italic mt-4">{{ errors.email[0] }}</p>
        </div>
      </div>
      <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full px-3">
          <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
            Password
          </label>
          <Input
            class="appearance-none block w-full mx-auto  text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
            id="password"
            v-model="form.password"
            type="password"
            :class="{ 'border-red-500': errors.password }" />
          <p v-if="errors.password" class="text-red-500 text-xs italic mt-4">{{ errors.password[0] }}</p>
        </div>
      </div>
      <div class="flex flex-wrap -mx-3 mb-2">
        <div class="w-full md:w-full px-3 mb-6 md:mb-0">
            <MainButton @click="login" class="w-full"  type="submit">
                Login
            </MainButton>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import  Input  from '@/Components/Input.vue'
    import MainButton from '@/Components/Buttons/MainButton.vue';
    export default {
        components: {
            AppLayout,
            Input,
            MainButton,
        },
        data() {
            return {
                form: {
                    email: '',
                    password: '',
                },
                errors: {},
            }
        },
        methods: {
            login() {
                this.$inertia.post('/login', this.form, {
                    onError: (error) => {
                        this.errors = error.response.data.errors
                    },
                })
            },
        },
    }
</script>
