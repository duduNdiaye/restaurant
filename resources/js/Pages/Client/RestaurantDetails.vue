<script setup>
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, onMounted, computed, reactive, ref } from "vue";
import axios from "axios";

const add = ref("");
const cart = ref([]);
const count = ref(0);
const count1 = ref(false);
const cartAnimation = ref(false);
const panier = ref(false);
const now = ref(new Date());
const actif = ref("");

const props = defineProps({
  user: {},
  articles: {},
});

onMounted(() => {
  if (localStorage.getItem("cart")) {
    cart.value = JSON.parse(localStorage.getItem("cart"));
    count.value = cart.value.length;
  }
  if (count.value != 0) {
    count1.value = true;
  }

  const heureEntiere = computed(
    () => now.value.getHours() * 1 + now.value.getMinutes() / 60
  );

  setInterval(() => {
    now.value = new Date();
  }, 1000);

  console.log(heureEntiere.value);
  console.log(props.user.heureOuvert);
  console.log(props.user.heureFerme);
  if (
    props.user.heureOuvert > heureEntiere.value &&
    props.user.heureFerme <= heureEntiere.value
  ) {
    actif.value = "Ferme";
  } else {
    actif.value = "Ouvert";
  }
});

const total = computed(() => {
  return cart.value.reduce((acc, item) => acc + item.prix * item.quantite, 0);
});

