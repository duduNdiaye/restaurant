<script setup>
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, onMounted, computed, reactive, ref } from "vue";
import axios from "axios";

const add = ref('')
const cart = ref([]);
const count = ref(0);
const count1 = ref(false);
const cartAnimation = ref(false);
const panier = ref(false);


const props = defineProps({
  user: {},
  articles: {},
});

const articles = computed(() => {
  console.log(props.user.id);
  return props.articles.filter((article) => article.user_id == props.user.id);
});

onMounted(() => {
  if (localStorage.getItem("cart")) {
    cart.value = JSON.parse(localStorage.getItem("cart"));
    count.value = cart.value.length;
  }
  if (count.value != 0) {
    count1.value = true;
  }

});

const total = computed(() => {
  return cart.value.reduce((acc, item) => acc + item.prix * item.quantite, 0);
});

const addItemToCart = (article) => {
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
</script>
<template>
  <header>
    <nav
      id="navbar"
      class="fixed md:flex z-40 transform-cpu text-center items-center justify-between px-4 py-3 w-full"
    >
      <div class="flex items-center">
        <h1
          class="text-3xl lg:block md:block hidden lg:ml-0 text-center bg-black text-white px-2 md:ml-0 font-title font-extrabold"
        >
          EatEasy
        </h1>
      </div>
    </nav>
  </header>
  <div class="flex items-center h-60 justify-center">
    <img
      :src="user.photo"
      class="h-full w-full object-cover object-center"
      alt=""
    />
  </div>
  <div class="p-6 px-9">
    <div class="flex flex-col space-y-1 px-9">
      <div class="flex">
        <span class="font-black text-5xl">{{ user.name }}</span>
        <a :href="route('client.commande')" class="flex space-x-1 bg-black px-3 ml-auto items-center justify-center rounded-full">
            <svg class="w-5 h-5 icon" stroke="#fff" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="icomoon-ignore"> </g> <path d="M30.622 9.602h-22.407l-1.809-7.464h-5.027v1.066h4.188l5.198 21.443c-1.108 0.323-1.923 1.334-1.923 2.547 0 1.472 1.193 2.666 2.666 2.666s2.666-1.194 2.666-2.666c0-0.603-0.208-1.153-0.545-1.599h7.487c-0.337 0.446-0.545 0.997-0.545 1.599 0 1.472 1.193 2.666 2.665 2.666s2.666-1.194 2.666-2.666c0-1.473-1.193-2.665-2.666-2.666v0h-11.403l-0.517-2.133h14.968l4.337-12.795zM13.107 27.196c0 0.882-0.717 1.599-1.599 1.599s-1.599-0.717-1.599-1.599c0-0.882 0.717-1.599 1.599-1.599s1.599 0.718 1.599 1.599zM24.836 27.196c0 0.882-0.718 1.599-1.6 1.599s-1.599-0.717-1.599-1.599c0-0.882 0.717-1.599 1.599-1.599 0.882 0 1.6 0.718 1.6 1.599zM11.058 21.331l-2.585-10.662h20.662l-3.615 10.662h-14.462z" fill="#000000"> </path> </g></svg>
            <span class="text-white font-semibold">Panier</span>
            <span class="text-white text-2xl font-bold mt-[-0.5rem]">.</span>
            <span  :class="{ 'animate-bounce text-red-500': cartAnimation }" class="text-white text-xl font-black">{{count}}</span>
        </a>
      </div>
      <div class="flex space-x-1">
        <div class="flex space-x-1 items-center justify-center">
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
          <span>4.7(15 notes)</span>
        </div>
        <div class="flex mt-[-0.8rem] justify-center items-center font-bold text-2xl">
          .
        </div>
        <span class="flex justify-center items-center">{{ user.tel }}</span>
        <div class="flex mt-[-0.8rem] justify-center items-center font-bold text-2xl">
          .
        </div>
        <span>{{ user.adresse }}</span>
      </div>
      <div class="flex space-x-1 text-gray-500 text-sm font-semibold">
        <span>Heure d'ouverture: </span>
        <span class="font-black text-md text-black">{{ user.heureOuvert }}H</span>
        <div class="flex mt-[-0.4rem] justify-center items-center font-bold text-2xl">
          -
        </div>
        <span>Heure de Fermeture: </span>
        <span class="font-black text-md text-black">{{ user.heureFerme }}H</span>
      </div>
    </div>
    <div class="flex justify-center items-center">
      <select class="focus:ring-black focus:outline-none focus:border-none w-96">
        <option value="1">PIZZAS</option>
        <option value="2">PLATS NATIONAUX</option>
        <option value="3">BURGERS</option>
        <option value="4">BOISSON</option>
        <option value="4">AUTRES</option>
      </select>
    </div>
    <div class="w-full h-fit px-4 pb-8 lg:p-8">
      <div
        class="grid lg:grid-cols-[repeat(auto-fill,minmax(270px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3"
      >
        <article
          v-for="article in articles"
          :key="article.id"
          class="product-card cart-type-neon overflow-hidden bg-white duration-50 hover:-translate-y-0.5 hover:-translate-x-0.1 hover:shadow"
        >
          <span @mouseover="add = article.id" @mouseleave="add = ''"
            class="box-border block overflow-hidden w-auto h-fit bg-transparent opacity-100 border-0 m-0 p-0 inset-0"
          >
            <button @click="showModals(article)" class="rounded-md">
              <img
                :src="article.photo"
                alt="Product image"
                class="w-full h-56 mb-6 object-cover object-center"
              />
            </button>
            <header
              class="md:p-6 lg:mt-[-4rem] mt-[-1.5rem] lg:ml-[-1.4rem] lg:mr-[-1.4rem]"
            >
              <div class="py-2 flex flex-col">
                <div class="flex">
                  <div class="flex flex-col">
                    <h3 class="lg:text-2xl text-black font-semibold md:text-sm">
                      {{ article.nom }}
                    </h3>
                    <span class="lg:text-sm font-medium text-heading md:text-base">
                      {{ article.prix }} FCFA</span
                    >
                  </div>
                  <button @click="addItemToCart(article)" v-if="add == article.id" class="ml-auto ">
                    <svg class="w-12 h-12 duration-400 ease-in-out" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM16 12.75H12.75V16C12.75 16.41 12.41 16.75 12 16.75C11.59 16.75 11.25 16.41 11.25 16V12.75H8C7.59 12.75 7.25 12.41 7.25 12C7.25 11.59 7.59 11.25 8 11.25H11.25V8C11.25 7.59 11.59 7.25 12 7.25C12.41 7.25 12.75 7.59 12.75 8V11.25H16C16.41 11.25 16.75 11.59 16.75 12C16.75 12.41 16.41 12.75 16 12.75Z" fill="#292D32"></path> </g></svg>
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
