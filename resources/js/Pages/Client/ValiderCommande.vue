<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import { ref, onMounted, computed } from "vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  articles: {},
});

const cart = ref([]);
const count = ref(0);
const count1 = ref(false);

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

const Augmenter = (car) => {
  let index = cart.value.findIndex((item) => item.nom === car.nom);
  if (index === -1) {
    return;
  } else {
    cart.value[index].quantite++;
    cart.value[index].total += parseFloat(car.prix);
  }
  localStorage.setItem("cart", JSON.stringify(cart.value));
};
const Diminuer = (car) => {
  let index = cart.value.findIndex((item) => item.nom === car.nom);
  if (index === -1) {
    return;
  } else {
    cart.value[index].quantite--;
    cart.value[index].total -= parseFloat(car.prix);
  }
  if (cart.value[index].quantite === 0) {
    cart.value.splice(index, 1);
    count.value -= 1;
  }

  if (count.value == 0) {
    count1.value = false;
  }

  localStorage.setItem("cart", JSON.stringify(cart.value));
};
</script>
<template>
  <div class="flex min-h-screen flex-col bg-gray-100 transition-colors duration-150">
    <header>
      <nav
        id="navbar"
        class="fixed md:flex border-b-2 z-40 transform-cpu border-gray-200 text-center items-center justify-between bg-white px-4 py-6 w-full"
      >
        <div class="flex items-center">
          <h1
            class="text-3xl lg:block md:block hidden lg:ml-0 text-center bg-black text-white px-2 md:ml-0 font-title font-extrabold"
          >
            EatEasy
          </h1>
          <ApplicationMark class="h-9 w-auto lg:hidden md:hidden" />
          <p class="font-bold text-xl ml-8 lg:hidden md:hidden" v-if="texte">
            Que desirez-vous manger?
          </p>
        </div>

        <div
          class="md:flex lg:border-none md:border-none border-t-2 border-b-2 border-gray-200 bg-white md:items-center md:px-0 px-3 md:pb-0 pb-10 md:static absolute md:w-auto w-full top-14 duration-300 ease-in"
          :class="[open ? 'left-0' : 'left-[-100%]']"
        >
          <div class="md:mx-4 md:my-0 my-6">
            <a href="#" class="px-3 py-2 font-bold text-black hover:text-indigo-600"
              >Articles</a
            >
          </div>
          <div class="md:mx-4 md:my-0 my-6">
            <a href="#" class="px-3 py-2 font-bold text-black hover:text-indigo-600"
              >Contact</a
            >
          </div>
          <div v-if="canLogin" class="flex flex-col md:flex-row md:my-0 my-6">
            <a
              v-if="$page.props.user"
              :href="route('dashboard')"
              class="px-3 py-2 bg-vert font-bold text-white rounded hover:bg-green-200 mt-3 md:mt-0"
              >Button 1</a
            >

            <template v-else>
              <a
                :href="route('login')"
                class="px-3 py-2 lg:ml-4 bg md:ml-4 text-center bg-vert font-bold text-white rounded hover:bg-green-200 mt-3 md:mt-0"
                >Login
              </a>
              <a
                v-if="canRegister"
                :href="route('register')"
                class="px-3 py-2 lg:ml-4 md:ml-4 font-bold text-center bg-vert text-white rounded hover:bg-green-200 mt-3 md:mt-0"
                >Register
              </a>
            </template>
          </div>
        </div>
      </nav>
    </header>
    <div class="px-4 py-8 bg-gray-100 lg:px-4 md:px-4 lg:py-24 xl:py-14 xl:px-16 2xl:px-20">
      <div
        class="flex flex-col items-center w-full mt-16 max-w-8xl m-auto rtl:space-x-reverse lg:flex-row md:flex-row md:items-start md:space-x-4  lg:items-start lg:space-x-8"
      >
        <div class="w-full lg:max-w-4xl md:max-w-[35rem] max-w-8xl">
          <div class="bg-white mb-3 h-16">
            <div
              class=" p-4 font-bold flex justify-between  capitalize text-heading lg:text-xl"
            >
              <span class="text-gray-500 lg:text-sm lg:block md:block hidden">Votre commande sur EATEASY</span>
              <span class="flex text-lg text-center">Resume du panier({{count}})</span>
            </div>
          </div>
          <div
            class="p-5 bg-white shadow-700 md:p-8 lg:h-68 lg:w-full border-b border-gray-300"
            v-for="car in cart"
            :key="car.id"
          >
            <div
              class="flex flex-col md:flex-row md:space-x-4 space-y-4 lg:flex-row md:items-start items-center lg:items-start"
            >
              <div class="flex-shrink-0 w-32  lg:w-48">
                <img :src="car.photo" alt="Nom de l'article" class="w-full h-auto md:w-56" />
              </div>
              <div class="flex flex-col justify-between lg:ml-4 mt-2 lg:mt-0">
                <div
                  class="font-medium text-lg lg:text-xl lg:text-start text-center"
                >
                  {{ car.nom }}
                </div>
                <div class="flex justify-between items-center">
                  <div class="flex flex-col md:flex-row md:space-x-6 lg:flex-row  lg:items-center lg:space-x-10 space-y-6">
                    <div class="flex lg:space-x-10 md:space-x-2 space-x-16 mt-1">
                      <div
                        class="text-sm text-white shrink-0 md:text-xs bg-black md:py-3 md:mt-3 py-1 lg:mt-3 px-4 rounded-full w-fit"
                      >
                        Quantité :{{ car.quantite }}
                      </div>
                      <div class="text-red-500 font-bold lg:mt-4 md:mt-4 ">{{ car.prix }}F</div>
                    </div>
                    <div class="flex lg:space-x-[-4rem] md:space-x-[-3rem] space-x-8 ">
                      <div class="flex-shrink-0 lg:mr-6">
                        <div
                          class="lg:mr-16 md:mr-16 overflow-hidden flex items-center w-24 h-8 bg-gray-100 text-black rounded-full"
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
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M20 12H4"
                              ></path>
                            </svg>
                          </button>
                          <div
                            class="flex flex-1 items-center justify-center px-3 text-sm font-semibold text-heading"
                          >
                            1
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
                      <div class="ml-auto text-gray-500 mr-0">Total:{{ car.total }}F</div>
                    </div>
                  </div>
                </div>
                <div class="flex items-center space-x-6 mt-6">
                  <button class="text-gray-600 text-sm mr-2">Ajouter aux favoris</button>
                  <button class="text-lg hover:font-black">effacer</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full mb-10 sm:mb-12 lg:mb-0 md:w-[20rem] lg:w-[40rem]">
          <div class="w-full bg-white p-6">
            <div class="mb-4 flex flex-col items-center space-x-4 rtl:space-x-reverse">
              <span class="text-lg font-bold text-heading">Resume de votre commande</span>
            </div>
            <div class="flex flex-col border-b border-border-200 py-3">
              <div class="flex justify-between py-2">
                <div class="flex items-center justify-between text-base">
                  <span class="text-sm text-body"
                    ><span class="text-sm font-bold text-heading">1</span
                    ><span class="mx-2">Total a payer</span>
                    <span>4pc(s)</span></span
                  >
                </div>
                <span class="text-lg text-red-500 text-body">{{total}} FCFA</span>
              </div>
            </div>
            <div class="mt-4 space-y-2">
              <div class="flex justify-between">
                <p class="text-lg text-body text-yellow-500">Nombre d'article</p>
                <span class="text-sm text-body bg-black text-white rounded-full p-2">{{count}}</span>
              </div>
              <div class="flex justify-between">
                <p class="text-sm text-body">Tax</p>
                <span class="text-sm text-body">Calculated at checkout</span>
              </div>
              <div class="flex justify-between">
                <p class="text-sm text-body">Estimated Shipping</p>
                <span class="text-sm text-body">Calculated at checkout</span>
              </div>
            </div>
            <button
              data-variant="normal"
              class="inline-flex items-center justify-center shrink-0 font-bold text-2xl leading-none rounded outline-none transition duration-300 ease-in-out focus:outline-none focus:shadow focus:ring-1 focus:ring-accent-700 bg-black text-white border border-transparent hover:bg-gray-600 px-5 py-0 h-12 mt-5 w-full"
            >
              Passer a la caisse
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      open: false,
    };
  },
  methods: {
    toggleMenu() {
      this.open = !this.open;
    },
  },
};
</script>
