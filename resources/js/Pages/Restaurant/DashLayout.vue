
<script >

export default {

    data() {
        return {
            showDropDown: false,
            showSide: true,
            user: "",
            PopUpLogout:false,

        };
    },
    props: ["user"],
    methods: {
        sendMessage() {
            var user = JSON.parse(this.user);
            //do you thing here
        }
    },
    methods: {
        // hide show side bar
        toggleSideBar() {
            this.showSide = !this.showSide;
        },
        // toggle user
        toggleDrop() {
            this.showDropDown = !this.showDropDown;
        },
        ShowLogoutPopup()
        {
          this.PopUpLogout=!this.PopUpLogout;
        },
    },
    created() {
},

    computed: {

    },
    components: {},


}
</script>
<script setup>

import { router } from '@inertiajs/core';
import { watch } from 'vue';
import { Link } from '@inertiajs/vue3';
 const props = defineProps({
   commandes: {},

 });
 const logout = () => {
    router.post(route('logout'));
};


</script>
<template>
    <div class="w-screen h-screen flex  "  >
    <!-- Side bar -->
    <div class="w-[400px] h-full  bg-gray-300 text-white" v-show="showSide" ref="snbar">
      <div class="h-[50px] bg-haver flex justify-start  items-center ">
        <div class="px-[20px]">
          <h3 class="font-bold text-xl text-black"><Link :href="route('dashboard')"><span class="">ClicMiam</span>  Dashboard</Link></h3>
        </div>
      </div>
      <div class="h-[calc(100vh-50px)] bg-slate-200 py-[20px]">
        <div class="flex flex-col justify-between h-full px-[20px] space-y-[10px]">
          <div class=" flex flex-col justify-between space-y-[10px]">
            <Link href="/dashboard"   class="inline-flex text-gray-700 relative items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-gray-200 hover:bg-haver hover:text-gray-900  transition duration-400 ease-in-out">

              Dashboard
            </Link>
            <Link href="/dashboard/articles"   class="inline-flex  text-gray-800 relative items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-gray-200 hover:bg-haver  hover:text-gray-900 transition duration-400 ease-in-out">

              Articles
            </Link>
            <Link :href="route('dashboard.menu')"  class="inline-flex  text-gray-800 relative items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md border-gray-200 hover:bg-haver  hover:text-gray-900 transition duration-400 ease-in-out">

              Menus
            </Link>
            <Link :href="route('dashboard.stats')"  class="inline-flex  text-gray-900 relative items-center py-[10px] px-[10px] w-full text-sm font-medium rounded-md rounded-b-lg hover:bg-haver  hover:text-gray-900 transition duration-400 ease-in-out">

              Statistiques
            </Link>


          </div>
        </div>
      </div>
    </div>
    <div class="w-full h-full bg-gray-400">
      <div class="h-[50px] bg-gray-100 flex items-center shadow-sm px-[20px] w-full py-[10px] z-10 border-b ">
        <!-- Hambuger menu -->
        <div class="cursor-pointer w-[30px]" @click="toggleSideBar">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class=" w-[25px] h-[25px]">
            <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
            <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
          </svg>
        </div>
        <!-- Search bar -->

        <div class="w-[calc(100%-30px)] flex">
          <div class="w-[calc(100%-200px)] flex justify-center ">
            <!-- Search bar -->

          </div>
          <!-- User login -->
          <div class="w-[200px] ">
            <div class="flex items-center justify-start space-x-4" @click="toggleDrop">
              <img class="w-10 h-10 rounded-full border-2 border-gray-500" :src="'/storage/'+$page.props.user.profile_photo_path " alt="">
              <div class="font-semibold text-left">
                <div>{{  $page.props.user.name  }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400 hover:dark:text-gray-800 hover:text-gray-900 ">{{  $page.props.user.role  }}</div>
              </div>
            </div>
            <!-- Drop down -->
            <div v-show="showDropDown" class="absolute right-[10px] z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
              <div class="py-1 text-left" role="none">
                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                <Link :href="route('restau.profile')" class="text-gray-700 block hover:bg-haver hover:text-black px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Infos profil</Link>
                <Link :href="route('profile.show')" class="text-gray-700 block hover:bg-haver hover:text-black px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Paramètre profil</Link>

                  <button @click="ShowLogoutPopup" type="submit" class="text-gray-700 block w-full  hover:bg-haver hover:text-black px-4 py-2 text-left text-sm" role="menuitem" tabindex="-1" id="menu-item-3">Déconnexion</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="h-[calc(100vh-50px)] bg-gray-100 p-[20px] w-full "  >
        <div class=" bg-gray-100 rounded-md p-[20px] h-full overflow-y-auto">
          <router-view>

            <slot/>
          </router-view>
        </div>
      </div>
    </div>
    <!-- Main  -->


  </div>
  <!-- Modal Overlay -->
<div class="fixed inset-0 z-40 flex items-center justify-center bg-black bg-opacity-50" v-if="PopUpLogout" @click.self="ShowLogoutPopup">
  <!-- Modal Container -->
  <div class="bg-white rounded-lg shadow-lg p-6 mx-2 sm:mx-0 max-w-md w-full">
    <!-- Modal Header -->
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-medium text-gray-900">Déconnexion</h3>
      <button class="text-gray-500 hover:text-gray-700 focus:outline-none" @click="closeModal()">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
          <path d="M18 6L6 18M6 6l12 12"></path>
        </svg>
      </button>
    </div>
    <!-- Modal Body -->
    <div class="text-gray-700 mb-6">
      <p>Êtes-vous sûr de vouloir vous déconnecter?</p>
    </div>
    <!-- Modal Footer -->
    <div class="flex justify-end">
      <form method="POST" @submit.prevent="logout">
        <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 focus:outline-none mr-2" >Déconnexion</button>
      </form>
      <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none" @click="ShowLogoutPopup">Annuler</button>
    </div>
  </div>
</div>


</template>
<style scoped>
</style>
