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
    <div class="px-4 py-8 bg-gray-100 lg:px-4 lg:py-24 xl:py-14 xl:px-16 2xl:px-20">
      <div
        class="flex flex-col items-center w-full mt-16 max-w-8xl m-auto rtl:space-x-reverse lg:flex-row lg:items-start lg:space-x-8"
      >
        <div class="w-full lg:max-w-4xl max-w-8xl">
          <div class="bg-white mb-3 h-16">
            <p class="text-lg p-4 font-bold text-center capitalize text-heading lg:text-xl">Resume du panier</p>
          </div>
          <div
            class="p-5 bg-white shadow-700 md:p-8 lg:h-68 lg:w-full"
            v-for="car in cart"
            :key="car.id"
          >
            <div class="lg:w-full md:w-full  w-full flex">
              <div class="mr-4">
                <img :src="car.photo" class="lg:w-36 sm:mr-36 sm:w-36 sm:h-40 md:w-40 md:h-44 lg:h-40 w-56 h-48 object-cover max-w-none sm:max-w-full" alt="" />
              </div>
              <div class="flex flex-col">
                <div class="mb-4">
                  <span>{{ car.nom }}</span>
                </div>
                <div class="flex items-center justify-between md:mb-5 lg:mb-10 mb-16">
                  <button class="lg:mr-16  md:mr-16 mr-4 text-white bg-black rounded-full px-4">
                    Nombre:{{ car.quantite }}
                  </button>
                  <span class="lg:mr-24 md:mr-24 mr-2">{{ car.prix }}</span>
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
                  <span class="flex">{{ car.total }}</span>
                </div>
                <div class="flex">
                  <div class="flex">
                    <button class="mr-12 text-sm tet-black flex">
                      <svg
                        fill="#000000"
                        class="icon w-4 h-4"
                        version="1.1"
                        id="XMLID_298_"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 24 24"
                        xml:space="preserve"
                      >
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g
                          id="SVGRepo_tracerCarrier"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                        ></g>
                        <g id="SVGRepo_iconCarrier">
                          <g id="favorite">
                            <path
                              d="M12,23.2l-0.6-0.5C8.7,20.7,0,13.5,0,7.3C0,3.8,2.9,1,6.5,1c2.2,0,4.3,1.1,5.5,2.9l0,0l0,0C13.2,2.1,15.3,1,17.5,1 C21.1,1,24,3.8,24,7.3c0,6.3-8.7,13.4-11.4,15.5L12,23.2z M6.5,2.9C4,2.9,2,4.8,2,7.2c0,4.1,5.1,9.5,10,13.4 c4.9-3.9,10-9.3,10-13.4c0-2.4-2-4.3-4.5-4.3c-1.6,0-3,0.8-3.8,2L12,7.6L10.3,5C9.5,3.7,8.1,2.9,6.5,2.9z"
                            ></path>
                          </g>
                        </g>
                      </svg>
                      <span class="ml-2">Ajouter aux Favoris</span>
                    </button>
                    <button class="text-sm hover:font-black">Effacer</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full mb-10 sm:mb-12 lg:mb-0 lg:w-[40rem]">
          <div class="w-full bg-white p-6">
            <div class="mb-4 flex flex-col items-center space-x-4 rtl:space-x-reverse">
              <span class="text-lg font-bold text-heading">Resume de votre commande</span>
            </div>
            <div class="flex flex-col border-b border-border-200 py-3">
              <div class="flex justify-between py-2">
                <div class="flex items-center justify-between text-base">
                  <span class="text-sm text-body"
                    ><span class="text-sm font-bold text-heading">1</span
                    ><span class="mx-2">x</span><span>Lime</span> |
                    <span>4pc(s)</span></span
                  >
                </div>
                <span class="text-sm text-body">$1.50</span>
              </div>
            </div>
            <div class="mt-4 space-y-2">
              <div class="flex justify-between">
                <p class="text-sm text-body">Sub Total</p>
                <span class="text-sm text-body">$1.50</span>
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
              class="inline-flex items-center justify-center shrink-0 font-semibold leading-none rounded outline-none transition duration-300 ease-in-out focus:outline-none focus:shadow focus:ring-1 focus:ring-accent-700 bg-vert text-white border border-transparent hover:bg-vert-hover px-5 py-0 h-12 mt-5 w-full"
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
