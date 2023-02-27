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
const ladate = ref("aujoudh'ui");
const heures = ref();
onMounted(() => {
  if (localStorage.getItem("cart")) {
    cart.value = JSON.parse(localStorage.getItem("cart"));
    count.value = cart.value.length;
  }
  if (count.value != 0) {
    count1.value = true;
  }

  const now = new Date();
  heures.value = now.toLocaleTimeString();
  console.log(heures.value);
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

const CommandeDate = (memejour, heure) => {
  ladate.value = memejour;
  if (ladate.value != "aujourd'hui") {
    const now = ladate.value;
    let nomJour = { weekday: "long" };
    ladate.value = now.toLocaleDateString("fr-FR", nomJour);
  }
  heures.value = heure;
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
          <p class="font-bold text-xl ml-8 lg:hidden md:hidden">
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
              class="px-3 py-2 bg-vert font-bold text-white rounded hover:bg-haver mt-3 md:mt-0"
              >Button 1</a
            >

            <template v-else>
              <a
                :href="route('login')"
                class="px-3 py-2 lg:ml-4 bg md:ml-4 text-center bg-vert font-bold text-white rounded hover:bg-haver mt-3 md:mt-0"
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
    <div
      class="px-4 py-8 bg-gray-100 lg:px-4 md:px-4 lg:py-24 xl:py-14 xl:px-16 2xl:px-20"
    >
      <div
        class="flex flex-col items-center w-full mt-16 max-w-8xl m-auto rtl:space-x-reverse lg:flex-row md:flex-row md:items-start md:space-x-4 lg:items-start lg:space-x-8"
      >
        <div class="w-full lg:max-w-[90rem] md:max-w-[35rem] max-w-8xl">
          <div class="bg-white mb-3 h-16">
            <div
              class="p-4 font-bold flex justify-between capitalize text-heading lg:text-xl"
            >
              <span class="text-gray-500 lg:text-sm lg:block md:block hidden"
                >Votre commande sur EATEASY</span
              >
              <span class="flex text-lg text-center">Resume du panier({{ count }})</span>
            </div>
          </div>
          <div
            class="p-5 bg-white shadow-700 md:p-8 lg:h-68 lg:w-full border-b border-gray-200"
            v-for="car in cart"
            :key="car.id"
          >
            <div
              class="flex flex-col md:flex-row md:space-x-4 space-y-4 lg:flex-row md:items-start items-center lg:items-start"
            >
              <div class="flex-shrink-0 w-32 lg:w-48">
                <img
                  :src="car.photo"
                  alt="Nom de l'article"
                  class="w-full h-auto md:w-56"
                />
              </div>
              <div class="flex flex-col justify-between lg:ml-4 mt-2 lg:mt-0">
                <div class="font-medium text-lg lg:text-xl lg:text-start text-center">
                  {{ car.nom }}
                </div>
                <div class="flex justify-between items-center">
                  <div
                    class="flex flex-col md:flex-row md:space-x-6 lg:flex-row lg:items-center lg:space-x-10 space-y-6"
                  >
                    <div class="flex lg:space-x-10 md:space-x-2 space-x-16 mt-1">
                      <div
                        class="text-sm text-white shrink-0 md:text-xs bg-black md:py-3 md:mt-3 py-1 lg:mt-3 px-4 rounded-full w-fit"
                      >
                        Quantité :{{ car.quantite }}
                      </div>
                      <div class="text-gray-500 font-bold lg:mt-4 md:mt-4">
                        {{ car.prix }}F
                      </div>
                    </div>
                    <div class="flex lg:space-x-[-4rem] md:space-x-[-3rem] space-x-8">
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
                      <div class="ml-auto text-red-500 font-bold mr-0">
                        Total:{{ car.total }}F
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex items-center space-x-6 mt-6">
                  <button class="text-gray-600 text-sm mr-2">Ajouter aux favoris</button>
                  <button
                    @click="removeItemFromCart(car)"
                    class="text-lg hover:font-black"
                  >
                    effacer
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full mb-10 sm:mb-12 lg:mb-0 md:w-[20rem] lg:w-[30rem]">
          <div class="w-full bg-white p-2">
            <div class="mb-4 flex flex-col space-x-4 rtl:space-x-reverse">
              <span class="text-xl flex items-center justify-center font-bold font-serif">Resume de votre commande</span>
            </div>
            <div class="mt-4">
              <div class="flex justify-between items-center">

              </div>

              <button
                @click="DefinirDate()"
                class="border-t px-2 hover:shadow border-gray-200 border-b h-10 flex justify-center text-center items-center text-gray-500 w-full"
              >
                <svg
                  class="h-6 w-6 icon mr-3"
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
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M12 4C7.58172 4 4 7.58172 4 12C4 16.4183 7.58172 20 12 20C16.4183 20 20 16.4183 20 12C20 7.58172 16.4183 4 12 4ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM11.8284 6.75736C12.3807 6.75736 12.8284 7.20507 12.8284 7.75736V12.7245L16.3553 14.0653C16.8716 14.2615 17.131 14.8391 16.9347 15.3553C16.7385 15.8716 16.1609 16.131 15.6447 15.9347L11.4731 14.349C11.085 14.2014 10.8284 13.8294 10.8284 13.4142V7.75736C10.8284 7.20507 11.2761 6.75736 11.8284 6.75736Z"
                      fill="#0F1729"
                    ></path>
                  </g>
                </svg>
                <span class="mr-2 uppercase font-bold">Pour</span>
                <span class="mr-auto font-bold uppercase text-red-500"
                  >{{ ladate }} a {{ heures }}</span
                >
              </button>
              <button
                @click="CloseComment()"
                class="px-3 hover:shadow border-gray-200 border-b h-24 flex  text-gray-500 w-full"
              >
                <svg
                  fill="#000000"
                  class="h-4 w-4 mr-3 mt-1"
                  viewBox="0 0 1920 1920"
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
                      d="M277.974 49.076c65.267-65.379 171.733-65.49 237.448 0l232.186 232.187 1055.697 1055.809L1919.958 1920l-582.928-116.653-950.128-950.015 79.15-79.15 801.792 801.68 307.977-307.976-907.362-907.474L281.22 747.65 49.034 515.464c-65.379-65.603-65.379-172.069 0-237.448Zm1376.996 1297.96-307.977 307.976 45.117 45.116 384.999 77.023-77.023-385-45.116-45.116ZM675.355 596.258l692.304 692.304-79.149 79.15-692.304-692.305 79.149-79.15ZM396.642 111.88c-14.33 0-28.547 5.374-39.519 16.345l-228.94 228.94c-21.718 21.718-21.718 57.318 0 79.149l153.038 153.037 308.089-308.09-153.037-153.036c-10.972-10.971-25.301-16.345-39.63-16.345Z"
                      fill-rule="evenodd"
                    ></path>
                  </g>
                </svg>
                <span class="mr-auto">Ajouter un commentaire</span>
              </button>

              <select
                class="w-80 rounded-full mt-4 border-gray-200 focus:ring-black focus:border-none"
              >
                <option value="1" class="text-center">A emporter</option>
                <option value="2" class="text-center">Livraison</option>
                <option value="3" class="text-center">Sur place</option>
              </select>

              <div class="flex justify-between py-2">
                <div class="flex items-center justify-between text-base">
                  <span class="text-sm text-body"
                    ><span class="mx-2">Total a payer</span>
                  </span>
                </div>
                <span class="text-lg font-bold text-red-500 text-body">{{ total }} FCFA</span>
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
  <Commentaire v-if="commentaire"  @close="CloseComment()" />
  <DateCommande
    v-if="date"
    @DateHeure="CommandeDate"
    :dater="date"
    @close="DefinirDate()"
  />
</template>
<script>
import Commentaire from "./Commentaire.vue";
import DateCommande from "./DateCommande.vue";

export default {
  data() {
    return {
      open: false,
      commentaire: false,
      comment: false,
      date: false,
      ladate: "aujourd'hui",
      heure: "",
    };
  },
  mounted() {
    // Affecter la date et l'heure actuelles aux variables
    // const now = new Date();
    // let nomJour = { weekday: 'long'};
    // this.ladate = now.toLocaleDateString('fr-FR', nomJour);
    // this.heure = now.toLocaleTimeString();
  },
  components: { Commentaire, DateCommande },
  methods: {
    toggleMenu() {
      this.open = !this.open;
    },
    CloseComment() {
      this.commentaire = !this.commentaire;
    },
    DefinirDate() {
      this.date = !this.date;
    },
  },
};
</script>
