<script setup>
import { useModuleStore } from '@/stores/module';
import { useUrlStore } from '@/stores/url';
import { useUserStore } from '@/stores/user';
import { onMounted } from 'vue';

const userStore = useUserStore();
const moduleStore = useModuleStore();
const urlStore = useUrlStore();

onMounted(async () => {
	await moduleStore.getModules();
  await urlStore.getUrls()
});

const changeState = async (state, index) => {
  if(state === "off"){
    moduleStore.activate(index+1)
  }else{
    moduleStore.deactivate(index+1)
  }
};
</script>

<template>
	<div class="flex h-screen overflow-hidden bg-gray-100">
		<aside class="top-0 left-0 fixed w-[300px] bg-white border- h-screen space-y-8">
			<h1 class="text-3xl text-center text-gray-700 font-semibold mb-5 p-4">
				welcome {{ userStore?.connectedUser.name }}
			</h1>

			<div class="space-y-3">
				<div
					v-for="(value, key, index) in moduleStore.modules"
					class="flex hover:bg-gray-200 rounded-md px-4 py-2 justify-between"
				>
					<div>
						<span class="font-bold text-gray-600">{{ key }}</span> : {{ value }}
					</div>
					<button @click="changeState(value, index)" class="cursor-pointer p-1 text-xs rounded-md" :class="value==='off'?'bg-green-200':'bg-red-200'">
						{{ value === 'off' ? 'activate' : 'deactivate' }}
					</button>
				</div>
			</div>
		</aside>
		<div class="flex flex-1 relative flex-col overflow-y-auto overflow-x-hidden">
      <div class="text-3xl text-gray-800">
        All links 
      </div>
      <div class="flex flex-col">
        <div v-for="url in urlStore.urls" class="flex justify-between mb-">
          <span>{{ url.original_url }}</span>
          <span>{{ url.custom_code }}</span>
          <span>{{ url.cliks }}</span>
        </div>
      </div>
    </div>
	</div>
</template>
