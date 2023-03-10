<script setup>
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, onMounted, computed, reactive, ref } from "vue";
import axios from "axios";
const temoin = ref("");
const temoin1 = ref("");
const temoin2 = ref("");
const temoin3 = ref("");
const temoin4 = ref("");
const temoin5 = ref("");
const temoin22 = ref("");
const niveau = ref("");
const i = ref();
const i1 = ref(1);
const i2 = ref(2);
const i3 = ref(3);
const i4 = ref(4);
const i5 = ref(5);

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  articles: {},
  users: {},
});

const shake = () => {
  isShaking.value = true;
  setTimeout(() => {
    isShaking.value = false;
  }, 1000);
};

const nombre = ref(0);
const Noter = (i) => {
  if (i == 1) {
    niveau.value = "insatisfaisant";
    nombre.value = 1;
  } else if (i == 2) {
    niveau.value = "moyen";
    nombre.value = 2;
  } else if (i == 3) {
    niveau.value = "agreable";
    nombre.value = 3;
  } else if (i == 4) {
    niveau.value = "excellent";
    nombre.value = 4;
  } else {
    niveau.value = "inoubliable";
    nombre.value = 5;
  }
};

const Note = (i) => {
  if (i == 1) {
    nombre.value = 1;
  } else if (i == 2) {
    nombre.value = 2;
  } else if (i == 3) {
    nombre.value = 3;
  } else if (i == 4) {
    nombre.value = 4;
  } else {
    nombre.value = 5;
  }

  console.log(nombre.value);
};
</script>
<template>
  <header>
    <nav
      id="navbar"
      class="fixed md:flex bg-white border-gray-100 border-b-2 z-40 transform-cpu text-center items-center justify-between px-4 py-3 w-full"
    >
      <div class="flex items-center">
        <h1
          class="text-3xl lg:block md:block hidden lg:ml-0 text-center bg-black text-white px-2 md:ml-0 font-title font-extrabold"
        >
          EatEasy
        </h1>
        <ApplicationMark class="h-9 w-auto lg:hidden md:hidden" />
        <div>
          <p class="font-bold text-xl ml-8 lg:hidden md:hidden" v-if="texte">
            Que desirez-vous manger?
          </p>
        </div>
        <div
          class="pt-2 relative md:hidden lg:block sm:block mx-auto text-gray-600"
          v-if="showSearchBar"
        >
          <input
            v-model="articlerecherche"
            @keydown.enter="scrollToResults"
            class="border-none bg-gray-200 focus:ring-vert focus:border-none lg:ml-16 lg:w-96 h-[3rem] px-5 pr-16 rounded-lg text-sm focus:outline-none"
            type="search"
            name="search"
            placeholder="Search"
          />
          <button class="absolute right-0 top-0 mt-5 mr-4">
            <svg
              class="text-gray-600 h-4 w-4 fill-current"
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              version="1.1"
              id="Capa_1"
              x="0px"
              y="0px"
              viewBox="0 0 56.966 56.966"
              style="enable-background: new 0 0 56.966 56.966"
              xml:space="preserve"
              width="512px"
              height="512px"
            >
              <path
                d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z"
              />
            </svg>
          </button>
        </div>
      </div>

      <div
        class="md:flex bg-white lg:border-none md:border-none lg:bg-opacity-0 border-t-2 border-b-2 border-gray-200 md:items-center md:px-0 px-3 md:pb-0 pb-10 md:static absolute md:w-auto w-full top-14 duration-300 ease-in"
        :class="[open ? 'left-0' : 'left-[-100%]']"
      >
        <div class="md:mx-4 md:my-0 my-6 flex">
          <button
            @click="(showModal = !showModal), (showModal1 = !showModal1)"
            class="px-3 text-black py-2 font-bold hover:text-indigo-600"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"
              />
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"
              />
            </svg>
          </button>
          <span class="text-black font-bold mt-2 w-[6rem] h-5 rounded-full"
            >Ma position</span
          >
        </div>
        <div class="md:mx-4 md:my-0 my-6">
          <a :href="route('resto.accueil')" class="text-black font-bold"
            >Nos restaurants</a
          >
        </div>
        <div class="md:mx-4 md:my-0 my-6">
          <a
            href="#"
            class="text-black px-3 py-2 font-bold text-black hover:text-indigo-600"
            >Contact</a
          >
        </div>
        <div v-if="canLogin" class="flex flex-col md:flex-row md:my-0 my-6">
          <a
            v-if="$page.props.user"
            :href="route('dashboard')"
            class="px-3 py-2 bg-vert font-bold text-white rounded hover:bg-haver mt-3 md:mt-0"
            >Button 1</a
          >

          <template v-else>
            <a
              :href="route('login')"
              class="px-3 py-2 lg:ml-4 md:ml-4 text-center bg-vert font-bold text-white rounded hover:bg-haver mt-3 md:mt-0"
              >Login
            </a>
            <a
              v-if="canRegister"
              :href="route('register')"
              class="px-3 py-2 lg:ml-4 md:ml-4 font-bold text-center bg-vert text-white rounded hover:bg-haver mt-3 md:mt-0"
              >Register
            </a>
          </template>
        </div>
      </div>
    </nav>
  </header>
  <div class="relative w-full h-[33rem] overflow-hidden">
    <div class="carousel">
      <div class="carousel-inner">
        <div :class="['carousel-item', index1 === current ? 'active' : '']">
          <img
            src="../../../../storage/app/public/pexels-chan-walrus-958545.jpg"
            alt="item.caption"
            class="w-full"
          />
          <div class="carousel-caption flex justify-center items-center flex flex-col">
            <h3
              :class="`shake ${shak ? 'animate-shake ' : ''}`"
              class="text-6xl text-white font-bold bg-black w-fit"
            >
              Bienvenue sur EATEASY
            </h3>
            <p
              class="text-gray-500 opacity-0 translate-y-2 transition-opacity transition-transform duration-500 ease-out"
            >
              C'est la premiere
            </p>
          </div>
        </div>
        <div :class="['carousel-item', index2 === current ? 'active' : '']">
          <img
            src="../../../../storage/app/public/pexels-ella-olsson-3026808.jpg"
            alt="item.caption"
            class="w-full"
          />
          <div class="carousel-caption flex flex-col items-center justify-center">
            <h3   class="text-4xl text-white font-black bg-black w-96">
              Votre site de commande en ligne
            </h3>
            <p
              class="text-gray-500 opacity-0 translate-y-2 transition-opacity transition-transform duration-500 ease-out"
            >
              item.description
            </p>
          </div>
        </div>
        <div :class="['carousel-item', index3 === current ? 'active' : '']">
          <img
            src="../../../../storage/app/public/pexels-narda-yescas-1566837.jpg"
            alt="item.caption"
            class="w-full"
          />
          <div class="carousel-caption flex flex-col items-center justify-center">
            <h3    :class="`shake ${shak ? 'animate-shake ' : ''}`" class="text-4xl text-white font-black bg-black w-96">
              Dans vos restaurants preferes
            </h3>
            <p
              class="text-gray-500 opacity-0 translate-y-2 transition-opacity transition-transform duration-500 ease-out"
            >
              item.description
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="flex border-t border-solid border-border-200 border-opacity-100">
    <aside
      ref="aside"
      class="bg-white lg:w-[27rem] lg:block hidden h-[39.2rem] p-3 px-8 overflow-y-auto"
    >
      <div class="max-h-full flex-grow overflow-hidden mt-8">
        <span class="text-xl font-bold">Trier</span>
        <ul class="text-gray-700 mt-6 space-y-3">
          <li class="space-x-3">
            <input
              type="radio"
              id="option1"
              name="options"
              value="option1"
              class="appearance-none border-4 border-gray-500 checked:text-black checked:bg-black checked:border-transparent focus:ring-0 outline-none focus:outline-none w-5 h-5"
            />
            <span class="text-black text-[0.9rem] font-extrabold"
              >Les restaurants (par defaut)</span
            >
          </li>
          <li class="space-x-3">
            <input
              type="radio"
              id="option2"
              name="options"
              value="option2"
              class="w-5 h-5 border-4 border-gray-500 focus:ring-0 checked:text-black checked:bg-black checked:border-transparent"
            />
            <span class="text-black text-md font-extrabold">Les plus populaires</span>
          </li>
          <li class="space-x-3">
            <input
              type="radio"
              id="option3"
              name="options"
              value="option3"
              class="w-5 h-5 border-4 border-gray-500 focus:ring-0 checked:text-black checked:bg-black checked:border-transparent"
            />
            <span class="text-black text-md font-extrabold"
              >Restaurants avec livraison</span
            >
          </li>
        </ul>
        <div class="mt-10">
          <span class="text-lg font-bold">Categorie de Nourriture</span>
          <ul class="text-gray-700 mt-6 space-y-3">
            <li class="space-x-4 flex">
              <svg
                fill="#000000"
                width="64px"
                height="64px"
                viewBox="0 0 32 32"
                id="dish"
                version="1.1"
                xml:space="preserve"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
              >
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g
                  id="SVGRepo_tracerCarrier"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                ></g>
                <g id="SVGRepo_iconCarrier">
                  <g>
                    <path
                      d="M15,8H17c0.6,0,1-0.4,1-1s-0.4-1-1-1H15c-0.6,0-1,0.4-1,1S14.4,8,15,8z"
                    ></path>
                    <path
                      d="M29.9,20.5C29.7,20.2,29.3,20,29,20h-1.1c-0.5-4.4-4.1-8.8-8.7-10.2c-2.1-0.7-4.4-0.7-6.5,0C8.2,11.2,4.5,15.6,4.1,20H3 c-0.3,0-0.7,0.2-0.9,0.5s-0.2,0.7,0,1C3.5,24.3,6.3,26,9.5,26h13.1c3.1,0,6-1.7,7.4-4.6C30,21.1,30,20.8,29.9,20.5z M13.3,11.7 c1.7-0.5,3.6-0.5,5.3,0c3.7,1.1,6.8,4.7,7.3,8.3H6.1C6.6,16.4,9.6,12.9,13.3,11.7z M22.5,24H9.5c-1.8,0-3.4-0.7-4.6-2h22.2 C25.9,23.3,24.3,24,22.5,24z"
                    ></path>
                  </g>
                </g>
              </svg>
              <span class="text-black text-[1rem] font-extrabold">Plats nationaux</span>
            </li>
            <li class="space-x-4 flex">
              <svg
                fill="#000000"
                width="64px"
                height="64px"
                viewBox="0 0 512 512"
                xmlns="http://www.w3.org/2000/svg"
              >
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g
                  id="SVGRepo_tracerCarrier"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                ></g>
                <g id="SVGRepo_iconCarrier">
                  <title>ionicons-v5-l</title>
                  <path
                    d="M384,352H184.36l-41,35-41-35H16v24c0,30.59,21.13,55.51,47.26,56,2.43,15.12,8.31,28.78,17.16,39.47C93.51,487.28,112.54,496,134,496H266c21.46,0,40.49-8.72,53.58-24.55,8.85-10.69,14.73-24.35,17.16-39.47,13.88-.25,26.35-7.4,35-18.63A61.26,61.26,0,0,0,384,376Z"
                  ></path>
                  <path
                    d="M105,320h0l38.33,28.19L182,320H384v-8a40.07,40.07,0,0,0-32-39.2c-.82-29.69-13-54.54-35.51-72C295.67,184.56,267.85,176,236,176H164c-68.22,0-114.43,38.77-116,96.8A40.07,40.07,0,0,0,16,312v8h89Z"
                  ></path>
                  <path
                    d="M463.08,96H388.49l8.92-35.66L442,45,432,16,370,36,355.51,96H208v32h18.75l1.86,16H236c39,0,73.66,10.9,100.12,31.52A121.9,121.9,0,0,1,371,218.07a124.16,124.16,0,0,1,10.73,32.65,72,72,0,0,1,27.89,90.9A96,96,0,0,1,416,376c0,22.34-7.6,43.63-21.4,59.95a80,80,0,0,1-31.83,22.95,109.21,109.21,0,0,1-18.53,33c-1.18,1.42-2.39,2.81-3.63,4.15H416c16,0,23-8,25-23l36.4-345H496V96Z"
                  ></path>
                </g>
              </svg>
              <span class="text-black text-md font-extrabold">Fast Food</span>
            </li>
            <li class="space-x-4 flex">
              <svg
                fill="#000000"
                width="64px"
                height="64px"
                viewBox="0 -3.84 122.88 122.88"
                version="1.1"
                id="Layer_1"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                style="enable-background: new 0 0 122.88 115.21"
                xml:space="preserve"
              >
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g
                  id="SVGRepo_tracerCarrier"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                ></g>
                <g id="SVGRepo_iconCarrier">
                  <g>
                    <path
                      d="M29.03,100.46l20.79-25.21l9.51,12.13L41,110.69C33.98,119.61,20.99,110.21,29.03,100.46L29.03,100.46z M53.31,43.05 c1.98-6.46,1.07-11.98-6.37-20.18L28.76,1c-2.58-3.03-8.66,1.42-6.12,5.09L37.18,24c2.75,3.34-2.36,7.76-5.2,4.32L16.94,9.8 c-2.8-3.21-8.59,1.03-5.66,4.7c4.24,5.1,10.8,13.43,15.04,18.53c2.94,2.99-1.53,7.42-4.43,3.69L6.96,18.32 c-2.19-2.38-5.77-0.9-6.72,1.88c-1.02,2.97,1.49,5.14,3.2,7.34L20.1,49.06c5.17,5.99,10.95,9.54,17.67,7.53 c1.03-0.31,2.29-0.94,3.64-1.77l44.76,57.78c2.41,3.11,7.06,3.44,10.08,0.93l0.69-0.57c3.4-2.83,3.95-8,1.04-11.34L50.58,47.16 C51.96,45.62,52.97,44.16,53.31,43.05L53.31,43.05z M65.98,55.65l7.37-8.94C63.87,23.21,99-8.11,116.03,6.29 C136.72,23.8,105.97,66,84.36,55.57l-8.73,11.09L65.98,55.65L65.98,55.65z"
                    ></path>
                  </g>
                </g>
              </svg>
              <span class="text-black text-md font-extrabold">Toutes categories</span>
            </li>
          </ul>
        </div>
      </div>
    </aside>
    <div class="w-full h-fit px-4 pb-8 mb-12 lg:p-8">
      <div
        id="results"
        class="grid lg:grid-cols-[repeat(auto-fill,minmax(270px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3"
      >
        <article
          v-for="user in users"
          :key="user.id"
          class="product-card cart-type-neon overflow-hidden bg-white"
        >
          <span
            class="block overflow-hidden w-auto lg:h-56 bg-transparent opacity-100 lg:m-0 lg:p-0 lg:inset-0 m-0 p-0 inset-0"
          >
            <a :href="route('restaurant.details', user.id)" class="rounded-md">
              <img
                :src="user.photo"
                alt="Product image"
                class="w-[32rem] h-40 mb-6 product-image"
              />
            </a>
            <header
              class="md:p-6 lg:mt-[-3rem] mt-[-1.5rem] lg:ml-[-1.4rem] lg:mr-[-1.4rem]"
            >
              <div class="flex">
                <span class="text-lg lg:text-xl font-semibold text-heading md:text-base">
                  {{ user.name }}</span
                >

                <div class="flex space-x-1 bg-gray-200 rounded-full px-2 ml-auto mt-2">
                  <svg
                    width="64px"
                    height="64px"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                  >
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g
                      id="SVGRepo_tracerCarrier"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    ></g>
                    <g id="SVGRepo_iconCarrier">
                      <path
                        d="M21.12 9.88005C21.0781 9.74719 20.9996 9.62884 20.8935 9.53862C20.7873 9.4484 20.6579 9.38997 20.52 9.37005L15.1 8.58005L12.67 3.67005C12.6008 3.55403 12.5027 3.45795 12.3853 3.39123C12.2678 3.32451 12.1351 3.28943 12 3.28943C11.8649 3.28943 11.7322 3.32451 11.6147 3.39123C11.4973 3.45795 11.3991 3.55403 11.33 3.67005L8.89999 8.58005L3.47999 9.37005C3.34211 9.38997 3.21266 9.4484 3.10652 9.53862C3.00038 9.62884 2.92186 9.74719 2.87999 9.88005C2.83529 10.0124 2.82846 10.1547 2.86027 10.2907C2.89207 10.4268 2.96124 10.5512 3.05999 10.6501L6.99999 14.4701L6.06999 19.8701C6.04642 20.0091 6.06199 20.1519 6.11497 20.2826C6.16796 20.4133 6.25625 20.5267 6.36999 20.6101C6.48391 20.6912 6.61825 20.7389 6.75785 20.7478C6.89746 20.7566 7.03675 20.7262 7.15999 20.6601L12 18.1101L16.85 20.6601C16.9573 20.7189 17.0776 20.7499 17.2 20.7501C17.3573 20.7482 17.5105 20.6995 17.64 20.6101C17.7537 20.5267 17.842 20.4133 17.895 20.2826C17.948 20.1519 17.9636 20.0091 17.94 19.8701L17 14.4701L20.93 10.6501C21.0305 10.5523 21.1015 10.4283 21.1351 10.2922C21.1687 10.1561 21.1634 10.0133 21.12 9.88005Z"
                        fill="#000000"
                      ></path>
                    </g>
                  </svg>
                  <span
                    class="text-black font-bold text-sm flex items-center justify-center"
                    >{{ user.notation }}</span
                  >
                </div>
              </div>
              <div class="flex">
                <div class="flex space-x-3">
                  <svg
                    width="64px"
                    height="64px"
                    viewBox="0 -0.05 26.1 26.1"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="#000000"
                  >
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g
                      id="SVGRepo_tracerCarrier"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    ></g>
                    <g id="SVGRepo_iconCarrier">
                      <g
                        id="Group_719"
                        data-name="Group 719"
                        transform="translate(-50 -100)"
                      >
                        <path
                          id="Path_1486"
                          data-name="Path 1486"
                          d="M63,126c-7.2,0-13-1.6-13-3.5,0-1.3,2.6-2.4,6.5-3l1.6,1.7c-3.6.2-5.5.8-5.5,1.3,0,.8,4.3,1.5,10.4,1.5s10.5-.7,10.5-1.5c0-.6-1.9-1.1-5.5-1.3l1.6-1.7c3.9.6,6.5,1.7,6.5,3C76,124.4,70.2,126,63,126Zm4-17a4,4,0,1,1-4-4A4.012,4.012,0,0,1,67,109Zm-6,0a2,2,0,1,0,2-2A2.006,2.006,0,0,0,61,109Zm3,12-1,1-1-1c-.3-.4-6.6-5.8-7.8-10.5-.1-.3-.3-1.4.8-1.5.9-.1,1.1,1,1.1,1,.8,3.5,5.2,6.9,6.9,9,1.8-2.3,7-6.1,7-10,0-4.5-2.6-7-7-7-3.3,0-5.6,1.4-6.5,4,0,0-.4,1.2-1.1,1-.8-.2-.9-.8-.6-1.7A9,9,0,0,1,72,109C72,114,64.4,120.6,64,121Z"
                          fill="#444"
                        ></path>
                      </g>
                    </g>
                  </svg>
                  <span>{{ user.adresse }}</span>
                </div>
                <span
                  v-if="temoin == user.id"
                  class="text-vert ml-auto text-sm font-bold"
                  >{{ niveau }}</span
                >
              </div>
            </header>
          </span>
        </article>
      </div>
    </div>
  </div>
