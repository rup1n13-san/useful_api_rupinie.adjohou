<template>
  <div class="flex justify-center items-center h-screen w-screen">
    <div class="bg-gray-100 w-full p-8 rounded-lg space-y-8 max-w-xl">
      <div v-if="message" class="bg-green-100 p-4 text-lg text-gray-500 font-semibold">{{ message}}</div>
      <div v-if="errors" class="bg-red-100">{{ errors.message }}</div>
      <h1 class="text-xl font-semibold text-center ">Login</h1>
      <!--Email-->
      <div class="mb-3">
        <label for="emial" class="block mb-1 text-gray-600 font-bold">Email</label>
        <input type="email" v-model="email" placeholder="example@test.test" class="focus:outline-none border border-gray-300 w-full rounded-lg p-2">
        <span v-if="errors?.email">{{errors.email[0]}}</span>
      </div>
      <!--Password-->
      <div class="mb-3">
        <label for="password" class="block mb-1 text-gray-600 font-bold">Password</label>
        <input type="password" v-model="password" placeholder="*********" class="focus:outline-none border border-gray-300 w-full rounded-lg p-2">
        <span v-if="errors?.password">{{errors.password[0]}}</span>
      </div>
      <!--submit button-->
      <div class="flex justify-center">
        <button @click="login" class="bg-gray-300 p-2 rounded-lg">{{ loading?'loading...':'Login' }}</button>
      </div>
    </div>
    
  </div>
</template>

<script setup>
import { useUserStore } from '@/stores/user';
import { storeToRefs } from 'pinia';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter()

const email = ref("")
const password = ref("")


const userStore = useUserStore()

const {loading, errors, message} = storeToRefs(userStore)




const login = async ()=>{
  const user = {
    "email":email.value,
    "password":password.value
  }

  const ok = userStore.login(user)

  setTimeout(()=>{
    userStore.clearMessage()
    if(ok){
      router.push('/')
    }
  },1500)
  //reset the form 
  email.value = ""
  password.value = ""
}
</script>