const addItem = (article) => {
  console.log(article.nomResto);
  //Vérifie si l'article est déjà dans le panier
  let index = cart.value.findIndex((item) => item.nom === article.nom);
  if (index === -1) {
    cart.value.push({
      nom: article.nom,
      photo: article.photo,
      prix: parseFloat(article.prix),
      quantite: 1,
      total: parseFloat(article.prix),
      restau: article.nomResto ?? "Nom du restaurant non spécifié",
    });
    count1.value = true;
  } else {
    cart.value[index].quantite++;
    cart.value[index].total += parseFloat(article.prix);
  }

  count.value = cart.value.length;

  localStorage.setItem("cart", JSON.stringify(cart.value));

  cartAnimation.value = true;
  setTimeout(() => {
    cartAnimation.value = false;
  }, 1000);

  panier.value = true; // affiche le modal de validation
  console.log(panier.value);
  setTimeout(() => {
    console.log("here");
    panier.value = false;
  }, 2000);
  console.log(panier.value);
};
const recherche = computed(() => {
  return props.articles.filter((article) => article.user_id == props.user.id);
});
</script>
<template>
  <div class="flex items-center h-60 justify-center">
    <img :src="user.photo" class="h-full w-full object-cover object-center" alt="" />
  </div>
  <div
    class="flex px-5 items-center z-40 transform-cpu bg-white text-center border-b border-gray-200 md:px-5 lg:px-28 py-3 w-full"
  >
    <div class="flex items-center space-x-7">
      <h1
        class="text-3xl flex  bg-black text-white px-2 font-title font-extrabold"
      >
        EatEasy
      </h1>
      <div class=" relative hidden md:block lg:block sm:block mx-auto text-gray-600">
        <input
          class="border-2 border-gray-300 outline-none bg-white focus:ring-gray-200 focus:outline-none focus:border-none lg:w-96 h-[3rem] px-5 pr-16 rounded-full text-sm focus:outline-none"
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
    <div class="flex lg:flex lg:block md:block md:flex hidden space-x-4 items-center ml-auto">
      <button
        class="bg-white border-2 border-gray-100 flex rounded-full py-2 space-x-2 px-3 hover:bg-gray-100"
      >
        <svg
          class="w-5 h-5 mt-[0.5] icon flex justify-center items-center"
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
            <rect width="24" height="24" fill="white"></rect>
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.9999 6C9.79077 6 7.99991 7.79086 7.99991 10C7.99991 12.2091 9.79077 14 11.9999 14C14.209 14 15.9999 12.2091 15.9999 10C15.9999 7.79086 14.209 6 11.9999 6ZM17.1115 15.9974C17.8693 16.4854 17.8323 17.5491 17.1422 18.1288C15.7517 19.2966 13.9581 20 12.0001 20C10.0551 20 8.27215 19.3059 6.88556 18.1518C6.18931 17.5723 6.15242 16.5032 6.91351 16.012C7.15044 15.8591 7.40846 15.7251 7.68849 15.6097C8.81516 15.1452 10.2542 15 12 15C13.7546 15 15.2018 15.1359 16.3314 15.5954C16.6136 15.7102 16.8734 15.8441 17.1115 15.9974Z"
              fill="#323232"
            ></path>
          </g>
        </svg>
        <span class="font-bold text-black flex justify-center items-center"
          >Se connecter</span
        >
      </button>
      <button
        class="bg-white border-2 border-gray-100 flex rounded-full py-2 space-x-2 px-3 hover:bg-gray-100"
      >
        <svg
          class="w-5 h-5 mt-[0.5] icon flex justify-center items-center"
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
              d="M13 2C10.2386 2 8 4.23858 8 7C8 7.55228 8.44772 8 9 8C9.55228 8 10 7.55228 10 7C10 5.34315 11.3431 4 13 4H17C18.6569 4 20 5.34315 20 7V17C20 18.6569 18.6569 20 17 20H13C11.3431 20 10 18.6569 10 17C10 16.4477 9.55228 16 9 16C8.44772 16 8 16.4477 8 17C8 19.7614 10.2386 22 13 22H17C19.7614 22 22 19.7614 22 17V7C22 4.23858 19.7614 2 17 2H13Z"
              fill="#000000"
            ></path>
            <path
              d="M3 11C2.44772 11 2 11.4477 2 12C2 12.5523 2.44772 13 3 13H11.2821C11.1931 13.1098 11.1078 13.2163 11.0271 13.318C10.7816 13.6277 10.5738 13.8996 10.427 14.0945C10.3536 14.1921 10.2952 14.2705 10.255 14.3251L10.2084 14.3884L10.1959 14.4055L10.1915 14.4115C10.1914 14.4116 10.191 14.4122 11 15L10.1915 14.4115C9.86687 14.8583 9.96541 15.4844 10.4122 15.809C10.859 16.1336 11.4843 16.0346 11.809 15.5879L11.8118 15.584L11.822 15.57L11.8638 15.5132C11.9007 15.4632 11.9553 15.3897 12.0247 15.2975C12.1637 15.113 12.3612 14.8546 12.5942 14.5606C13.0655 13.9663 13.6623 13.2519 14.2071 12.7071L14.9142 12L14.2071 11.2929C13.6623 10.7481 13.0655 10.0337 12.5942 9.43937C12.3612 9.14542 12.1637 8.88702 12.0247 8.7025C11.9553 8.61033 11.9007 8.53682 11.8638 8.48679L11.822 8.43002L11.8118 8.41602L11.8095 8.41281C11.4848 7.96606 10.859 7.86637 10.4122 8.19098C9.96541 8.51561 9.86636 9.14098 10.191 9.58778L11 9C10.191 9.58778 10.1909 9.58773 10.191 9.58778L10.1925 9.58985L10.1959 9.59454L10.2084 9.61162L10.255 9.67492C10.2952 9.72946 10.3536 9.80795 10.427 9.90549C10.5738 10.1004 10.7816 10.3723 11.0271 10.682C11.1078 10.7837 11.1931 10.8902 11.2821 11H3Z"
              fill="#000000"
            ></path>
          </g>
        </svg>

        <span class="font-bold text-black flex justify-center items-center"
          >S'inscrire</span
        >
      </button>
    </div>
  </div>

  <div class="flex space-x-9 border-b border-gray-200 w-screen py-5 px-12">
    <a href="#" class="text-black font-semibold">Accueil</a>
    <a href="#" class="text-black font-semibold">Restaurants</a>
    <button class="text-black font-semibold">Notation</button>
    <a href="#" class="text-black font-semibold">Menu</a>
    <button class="bg-black hover:bg-gray-400 px-2 rounded-full flex space-x-2">
      <svg
       class="h-4 w-4 icon mt-1"
        viewBox="0 0 32 32"
        stroke="#fff"
        version="1.1"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        fill="#000000"
      >
        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
        <g id="SVGRepo_iconCarrier">
          <g id="icomoon-ignore"></g>
          <path
            d="M30.622 9.602h-22.407l-1.809-7.464h-5.027v1.066h4.188l5.198 21.443c-1.108 0.323-1.923 1.334-1.923 2.547 0 1.472 1.193 2.666 2.666 2.666s2.666-1.194 2.666-2.666c0-0.603-0.208-1.153-0.545-1.599h7.487c-0.337 0.446-0.545 0.997-0.545 1.599 0 1.472 1.193 2.666 2.665 2.666s2.666-1.194 2.666-2.666c0-1.473-1.193-2.665-2.666-2.666v0h-11.403l-0.517-2.133h14.968l4.337-12.795zM13.107 27.196c0 0.882-0.717 1.599-1.599 1.599s-1.599-0.717-1.599-1.599c0-0.882 0.717-1.599 1.599-1.599s1.599 0.718 1.599 1.599zM24.836 27.196c0 0.882-0.718 1.599-1.6 1.599s-1.599-0.717-1.599-1.599c0-0.882 0.717-1.599 1.599-1.599 0.882 0 1.6 0.718 1.6 1.599zM11.058 21.331l-2.585-10.662h20.662l-3.615 10.662h-14.462z"
            fill="#000000"
          ></path>
        </g>
      </svg>
      <span class="text-white">Panier</span>
    </button>
  </div>
  <div class="p-6 px-2 bg-white">
    <div class="flex flex-col space-y-1 px-9">
      <div class="flex">
        <div class="flex flex-col space-y-2">
          <span class="font-black text-5xl">{{ user.name }}</span>
          <div
            class="text-red-500 space-x-1 font-bold mt-2 text-sm flex justify-center items-center"
          >
            <svg
              class="w-4 h-4 icon"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
              stroke="#ed0707"
            >
              <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
              <g
                id="SVGRepo_tracerCarrier"
                stroke-linecap="round"
                stroke-linejoin="round"
              ></g>
              <g id="SVGRepo_iconCarrier">
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.8284 6.75736C12.3807 6.75736 12.8284 7.20507 12.8284 7.75736V12.7245L16.3553 14.0653C16.8716 14.2615 17.131 14.8391 16.9347 15.3553C16.7385 15.8716 16.1609 16.131 15.6447 15.9347L11.4731 14.349C11.085 14.2014 10.8284 13.8294 10.8284 13.4142V7.75736C10.8284 7.20507 11.2761 6.75736 11.8284 6.75736Z"
                  fill="#f70808"
                ></path>
              </g>
            </svg>
            <span> {{ actif }} a l'heure actuelle</span>
          </div>
        </div>
        <!-- <a
          :href="route('client.commande')"
          class="flex lg:w-36 space-x-1 bg-black px-3 ml-auto items-center justify-center rounded-full"
        >
          <svg
            class="w-8 h-8 icon"
            stroke="#fff"
            viewBox="0 0 32 32"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            fill="#000000"
          >
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g
              id="SVGRepo_tracerCarrier"
              stroke-linecap="round"
              stroke-linejoin="round"
            ></g>
            <g id="SVGRepo_iconCarrier">
              <g id="icomoon-ignore"></g>
              <path
                d="M30.622 9.602h-22.407l-1.809-7.464h-5.027v1.066h4.188l5.198 21.443c-1.108 0.323-1.923 1.334-1.923 2.547 0 1.472 1.193 2.666 2.666 2.666s2.666-1.194 2.666-2.666c0-0.603-0.208-1.153-0.545-1.599h7.487c-0.337 0.446-0.545 0.997-0.545 1.599 0 1.472 1.193 2.666 2.665 2.666s2.666-1.194 2.666-2.666c0-1.473-1.193-2.665-2.666-2.666v0h-11.403l-0.517-2.133h14.968l4.337-12.795zM13.107 27.196c0 0.882-0.717 1.599-1.599 1.599s-1.599-0.717-1.599-1.599c0-0.882 0.717-1.599 1.599-1.599s1.599 0.718 1.599 1.599zM24.836 27.196c0 0.882-0.718 1.599-1.6 1.599s-1.599-0.717-1.599-1.599c0-0.882 0.717-1.599 1.599-1.599 0.882 0 1.6 0.718 1.6 1.599zM11.058 21.331l-2.585-10.662h20.662l-3.615 10.662h-14.462z"
                fill="#000000"
              ></path>
            </g>
          </svg>
          <span class="text-white font-semibold">Panier</span>
          <span class="text-white text-2xl font-bold mt-[-0.5rem]">.</span>
          <span
            :class="{ 'animate-bounce text-red-500': cartAnimation }"
            class="text-white text-xl font-black"
            >{{ count }}</span
          >
        </a> -->
        <div class="flex justify-center items-center ml-auto">
          <select class="focus:ring-black focus:outline-none focus:border-none mb-5 w-96">
            <option value="1">PIZZAS</option>
            <option value="2">PLATS NATIONAUX</option>
            <option value="3">BURGERS</option>
            <option value="4">BOISSON</option>
            <option value="4">AUTRES</option>
          </select>
        </div>
      </div>
      <div class="lg:flex-row md:flex-row flex flex-col space-y-2 lg:space-x-1">
        <div class="flex space-x-1 mt-2 items-center justify-center">
          <svg
            class="h-4 w-4 icon"
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
          <span class="flex text-sm justify-center items-center">4.7(15 notes)</span>
        </div>
        <div
          class="flex lg:block hidden mt-[-0.8rem] justify-center items-center text-gray-300 text-xl"
        >
          |
        </div>
        <span class="flex space-x-1 text-sm justify-center items-center">
          <svg
            class="w-4 h-4 icon"
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
                opacity="0.1"
                d="M3 6.5C3 14.5081 9.49187 21 17.5 21C18.166 21 18.8216 20.9551 19.4637 20.8682C20.3747 20.7448 21 19.9292 21 19.01V16.4415C21 15.5807 20.4491 14.8164 19.6325 14.5442L16.4841 13.4947C15.6836 13.2279 14.8252 13.699 14.6206 14.5177C14.3475 15.6102 12.987 15.987 12.1907 15.1907L8.80926 11.8093C8.01301 11.013 8.38984 9.65254 9.48229 9.37943C10.301 9.17476 10.7721 8.31644 10.5053 7.51586L9.45585 4.36754C9.18362 3.55086 8.41934 3 7.55848 3H4.99004C4.0708 3 3.25518 3.62533 3.13185 4.53627C3.0449 5.17845 3 5.83398 3 6.5Z"
                fill="#323232"
              ></path>
              <path
                d="M3 6.5C3 14.5081 9.49187 21 17.5 21C18.166 21 18.8216 20.9551 19.4637 20.8682C20.3747 20.7448 21 19.9292 21 19.01V16.4415C21 15.5807 20.4491 14.8164 19.6325 14.5442L16.4841 13.4947C15.6836 13.2279 14.8252 13.699 14.6206 14.5177C14.3475 15.6102 12.987 15.987 12.1907 15.1907L8.80926 11.8093C8.01301 11.013 8.38984 9.65254 9.48229 9.37943C10.301 9.17476 10.7721 8.31644 10.5053 7.51586L9.45585 4.36754C9.18362 3.55086 8.41934 3 7.55848 3H4.99004C4.0708 3 3.25518 3.62533 3.13185 4.53627C3.0449 5.17845 3 5.83398 3 6.5Z"
                stroke="#323232"
                stroke-width="2"
                stroke-linejoin="round"
              ></path>
            </g>
          </svg>

          {{ user.tel }}</span
        >
        <div
          class="flex lg:block hidden mt-[-0.8rem] justify-center items-center text-gray-300 text-xl"
        >
          |
        </div>
        <span class="flex space-x-2 text-sm justify-center items-center">
          <svg
            class="w-4 h-4 icon"
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
              <g id="Group_719" data-name="Group 719" transform="translate(-50 -100)">
                <path
                  id="Path_1486"
                  data-name="Path 1486"
                  d="M63,126c-7.2,0-13-1.6-13-3.5,0-1.3,2.6-2.4,6.5-3l1.6,1.7c-3.6.2-5.5.8-5.5,1.3,0,.8,4.3,1.5,10.4,1.5s10.5-.7,10.5-1.5c0-.6-1.9-1.1-5.5-1.3l1.6-1.7c3.9.6,6.5,1.7,6.5,3C76,124.4,70.2,126,63,126Zm4-17a4,4,0,1,1-4-4A4.012,4.012,0,0,1,67,109Zm-6,0a2,2,0,1,0,2-2A2.006,2.006,0,0,0,61,109Zm3,12-1,1-1-1c-.3-.4-6.6-5.8-7.8-10.5-.1-.3-.3-1.4.8-1.5.9-.1,1.1,1,1.1,1,.8,3.5,5.2,6.9,6.9,9,1.8-2.3,7-6.1,7-10,0-4.5-2.6-7-7-7-3.3,0-5.6,1.4-6.5,4,0,0-.4,1.2-1.1,1-.8-.2-.9-.8-.6-1.7A9,9,0,0,1,72,109C72,114,64.4,120.6,64,121Z"
                  fill="#444"
                ></path>
              </g>
            </g>
          </svg>
          {{ user.adresse }}</span
        >
        <div
          class="flex lg:block hidden mt-[-0.8rem] justify-center items-center text-gray-300 text-xl"
        >
          |
        </div>
        <div
          class="flex md:justify-start lg:justify-start justify-center items-center space-x-1 text-gray-500 text-sm font-semibold"
        >
          <span class="text-sm">Ouvert a: </span>
          <span class="font-black text-sm flex text-black">{{ user.heureOuvert }}H</span>
          <div class="flex mt-[-0.4rem] justify-center items-center font-bold text-2xl">
            -
          </div>
          <span class="text-sm">Ferme a: </span>
          <span class="font-black text-md text-black">{{ user.heureFerme }}H</span>
        </div>
      </div>
    </div>

    <div class="w-full h-fit px-4 pb-8 lg:p-8">
      <div
        class="grid lg:grid-cols-[repeat(auto-fill,minmax(270px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3"
      >
        <article
          v-for="article in recherche"
          :key="article.id"
          class="product-card cart-type-neon overflow-hidden bg-white duration-50 hover:-translate-y-0.5 hover:-translate-x-0.1 hover:shadow"
        >
          <span
            @mouseover="add = article.id"
            @mouseleave="add = ''"
            class="box-border block overflow-hidden w-auto h-fit bg-transparent opacity-100 border-0 m-0 p-0 inset-0"
          >
            <button @click="showModals(article)" class="rounded-md w-full">
              <img
                :src="article.photo"
                alt="Product image"
                class="w-full h-56 mb-6 object-cover object-center"
              />
            </button>
            <header
              class="md:p-6 lg:mt-[-4rem] md:mt-[-4rem] md:ml-[-1.4rem] md:mr-[-1.4rem] mt-[-1.5rem] lg:ml-[-1.4rem] lg:mr-[-1.4rem]"
            >
              <div class="py-2 flex flex-col">
                <div class="flex">
                  <div class="flex flex-col">
                    <h3
                      class="lg:text-2xl md:text-2xl text-black font-semibold md:text-sm"
                    >
                      {{ article.nom }}
                    </h3>
                    <span class="lg:text-sm font-medium text-heading md:text-base">
                      {{ article.prix }} FCFA</span
                    >
                  </div>
                  <button
                    @click="addItem(article)"
                    v-if="add == article.id"
                    class="ml-auto"
                  >
                    <svg
                      class="w-12 h-12 duration-400 ease-in-out"
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
                          d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM16 12.75H12.75V16C12.75 16.41 12.41 16.75 12 16.75C11.59 16.75 11.25 16.41 11.25 16V12.75H8C7.59 12.75 7.25 12.41 7.25 12C7.25 11.59 7.59 11.25 8 11.25H11.25V8C11.25 7.59 11.59 7.25 12 7.25C12.41 7.25 12.75 7.59 12.75 8V11.25H16C16.41 11.25 16.75 11.59 16.75 12C16.75 12.41 16.41 12.75 16 12.75Z"
                          fill="#292D32"
                        ></path>
                      </g>
                    </svg>
                  </button>
                </div>
              </div>
            </header>
          </span>
        </article>
      </div>
      <transition name="panier">
        <div
          v-if="panier"
          class="bg-vert font-bold flex h-14 z-[55] text-white rounded-md p-4 fixed top-[39rem] right-4"
        >
          <div class="flex mb-3">
            <span class="text-2xl font-bold">Article ajoute!</span>
            <svg
              class="w-8 h-8 icon ml-4"
              viewBox="0 0 1024 1024"
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
                <path
                  fill="#000000"
                  d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm-55.808 536.384-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.272 38.272 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336L456.192 600.384z"
                ></path>
              </g>
            </svg>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>
<style>
.panier-enter-active,
.panier-leave-active {
  transition: transform 0.5s ease, opacity 0.5s ease;
  transform: translateX(100%);
  opacity: 0;
}

.panier-enter,
.panier-leave-to {
  opacity: 0;
  transform: translateX(100%);
}

.panier-leave,
.panier-enter-to {
  opacity: 1;
  transform: translateX(0);
}
</style>
