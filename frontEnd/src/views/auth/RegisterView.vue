<template>
  <div class="flex justify-center items-center h-screen w-screen">
    <div v-if="message" class="bg-green-100">{{ message }}</div>
    <div v-if="errors" class="bg-red-100">{{ errors }}</div>
    <div class="bg-gray-100 w-full p-8 rounded-lg space-y-8 max-w-xl">
      <h1 class="text-xl font-semibold text-center ">Registration</h1>
      <!--Name-->
      <div class="mb-3">
        <label for="name" class="block mb-1 text-gray-600 font-bold">Name</label>
        <input type="text" v-model="name" placeholder="Enter your name" class="focus:outline-none border border-gray-300 w-full rounded-lg p-2">
        <span v-if="errors?.name" class="text-red text-md">{{errors.name[0]}}</span>
      </div>
      <!--Email-->
      <div class="mb-3">
        <label for="name" class="block mb-1 text-gray-600 font-bold">Email</label>
        <input type="email" v-model="email" placeholder="example@test.test" class="focus:outline-none border border-gray-300 w-full rounded-lg p-2">
        <span v-if="errors?.email">{{errors.email[0]}}</span>
      </div>
      <!--Password-->
      <div class="mb-3">
        <label for="password" class="block mb-1 text-gray-600 font-bold">Password</label>
        <input type="password" v-model="password" placeholder="*********" class="focus:outline-none border border-gray-300 w-full rounded-lg p-2">
        <span v-if="errors?.password">{{errors.password[0]}}</span>
      </div>
      <!--password_confirmation-->
      <div class="mb-3">
        <label for="password_confirmation" class="block mb-1 text-gray-600 font-bold"> Confirm Password</label>
        <input type="password" v-model="password_confirmation" placeholder="*********" class="focus:outline-none border border-gray-300 w-full rounded-lg p-2">
      </div>
      <!--submit button-->
      <div>
        <button @click="register" class="bg-gray-300 p-2 rounded-lg">{{ loading?'registration':'register' }}</button>
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

const name = ref("")
const email = ref("")
const password = ref("")
const password_confirmation = ref("")


const userStore = useUserStore()

const {loading, errors, message} = storeToRefs(userStore)

if(password.value !== password_confirmation.value){
  console.log("oops")
}



const register = async ()=>{
  const user = {
    "name":name.value,
    "email":email.value,
    "password":password.value,
    "password_confirmation": password_confirmation.value
  }

  const ok = userStore.register(user)

  setTimeout(()=>{
    userStore.clearMessage()
    if(ok){
      router.push('/login')
    }
  },1500)
  //reset the form 
  name.value = ""
  email.value = ""
  password.value = ""
  password_confirmation.value = ""
}
</script>