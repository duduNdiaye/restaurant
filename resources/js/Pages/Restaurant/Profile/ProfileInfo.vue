<template>
    <DashLayout>
  <!-- Profile page content here -->
  <div class="p-6">
<div class="p-4  mt-12">
  <div class="grid grid-cols-1 md:grid-cols-3">
    <div class="grid grid-cols-3 text-center order-last md:order-first mt-20 md:mt-0">

      <div>
           <p class="font-bold text-gray-700 text-xl">Articles</p>
        <p class="text-gray-400 text-lg">{{articles}}</p>
      </div>
          <div>
           <p class="font-bold text-gray-700 text-xl">Email</p>
        <p class="text-gray-400">{{ user.email }}</p>
      </div>
    </div>
    <div class="relative">
      <div class="w-48 h-48 bg-indigo-100 mx-auto rounded-full shadow-2xl absolute inset-x-0 top-0 -mt-24 flex items-center justify-center text-indigo-500">
<!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24" viewBox="0 0 20 20" fill="currentColor">
  <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
</svg> -->
<img :src="user.photo" class="h-48 w-48 rounded-full"  :alt="user.name" >
      </div>
    </div>

    <div class="space-x-8 flex   justify-center  mt-32 md:mt-0 md:justify-center md:flex-row " >
<button
  class="text-white py-2 px-4 uppercase rounded bg-blue-400 hover:bg-blue-500 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5"
>

   <Link :href="route('profile.show')">Editer profil</Link>
</button>
    <button
  class="text-white py-2 px-4 uppercase rounded bg-gray-700 hover:bg-gray-800 shadow hover:shadow-lg font-medium transition transform hover:-translate-y-0.5"
>
  <a href="">Deconnexion</a>
</button>
    </div>
    <!-- <div class="flex flex-col md:flex-row items-center justify-center md:justify-end">
  <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-2 md:mx-2 md:my-0">
    Déconnexion
  </button>
  <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-2 md:mx-2 md:my-0">
    Éditer
  </button>
</div> -->

  </div>

  <div class="mt-20 text-center border-b pb-12">
    <h1 class="text-4xl font-medium text-gray-700">{{ user.name }} <span class="font-light text-gray-500">{{user.role}}</span></h1>
    <p class="font-light text-gray-600 mt-3">{{ user.adresse }}</p>

    <p class="mt-8 text-gray-500">{{ user.description }}</p>
    <p class="mt-2 text-gray-500">University of Computer Science</p>
  </div>

  <!-- <div class="mt-12 flex flex-col justify-center">
    <p class="text-gray-600 text-center font-light lg:px-16">An artist of considerable range, Ryan — the name taken by Melbourne-raised, Brooklyn-based Nick Murphy — writes, performs and records all of his own music, giving it a warm, intimate feel with a solid groove structure. An artist of considerable range.</p>
    <button
  class="text-indigo-500 py-2 px-4  font-medium mt-4"
>
  Show more
</button>
  </div> -->

</div>
</div>


    </DashLayout>
</template>
<script>
import { Link } from '@inertiajs/vue3';
import DashLayout from '../DashLayout.vue';

export default{
    components: { DashLayout, Link },
    props:{
        user:Object,
        articles:Object
    }
};
</script>
