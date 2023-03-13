<script setup>
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, onMounted, computed, reactive, ref } from "vue";
import axios from "axios";
const temoin = ref("");
const cart = ref([]);
const count = ref(0);
const count1 = ref(false);
const contenu = ref("Articles");
const showComponent = ref(false);

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  articles: {},
  users: {},
});


const total = computed(() => {
  return cart.value.reduce((acc, item) => acc + item.prix * item.quantite, 0);
});

const removeItemFromCart = (car) => {
  let index = cart.value.findIndex((item) => item.nom === car.nom);
  if (index === -1) {
    return;
  } else {
    cart.value[index].quantite = 0;
    if (cart.value[index].quantite === 0) {
      cart.value.splice(index, 1);
      count.value--;
    }
  }
  count.value = cart.value.length;
  if (count.value == 0) {
    count1.value = false;
  }

  // enregistrer les données du panier dans le localStorage
  localStorage.setItem("cart", JSON.stringify(cart.value));
};

const Augmenter = (car) => {
  let index = cart.value.findIndex((item) => item.nom === car.nom);
  if (index === -1) {
    return;
  } else {
    cart.value[index].quantite++;
    cart.value[index].total += parseFloat(car.prix);
  }
};
const Diminuer = (car) => {
  let index = cart.value.findIndex((item) => item.nom === car.nom);
  if (index === -1) {
    return;
  } else {
    if (cart.value[index].quantite > 1) {
      // vérifie si la quantité est supérieure à 1
      cart.value[index].quantite--;
      cart.value[index].total -= parseFloat(car.prix);
    }
    if (cart.value[index].quantite === 1) {
      // vérifie si la quantité est égale à 1
      // ne fait rien
    }
    if (cart.value[index].quantite === 0) {
      // vérifie si la quantité est égale à 0
      cart.value.splice(index, 1);
      count.value -= 1;
    }

    if (count.value === 0) {
      count1.value = false;
    }

    localStorage.setItem("cart", JSON.stringify(cart.value));
  }
};

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
            <h3 class="text-4xl text-white font-black bg-black w-96">
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
            <h3
              :class="`shake ${shak ? 'animate-shake ' : ''}`"
              class="text-4xl text-white font-black bg-black w-96"
            >
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
  <section class="text-gray-600 body-font bg-white mt-1">
    <div class="container px-2 py-4 mx-auto flex flex-wrap lg:block md:block hidden">
      <div class="flex flex-wrap -m-4">
        <div
          class="p-4 lg:w-4/12 w-full lg:block md:block hidden hover:scale-105 transition duration-200"
        >
          <div
            class="flex items-center justify-center bg-rose border-2 rounded-lg border-gray-200 border-opacity-50 p-4 sm:flex-row flex-col"
          >
            <div
              class="w-16 h-16 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0"
            >
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                class="w-8 h-8"
                viewBox="0 0 24 24"
              >
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
              </svg>
            </div>
            <div class="flex-grow">
              <h2 class="text-white text-2xl title-font font-bold mb-3">
                Traitement rapide
              </h2>
              <p class="leading-relaxed text-white text-base">
                Blue bottle crucifix vinyl post-ironic four dollar
              </p>
              <a class="mt-3 text-white inline-flex items-center"
                >Learn More
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  class="w-4 h-4 ml-2"
                  viewBox="0 0 24 24"
                >
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div
          class="p-4 lg:w-4/12 w-full lg:block md:block hidden hover:scale-105 transition duration-200"
        >
          <div
            class="flex items-center justify-center bg-jaune border-2 rounded-lg border-gray-200 border-opacity-50 p-4 sm:flex-row flex-col"
          >
            <div
              class="w-16 h-16 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0"
            >
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                class="w-8 h-8"
                viewBox="0 0 24 24"
              >
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
              </svg>
            </div>
            <div class="flex-grow">
              <h2 class="text-white text-2xl title-font font-bold mb-3">
                Traitement efficace
              </h2>
              <p class="leading-relaxed text-white text-base">
                Blue bottle crucifix vinyl post-ironic four dollar
              </p>
              <a class="mt-3 text-white inline-flex items-center"
                >Learn More
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  class="w-4 h-4 ml-2"
                  viewBox="0 0 24 24"
                >
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
        <div
          class="p-4 lg:w-4/12 w-full lg:block md:block hidden hover:scale-105 transition duration-200"
        >
          <div
            class="flex items-center justify-center bg-vert border-2 rounded-lg border-gray-200 border-opacity-50 p-4 sm:flex-row flex-col"
          >
            <div
              class="w-16 h-16 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0"
            >
              <svg
                fill="none"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                class="w-10 h-10"
                viewBox="0 0 24 24"
              >
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="flex-grow">
              <h2 class="text-white text-2xl title-font font-bold mb-3">
                Traitement securise
              </h2>
              <p class="leading-relaxed text-white text-base">
                Blue bottle crucifix vinyl post-ironic four dollar
              </p>
              <a class="mt-3 text-white inline-flex items-center"
                >Learn More
                <svg
                  fill="none"
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  class="w-4 h-4 ml-2"
                  viewBox="0 0 24 24"
                >
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex items-center justify-center p-2 m-2">
      <img
        src="../der.jpg"
        class="w-[32rem] rounded-lg lg:hidden md:hidden h-52 mt-20 flex items-center justify-center"
        alt=""
      />
    </div>
  </section>
  <div class="flex border-t border-solid border-border-200 border-opacity-100">
    <aside
      ref="aside"
      class="bg-white lg:w-[27rem] lg:block hidden h-[39.2rem] p-3 px-8 overflow-y-auto"
    >
      <div class="max-h-full flex flex-col overflow-hidden mt-8">
        <button class="text-xl bg-gray-200 rounded-full py-2 font-bold">Trier</button>
        <ul class="text-gray-700 items-start flex flex-col mt-6 space-y-3">
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
              <!-- <svg
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
              </svg> -->
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
  <button
    class="bg-vert z-50 transform-gpu lg:block md:block hidden h-28 w-[6.5rem] rounded-lg fixed flex items-center justify-center inset-y-72 right-0"
    @mouseover="showComponent = true"
  >
    <div class="flex flex-col">
      <div class="flex text-center items-center justify-center p-2 text-white">
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
            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
          />
        </svg>
        <span
          :class="{ 'animate-bounce text-red-500': cartAnimation }"
          class="font-bold ml-2 text-sm text-white"
          >{{ count }} items</span
        >
      </div>
      <div
        class="flex items-center bg-white text-vert font-bold rounded py-2 w-20 ml-3 mt-2 justify-center"
      >
        {{ total }} F
      </div>
    </div>
  </button>
  <div
    @mouseleave="showComponent = false"
    :class="[
      showComponent ? 'right-0' : 'right-[-100%] shadow-xl lg:block md:block hidden',
    ]"
    class="border-l-2 border-gray-100 z-50 transform-gpu duration-400 ease-in-out fixed right-0 top-[4.3rem] lg:h-[35rem] lg:w-[27rem] md:w-[24rem] w-[21rem] h-[29rem] bg-white text-white p-3"
  >
    <div class="flex justify-between border-b-2 border-gray-100 py-1">
      <div class="justify-start">
        <div class="flex text-center items-center justify-center p-2 text-vert">
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
              d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
            />
          </svg>
          <span class="font-bold ml-2 text-vert">{{ count }} items</span>
        </div>
      </div>
      <div class="justify-end">
        <button
          @click="showComponent = false"
          class="btn btn-danger rounded-full hover:bg-vert hover:text-white p-1 bg-gray-200 text-gray-400 absolute top-6 right-2"
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
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>
    </div>
    <div v-if="count1" class="flex-grow pt-2 pb-20 lg:h-96 h-72 overflow-y-scroll">
      <div
        v-for="car in cart"
        :key="car.id"
        class="flex items-center border-b border-solid border-border-200 border-opacity-75 py-4 text-sm sm:px-6"
        style="opacity: 1"
      >
        <div class="flex-shrink-0">
          <div
            class="flex overflow-hidden flex-col-reverse items-center w-8 h-24 bg-gray-100 text-black rounded-full"
          >
            <button
              @click="Diminuer(car)"
              class="cursor-pointer p-2 transition-colors duration-200 hover:bg-vert focus:outline-none"
            >
              <span class="sr-only">minus</span
              ><svg
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="h-3 w-3 stroke-2.5"
              >
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path>
              </svg>
            </button>
            <div
              class="flex flex-1 items-center justify-center px-3 text-sm font-semibold text-heading"
            >
              {{ car.quantite }}
            </div>
            <button
              @click="Augmenter(car)"
              class="cursor-pointer p-2 text-black transition-colors hover:border-black hover:text-white duration-200 hover:bg-vert focus:outline-none"
              title=""
            >
              <span class="sr-only">plus</span
              ><svg
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="md:w-4.5 h-3.5 w-3.5 stroke-2.5 md:h-4.5"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                ></path>
              </svg>
            </button>
          </div>
        </div>
        <div
          class="relative mx-4 flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden bg-gray-100 sm:h-16 sm:w-16"
        >
          <span
            class="h-full"
            style="
              box-sizing: border-box;
              display: block;
              overflow: hidden;

              background: none;
              opacity: 1;
              border: 0px;
              margin: 0px;
              padding: 0px;
              position: absolute;
              inset: 0px;
            "
            ><img
              alt="Baby Spinach"
              :src="car.photo"
              decoding="async"
              data-nimg="fill"
              sizes="100vw"
              class="h-56"
              style="
                position: absolute;
                inset: 0px;
                box-sizing: border-box;
                padding: 0px;
                border: none;
                margin: auto;
                display: block;
                width: 0px;
                height: 10px;
                min-width: 100%;
                max-width: 100%;
                min-height: 100%;
                max-height: 100%;
                object-fit: contain;
              "
          /></span>
        </div>

        <div>
          <h3 class="font-black text-sm text-black">{{ car.nom }}</h3>
          <p class="text-sm font-bold text-vert">{{ car.prix }}</p>
          <span class="text-sm text-gray-500">nombre: {{ car.quantite }}</span>
        </div>

        <div class="ml-auto flex flex-col">
          <button
            @click="removeItemFromCart(car)"
            class="flex ml-16 mb-2 bg-gray-200 h-7 w-7 right-0 items-center justify-center rounded-full transition-all duration-200 hover:bg-gray-100 hover:text-red-600 focus:bg-gray-100 focus:text-red-600 focus:outline-none ltr:ml-3 ltr:-mr-2 rtl:mr-3 rtl:-ml-2"
          >
            <span class="sr-only">close</span
            ><svg
              width="81px"
              height="81px"
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
                  opacity="0.15"
                  d="M18 18V6H6V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18Z"
                  fill="#000000"
                ></path>
                <path
                  d="M10 10V16M14 10V16M18 6V18C18 19.1046 17.1046 20 16 20H8C6.89543 20 6 19.1046 6 18V6M4 6H20M15 6V5C15 3.89543 14.1046 3 13 3H11C9.89543 3 9 3.89543 9 5V6"
                  stroke="#000000"
                  stroke-width="1.5"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                ></path>
              </g>
            </svg>
          </button>
          <span class="font-semibold ml-4 mt-1 mr-2 text-gray-500 ltr:ml-auto rtl:mr-auto"
            >{{ car.total }}FCFA</span
          >
        </div>
      </div>
    </div>
    <div v-else class="flex-grow pt-28 pb-20">
      <div class="flex h-full flex-col items-center justify-center" style="opacity: 1">
        <svg class="w-40 h-40" viewBox="0 0 231.91 292">
          <defs>
            <linearGradient
              id="linear-gradient"
              x1="1"
              y1="0.439"
              x2="0.369"
              y2="1"
              gradientUnits="objectBoundingBox"
            >
              <stop offset="0" stop-color="#029477"></stop>
              <stop offset="1" stop-color="#009e7f"></stop>
            </linearGradient>
          </defs>
          <g
            id="no_cart_in_bag_2"
            data-name="no cart in bag 2"
            transform="translate(-1388 -351)"
          >
            <ellipse
              id="Ellipse_2873"
              data-name="Ellipse 2873"
              cx="115.955"
              cy="27.366"
              rx="115.955"
              ry="27.366"
              transform="translate(1388 588.268)"
              fill="#ddd"
              opacity="0.25"
            ></ellipse>
            <path
              id="Path_18691"
              data-name="Path 18691"
              d="M29.632,0H170.368A29.828,29.828,0,0,1,200,30.021V209.979A29.828,29.828,0,0,1,170.368,240H29.632A29.828,29.828,0,0,1,0,209.979V30.021A29.828,29.828,0,0,1,29.632,0Z"
              transform="translate(1403 381)"
              fill="#009e7f"
            ></path>
            <path
              id="Rectangle_1852"
              data-name="Rectangle 1852"
              d="M30,0H170a30,30,0,0,1,30,30v0a30,30,0,0,1-30,30H12.857A12.857,12.857,0,0,1,0,47.143V30A30,30,0,0,1,30,0Z"
              transform="translate(1403 381)"
              fill="#006854"
            ></path>
            <path
              id="Rectangle_1853"
              data-name="Rectangle 1853"
              d="M42,0H158a42,42,0,0,1,42,42v0a18,18,0,0,1-18,18H18A18,18,0,0,1,0,42v0A42,42,0,0,1,42,0Z"
              transform="translate(1403 381)"
              fill="#006854"
            ></path>
            <path
              id="Path_18685"
              data-name="Path 18685"
              d="M446.31,246.056a30,30,0,1,1,30-30A30.034,30.034,0,0,1,446.31,246.056Zm0-53.294A23.3,23.3,0,1,0,469.9,216.056,23.471,23.471,0,0,0,446.31,192.762Z"
              transform="translate(1056.69 164.944)"
              fill="#006854"
            ></path>
            <path
              id="Path_18686"
              data-name="Path 18686"
              d="M446.31,375.181a30,30,0,1,1,30-30A30.034,30.034,0,0,1,446.31,375.181Zm0-53.294A23.3,23.3,0,1,0,469.9,345.181,23.471,23.471,0,0,0,446.31,321.887Z"
              transform="translate(1057.793 95.684)"
              fill="#009e7f"
            ></path>
            <circle
              id="Ellipse_2874"
              data-name="Ellipse 2874"
              cx="28.689"
              cy="28.689"
              r="28.689"
              transform="translate(1473.823 511.046)"
              fill="#006854"
            ></circle>
            <circle
              id="Ellipse_2875"
              data-name="Ellipse 2875"
              cx="15.046"
              cy="15.046"
              r="15.046"
              transform="translate(1481.401 547.854) rotate(-45)"
              fill="#009e7f"
            ></circle>
            <path
              id="Path_18687"
              data-name="Path 18687"
              d="M399.71,531.27a71.755,71.755,0,0,1,12.65-13.6c3.4-2.863-1.5-7.726-4.882-4.882a78.392,78.392,0,0,0-13.73,15c-2.56,3.644,3.424,7.1,5.962,3.485Z"
              transform="translate(1060.579 -35.703)"
              fill="#006854"
            ></path>
            <path
              id="Path_18688"
              data-name="Path 18688"
              d="M412.913,527.786a78.419,78.419,0,0,0-13.73-15c-3.38-2.843-8.289,2.017-4.882,4.882a71.785,71.785,0,0,1,12.65,13.6c2.535,3.609,8.525.162,5.962-3.485Z"
              transform="translate(1060.566 -35.704)"
              fill="#006854"
            ></path>
            <path
              id="Path_18689"
              data-name="Path 18689"
              d="M583.278,527.786a78.417,78.417,0,0,0-13.73-15c-3.38-2.843-8.289,2.017-4.882,4.882a71.768,71.768,0,0,1,12.65,13.6c2.535,3.609,8.525.162,5.962-3.485Z"
              transform="translate(970.304 -35.704)"
              fill="#006854"
            ></path>
            <path
              id="Path_18690"
              data-name="Path 18690"
              d="M570.075,531.27a71.77,71.77,0,0,1,12.65-13.6c3.4-2.863-1.5-7.726-4.882-4.882a78.407,78.407,0,0,0-13.73,15c-2.56,3.644,3.424,7.1,5.962,3.485Z"
              transform="translate(970.318 -35.703)"
              fill="#006854"
            ></path>
            <path
              id="Path_18692"
              data-name="Path 18692"
              d="M301.243,287.464a19.115,19.115,0,0,1,8.071,9.077,19.637,19.637,0,0,1,1.6,7.88v26.085a19.349,19.349,0,0,1-9.672,16.957c-10.048-6.858-16.544-17.742-16.544-30S291.2,294.322,301.243,287.464Z"
              transform="translate(1292.301 101.536)"
              fill="url(#linear-gradient)"
            ></path>
            <path
              id="Path_18693"
              data-name="Path 18693"
              d="M294.371,287.464a19.115,19.115,0,0,0-8.071,9.077,19.637,19.637,0,0,0-1.6,7.88v26.085a19.349,19.349,0,0,0,9.672,16.957c10.048-6.858,16.544-17.742,16.544-30S304.419,294.322,294.371,287.464Z"
              transform="translate(1118.301 101.536)"
              fill="url(#linear-gradient)"
            ></path>
          </g>
        </svg>
        <h4 class="mt-6 text-vert font-semibold">No products found</h4>
      </div>
    </div>
    <div>
      <div class="flex justify-end mt-2 mr-6 text-gray-600 font-black text-xl">
        Total:
        <span class="text-orange-500">{{ total }}FCFA</span>
      </div>
      <a
        :href="route('client.commande')"
        class="fixed border-t-2 border-gray-300 right-8 lg:w-[23rem] hover:bg-haver md:w-[21rem] w-[17rem] h-12 bg-vert bottom-5"
      >
        <div class="flex item-center justify-center">
          <div class="font-black text-white lg:text-2xl text-xl mb-8 py-1 px-6">
            Voir mon panier({{ count }})
          </div>
        </div>
      </a>
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