</template>
<script>
import "v-calendar/dist/style.css";
export default {
  data() {
    return {
      rating: this.initialRating,
      stars: [1, 2, 3, 4, 5],
      visit: "",
      hov: false,
      index1: 0,
      index2: 1,
      index3: 2,
      shak: false,

      current: 0,
    };
  },

  created() {
    setInterval(() => {
      this.current = (this.current + 1) % 3;
      this.shak = true;
    }, 5000);
  },

  props: {
    users: Object,
    initialRating: {
      type: Number,
      default: 0,
    },
  },

  mounted() {
    console.log(this.users[1].name);
  },
};
</script>
<style scoped>
.bg-resto {
  background-image: url(../../../../storage/app/public/fondresto.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-color: rgba(255, 255, 255, 0.5);
}

svg {
  height: 1.5rem;
  width: 1.5rem;
}

.carousel {
  position: relative;
  height: 0;
  padding-bottom: 60%;
}

.carousel-inner {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

.carousel-item {
  position: absolute;
  top: 0;
  bottom: 10%;
  left: 0;
  right: 0;
  opacity: 0;
  transition: opacity 0.6s ease-in-out;
}

.carousel-item.active {
  opacity: 1;
}

.carousel-caption {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  text-align: center;
}

@media (min-width: 640px) {
  .carousel {
    height: 0;
    padding-bottom: 40%;
  }
}

@media (min-width: 768px) {
  .carousel {
    height: 0;
    padding-bottom: 33.33%;
  }
}

@media (min-width: 1024px) {
  .carousel {
    height: 0;
    padding-bottom: 25%;
  }
}

@media (prefers-reduced-motion: no-preference) {
  .carousel-caption p {
    animation: slide-in 0.5s ease-out both;
  }
}

@keyframes slide-in {
  from {
    opacity: 0;
    transform: translate3d(0, 8px, 0);
  }
  to {
    opacity: 1;
    transform: translate3d(0, 0, 0);
  }
}

.shake {
  display: inline-block;
  animation-duration: 1s;
  animation-fill-mode: both;
}

@keyframes shake {
  0% {
    transform: translateX(0);
  }
  10%,
  30%,
  50%,
  70%,
  90% {
    transform: translateX(-5px);
  }
  20%,
  40%,
  60%,
  80% {
    transform: translateX(10px);
  }
  100% {
    transform: translateX(0);
  }
}

.animate-shake {
  animation-name: shake;
}
</style>
