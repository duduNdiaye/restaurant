<template>
    <DashLayout>
        <div class=" px-4 py-6 sm:px-6 lg:px-8 lg:py-8 mt-4">
  <!-- Profile page content here -->

  <div class="flex items-center justify-center h-full">
  <div class="w-full md:w-2/3 max-w-md mx-auto">
    <div class="bg-white hover:bg-slate-200 rounded-lg shadow-lg overflow-hidden">
      <div class="relative h-48">
        <img class="mx-auto h-36 w-36 mt-8 rounded-full" src="https://source.unsplash.com/random/400x400" alt="Profile picture">
      </div>
      <div class="p-4 ">
        <h1 class="text-2xl font-bold text-gray-800 mb-2"> {{ user.name }}</h1>
        <p class="text-gray-600 mb-4">{{ user.description }}.</p>
        <div class="flex items-center mb-2">
          <svg class="h-5 w-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path>
            <circle cx="12" cy="10" r="3"></circle>
          </svg>
          <span class="text-gray-600">{{ user.adresse }}</span>

        </div>
        <p class="text-gray-600 mb-4">{{ user.tel }}.</p>
        <div class="flex items-center mb-2">
          <svg class="h-5 w-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16s1.5-2 4-2 4 2 4 2"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16s-1.5-2-4-2-4 2-4 2"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22V11"></path>
          </svg>
          <span class="text-gray-600">
            {{user.email}}</span>
    </div>
    <div class="flex items-center mb-2">
      <svg class="h-5 w-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15s1-2 4-2 4 2 4 2v3H4v-3z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 15s-1-2-4-2-4 2-4 2v3h8v-3z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 10.5s0-2-4-2-4 2-4 2"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22V12"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V2h8v5"></path>
      </svg>
      <span class="text-gray-600">Open from 9:00am to 5:00pm</span>
    </div>
    <div class="  flex flex-row justify-center ">
<div>
    <a href="#" class="flex justify-start ">
  <svg class="h-6 w-6 text-gray-400 hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
  </svg>

</a>
</div>

<div class=" flex justify-end items-end ml-4">
    <a href="#" class="">
  <svg class="h-6 w-6 text-gray-400 hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-6-5a5 5 0 110 10 5 5 0 010-10z"/>
  </svg>

</a>
</div>

    </div>
  </div>

</div>

</div>
</div>

</div>

</DashLayout>
</template>
<script>
import DashLayout from '../DashLayout.vue';

export default{
    components: { DashLayout },
    props:{
        user:Object
    }
};
</script>
