<script setup>
import ApplicationMark from "@/Components/ApplicationMark.vue";
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import moment from "moment";
import { Head, Link, useForm } from "@inertiajs/vue3";

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
const ladate1 = ref("aujoudh'ui");
const commentaires = ref("Ajouter un commentaire");
const heures = ref();
const heureCommande = ref(false);
const Commentaires = ref(false);
const modeReception = ref(false);
const reception = ref("");
const Nom = ref(null);
const Telephone = ref(null);
const final = ref(false);
const Adresse = ref(null);
const panier = ref(false);
const panier1 = ref(false);
const yesNon = ref(false);
const isLoading = ref(false);
const resume = ref(true);
const methode = ref(false);
const alert = ref(false);
const indication = ref(false);

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

const allCompleted = computed(() => {
  return heureCommande.value && modeReception.value;
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

const StartAnimation = () => {
  console.log("count= ", count.value);
  if (count.value != 0) {
    isLoading.value = true;
    setTimeout(() => {
      isLoading.value = false;
      resume.value = false;
      methode.value = true;
    }, 1000);
  } else {
    alert.value = true;
    setTimeout(() => {
      alert.value = false;
      indication.value = true;
      setTimeout(() => {
        indication.value = false;
      }, 1000);
    }, 2000);
  }
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

const CommandeDate = (memejour, heure, fait) => {
  ladate.value = memejour;

  if (ladate.value != "aujourd'hui") {
    ladate1.value = moment(memejour).startOf("day").format("YYYY-MM-DD");
    const now = ladate.value;
    let nomJour = { weekday: "long" };
    ladate.value = now.toLocaleDateString("fr-FR", nomJour);
  } else {
    const newa = new Date();
    ladate1.value = moment(newa).startOf("day").format("YYYY-MM-DD");
  }
  heures.value = heure;
  heureCommande.value = fait;
};

const MonCommentaire = (commentaire, fait) => {
  commentaires.value = commentaire;
  Commentaires.value = fait;
};

const Terminal = (nomClient, telephoneClient, adresseClient) => {
  Nom.value = nomClient;
  Telephone.value = telephoneClient;
  Adresse.value = adresseClient;
  yesNon.value = true;
  console.log(adresseClient);
};

const shake = () => {
  isShaking.value = true;
  setTimeout(() => {
    isShaking.value = false;
  }, 1000);
};

const orderId = Math.random().toString(36).substr(2, 9);

const sendOrderData = () => {
  const form = useForm({
    orderId: orderId,
    Total: total.value,
    MonCommentaire: commentaires.value,
    TypeReception: reception.value,
    laDate: ladate1.value,
    Lheure: heures.value,
    NomClient: Nom,
    TelClient: Telephone.value,
    AdresseClient: Adresse,
    panierr: JSON.stringify(cart.value),
  });

  // Utilisez ici l'API de votre choix pour envoyer les données vers le serveur
  form.post(route("validation.commande"), {
    onSuccess: () => {
      final.value = true;
      methode.value = false;
      resume.value = true
      commentaires.value = 'Ajouter un commentaire'
    },
    onError: () => {
      panier.value = true; // affiche le modal de validation
      console.log(panier1.value);
      setTimeout(() => {
        console.log("here");
        panier1.value = false;
      }, 2000);
    },
  });

  cart.value = [];
  count.value = 0;

  // enregistrer les données du panier dans le localStorage
  localStorage.removeItem("cart");
  console.log("form:", form);
  console.log(typeof total.value);
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
          <a
            :href="route('acceuil')"
            class="text-3xl lg:block md:block hidden lg:ml-0 text-center bg-black text-white px-2 md:ml-0 font-title font-extrabold"
          >
            EatEasy
          </a>
          <ApplicationMark class="h-9 w-auto lg:hidden md:hidden" />
          <p class="font-bold lg:text-xl text-lg ml-8 lg:hidden md:hidden">
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

          <div v-if="count">
            <div
              class="p-5 bg-white shadow-700 hover:scale-95 md:p-8 lg:h-68 lg:w-full border-b border-gray-200"
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
                    <button class="text-gray-600 text-sm mr-2">
                      Ajouter aux favoris
                    </button>
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
          <div v-else class="flex flex-col space-y-3 justify-center items-center">
            <img
              src="//sheinsz.ltwebstatic.com/she_dist/images/shoppingcart-empty-50eb82fb72.png"
              class="empty-img"
            />
            <span class="text-black font bold lg:text-2xl">Votre panier est vide</span>
            <a
              :class="`shake ${indication ? 'animate-shake ' : ''}`"
              class="bg-black p-2 text-white font-bold hover:bg-gray-600"
              :href="route('acceuil')"
              >Commander maintenant</a
            >
          </div>
        </div>
        <div
          class="w-full mt-4 flex flex-col mb-10 sm:mb-12 lg:mb-0 md:w-[20rem] lg:w-[30rem]"
        >
          <div class="w-full bg-white p-2" v-if="resume">
            <div class="mb-4 flex flex-col space-x-4 rtl:space-x-reverse">
              <span class="text-xl flex items-center justify-center font-bold font-serif"
                >Resume de votre commande</span
              >
            </div>
            <div class="mt-4">
              <div class="flex justify-between items-center"></div>

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
                <span class="mr-auto text-sm lg:text-md font-bold uppercase text-red-500"
                  >{{ ladate1 }} a {{ heures }}</span
                >
              </button>
              <button
                @click="CloseComment()"
                class="px-3 hover:shadow border-gray-200 border-b h-16 flex text-gray-500 w-full"
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
                <span class="mr-auto">{{ commentaires }}</span>
              </button>

              <select
                v-model="reception"
                @click="modeReception = true"
                class="lg:w-80 md:w-full w-full flex md:justify-center rounded-full mt-4 border-gray-200 focus:ring-black focus:border-none"
              >
                <option value="A emporter" class="text-center">A emporter</option>
                <option value="A emporter" class="text-center">Livraison</option>
                <option value="Sur place" class="text-center">Sur place</option>
              </select>

              <div class="flex justify-between py-2">
                <div class="flex items-center justify-between text-base">
                  <span class="text-sm text-body"
                    ><span class="mx-2">Total a payer</span>
                  </span>
                </div>
                <span class="text-lg font-bold text-red-500 text-body"
                  >{{ total }} FCFA</span
                >
              </div>
            </div>
            <button
              :disabled="!allCompleted"
              @click="StartAnimation()"
              data-variant="normal"
              :class="{ 'btn-clicked bg-gray-600': isLoading }"
              class="my-button inline-flex items-center justify-center shrink-0 font-bold text-2xl leading-none rounded outline-none transition duration-300 ease-in-out focus:outline-none focus:shadow focus:ring-1 focus:ring-black bg-black text-white border border-transparent hover:bg-gray-600 px-5 py-0 h-12 mt-5 w-full"
            >
              <span class="mr-2">Continuer...</span>
              <svg
                v-if="isLoading"
                :class="{ 'animate-spin ': isLoading }"
                id="spinner"
                class="w-6 h-6 icon text-white"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                stroke="#ffffff"
              >
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g
                  id="SVGRepo_tracerCarrier"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                ></g>
                <g id="SVGRepo_iconCarrier">
                  <path
                    d="M20.0001 12C20.0001 13.3811 19.6425 14.7386 18.9623 15.9405C18.282 17.1424 17.3022 18.1477 16.1182 18.8587C14.9341 19.5696 13.5862 19.9619 12.2056 19.9974C10.825 20.0328 9.45873 19.7103 8.23975 19.0612"
                    stroke="#000000"
                    stroke-width="3.55556"
                    stroke-linecap="round"
                  ></path>
                </g>
              </svg>
            </button>
          </div>
          <div class="mb-4 uppercase flex flex-col rtl:space-x-reverse" v-if="resume">
            <span class="text-xl flex font-bold font-serif">Nous acceptons</span>
            <div class="flex">
              <!-- <div class="flex py-3 relative mr-3">
                    <span class="bg-vert font-bold text-white w-11 px-2 py-1 absolute z-10 rounded-full">PAY</span>
                    <span class="bg-green-600 font-bold w-24 px-2 flex items-center  justify-end rounded-full text-white">TECH</span>
                </div> -->
              <img
                src="//img.ltwebstatic.com/images2_pi/2018/06/06/15282733431754785346.webp"
                class="h-12 mr-3"
              />
              <img
                src="//img.ltwebstatic.com/images2_pi/2018/06/06/15282732803587566708.webp"
                class="h-12 mr-3"
              />
              <img
                src="../../../../storage/app/public/paytech.jpg"
                class="h-12 w-28 lg:w-full"
              />
            </div>
          </div>
          <transition name="panier">
            <div
              v-if="methode"
              class="mb-4 p-3 bg-white flex flex-col rtl:space-x-reverse"
            >
              <span class="text-xl mb-10 flex font-bold">Methode de paiement</span>
              <span
                class="text-sm text-red-500 mb-4"
                v-if="warning"
                :class="`shake ${click ? 'animate-shake ' : ''}`"
                >Veuiller choisir la methode</span
              >
              <div class="flex flex-col space-y-2">
                <div class="flex space-x-2">
                  <button
                    :class="`shake ${click ? 'animate-shake ' : ''}`"
                    @click="Paypal()"
                    class="bg-white focus:border-2 focus:border-vert active:border-vert border border-gray-300 rounded-md w-24 h-16 p-2"
                  >
                    <img
                      src="//img.ltwebstatic.com/images2_pi/2018/06/06/15282733431754785346.webp"
                      class="h-12 mr-3"
                    />
                  </button>
                  <button
                    :class="`shake ${click ? 'animate-shake' : ''}`"
                    @click="Card()"
                    class="bg-white border focus:border-2 focus:border-vert active:border-vert border-gray-300 rounded-md w-24 h-16 p-2"
                  >
                    <img
                      src="//img.ltwebstatic.com/images2_pi/2018/06/06/15282732803587566708.webp"
                      class="h-12 mr-3"
                    />
                  </button>
                  <button
                    :class="`shake ${click ? 'animate-shake' : ''}`"
                    @click="Paytech()"
                    class="bg-white focus:border-2 focus:border-vert active:border-vert border border-gray-300 rounded-md w-24 h-16 p-2"
                  >
                    <img
                      src="../../../../storage/app/public/paytech.jpg"
                      class="h-12 w-28 lg:w-full"
                    />
                  </button>
                </div>

                <div>
                  <button
                    @click="DefinirPaiement()"
                    class="text-white mt-10 text-xl font-bold bg-black w-full p-3 hover:bg-gray-600"
                  >
                    Valider
                  </button>
                </div>
              </div>
            </div>
          </transition>
        </div>
      </div>
    </div>
  </div>
  <Commentaire
    v-if="commentaire"
    @LeCommentaire="MonCommentaire"
    @close="CloseComment()"
  />
  <Paiement
    :show="paiement"
    :paytech="paytech"
    :paypal="paypal"
    :card="card"
    @PhaseFinale="Terminal"
    @close="ClosePaiment()"
  />
  <DateCommande
    v-if="date"
    @DateHeure="CommandeDate"
    :dater="date"
    @close="DefinirDate()"
  />
  <div
    @click="ClosePaiment()"
    v-if="paiement"
    class="z-50 transform-gpu fixed top-0 left-0 w-full h-full bg-opacity-30 bg-black flex justify-center"
  ></div>
  <div
    @click.self="yesNon = false"
    v-if="yesNon"
    class="z-50 transform-gpu fixed top-0 left-0 w-full h-full bg-opacity-30 bg-black flex justify-center"
  ></div>
  <transition name="panierrr">
    <div
      v-if="yesNon"
      @click.self="yesNon = false"
      class="modal z-[52] fixed top-36 duration-700 ease-in-out w-full"
    >
      <div class="modal-dialog mx-auto w-11/12 md:w-2/3 lg:w-1/3 my-12 md:my-24 lg:my-28">
        <div
          class="modal-content relative flex flex-col h-full bg-white shadow-lg rounded-md text-current"
        >
          <div
            class="modal-header h-12 bg-gray-100 flex-shrink-0 items-center justify-between px-4 py-3 border-b border-gray-200 rounded-t-md"
          >
            <h5
              class="text-xl font-bold flex items-center justify-center leading-normal text-gray-800"
            >
              Je confirme le paiement
            </h5>
          </div>

          <div
            class="modal-footer bg-white space-x-4 flex items-center justify-center px-4 py-3 border-t border-gray-200 rounded-b-md"
          >
            <button
              @click="sendOrderData(), (yesNon = false)"
              type="button"
              class="px-6 flex w-56 items-center justify-center py-2.5 bg-vert text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-haver hover:shadow-lg focus:bg-haver focus:shadow-lg focus:outline-none focus:ring-0 active:bg-haver active:shadow-lg transition duration-150 ease-in-out"
            >
              Oui
            </button>
            <button
              @click="yesNon = false"
              type="button"
              class="px-6 flex w-56 items-center justify-center py-2.5 bg-red-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-haver hover:shadow-lg focus:bg-haver focus:shadow-lg focus:outline-none focus:ring-0 active:bg-haver active:shadow-lg transition duration-150 ease-in-out"
            >
              Non
            </button>
          </div>
        </div>
      </div>
    </div>
  </transition>
  <div
    @click.self="final = false"
    v-if="final"
    class="z-50 transform-gpu fixed top-0 left-0 w-full h-full bg-opacity-30 bg-black flex justify-center"
  ></div>
  <div
    @click.self="alert = false"
    v-if="alert"
    class="z-50 transform-gpu fixed top-0 left-0 w-full h-full bg-opacity-30 bg-black flex justify-center"
  ></div>
  <transition name="panierrr">
    <div
      v-if="final"
      @click.self="final = false"
      class="modal z-[52] fixed top-0 duration-700 ease-in-out w-full"
    >
      <div class="modal-dialog mx-auto w-11/12 md:w-2/3 lg:w-1/3 my-12 md:my-24 lg:my-28">
        <div
          class="modal-content px-3 relative flex flex-col h-full bg-white shadow-lg rounded-md text-current"
        >
          <div
            class="modal-footer space-y-1 bg-white flex flex-col items-center justify-center py-3 border-t border-gray-200 rounded-md"
          >
            <div class="flex flex-col space-y-1">
              <div class="flex flex-col items-center justify-center">
                <span class="text-3xl font-bold text-red-500">Merci {{ Nom }} !</span>
                <span class="text-black text-2xl">Votre commande a bien ete cree.</span>
                <span class="text-gray-600 text-sm"
                  >Un e-mail de confirmation vous a ete envoye</span
                >
              </div>
              <div class="flex flex-col items-center justify-center space-y-2">
                <img
                  src="//sheinsz.ltwebstatic.com/she_dist/images/shoppingcart-empty-50eb82fb72.png"
                  class="empty-img"
                />
                <span class="text-gray-500 text-sm"
                  >Votre commande est en cours de preparation est sera prete</span
                >
                <div class="flex space-x-2">
                  <span class="text-red-500 uppercase font-bold">{{ ladate }}</span>
                  <span class="text-red-500">a</span>
                  <span class="text-red-500 font-bold">{{ heures }}</span>

                </div>
              </div>
              <div class="flex flex-col space-y-4 items-center justify-center">
                <span class="text-gray-500">Votre Numero de commande est: </span>
                <span class="text-gray-500 text-6xl">{{ orderId }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>

  <transition name="panier">
    <div
      v-if="panier"
      class="bg-vert font-bold flex h-14 text-white rounded-md p-4 fixed top-[39rem] right-4"
    >
      <div class="flex mb-3">
        <span class="text-2xl font-bold">Commande reussie!</span>
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
  <transition name="panier">
    <div
      v-if="panier1"
      class="bg-red-500 font-bold flex h-14 text-white rounded-md p-4 fixed top-[39rem] right-4"
    >
      <div class="flex mb-3">
        <span class="text-2xl font-bold">Commande echouee!</span>
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
  <transition name="pani">
    <div
      v-if="alert"
      class="bg-white font-bold z-[50] flex h-14 text-white p-4 fixed top-10 left-[30rem]"
    >
      <div class="flex mb-3">
        <span class="text-lg text-black font-bold">Panier vide. Commandez d'abord!</span>
        <svg
          class="w-8 h-8 icon ml-4"
          version="1.1"
          id="Layer_1"
          xmlns="http://www.w3.org/2000/svg"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          viewBox="0 0 511.999 511.999"
          xml:space="preserve"
          fill="#000000"
        >
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g
            id="SVGRepo_tracerCarrier"
            stroke-linecap="round"
            stroke-linejoin="round"
          ></g>
          <g id="SVGRepo_iconCarrier">
            <g>
              <circle
                style="fill: #ffffff"
                cx="255.999"
                cy="255.998"
                r="212.621"
              ></circle>
              <path
                style="fill: #ffffff"
                d="M107.652,356.448l248.798-248.795c-28.648-19.435-63.221-30.794-100.448-30.794 c-98.938,0-179.142,80.205-179.142,179.142C76.858,293.226,88.216,327.799,107.652,356.448z"
              ></path>
            </g>
            <path
              style="opacity: 0.1; enable-background: new"
              d="M89.216,321.497c-0.473-5.767-0.721-11.597-0.721-17.486 c0-116.755,94.649-211.404,211.404-211.404c12.308,0,24.369,1.053,36.1,3.072c-24.08-12.04-51.245-18.821-79.999-18.821 c-98.938,0-179.142,80.205-179.142,179.142C76.858,279.117,81.241,301.21,89.216,321.497z"
            ></path>
            <path
              style="fill: #ff6465"
              d="M256,8.329C119.215,8.329,8.33,119.215,8.33,255.999S119.215,503.67,256,503.67 s247.671-110.886,247.671-247.671S392.786,8.329,256,8.329z M76.858,255.999c0-98.938,80.205-179.142,179.142-179.142 c37.227,0,71.8,11.358,100.448,30.794L107.652,356.448C88.216,327.799,76.858,293.226,76.858,255.999z M256,435.143 c-37.227,0-71.8-11.358-100.448-30.794L404.35,155.552c19.435,28.648,30.794,63.221,30.794,100.448 C435.143,354.937,354.938,435.143,256,435.143z"
            ></path>
            <path
              d="M256,0c-23.87,0-47.508,3.286-70.263,9.767c-4.423,1.26-6.989,5.868-5.728,10.292c1.26,4.423,5.862,6.991,10.292,5.728 c21.27-6.058,43.374-9.13,65.699-9.13c63.931,0,124.035,24.896,169.24,70.102c45.206,45.206,70.102,105.31,70.102,169.24 c0,88.293-48.368,169.132-126.228,210.969c-4.051,2.177-5.573,7.227-3.395,11.279c1.504,2.799,4.375,4.389,7.344,4.389 c1.33,0,2.681-0.32,3.935-0.994c83.272-44.745,135.001-131.205,135.001-225.642c0-68.381-26.629-132.667-74.98-181.019 C388.668,26.629,324.381,0,256,0z"
            ></path>
            <path
              d="M361.126,100.759c-31.079-21.086-67.432-32.231-105.125-32.231c-103.372,0-187.471,84.099-187.471,187.471 c0,37.691,11.145,74.043,32.23,105.123c1.395,2.056,3.633,3.38,6.106,3.616c0.263,0.024,0.526,0.038,0.788,0.038 c2.198,0,4.32-0.871,5.889-2.44L362.339,113.54c1.756-1.756,2.636-4.204,2.402-6.676 C364.506,104.392,363.18,102.153,361.126,100.759z M109.103,343.218c-15.677-26.332-23.916-56.276-23.916-87.218 c0-94.187,76.626-170.813,170.813-170.813c30.943,0,60.887,8.238,87.218,23.916L109.103,343.218z"
            ></path>
            <path
              d="M343.188,496.758c4.324-1.567,6.56-6.342,4.994-10.668c-1.566-4.327-6.343-6.559-10.668-4.995 c-26.097,9.454-53.523,14.247-81.514,14.247c-63.93,0-124.033-24.896-169.24-70.102c-45.207-45.206-70.103-105.31-70.103-169.241 c0-46.779,13.494-92.088,39.026-131.031c24.888-37.966,59.812-67.974,100.995-86.784c4.184-1.911,6.027-6.852,4.116-11.036 s-6.853-6.027-11.036-4.117c-44.043,20.117-81.392,52.208-108.005,92.804C14.439,157.5,0.001,205.968,0.001,255.999 c0,68.38,26.629,132.667,74.982,181.019s112.639,74.98,181.019,74.98C285.932,512,315.267,506.872,343.188,496.758z"
            ></path>
            <path
              d="M147.261,405.135c0.235,2.472,1.56,4.711,3.616,6.106c31.079,21.086,67.432,32.231,105.125,32.231 c103.372,0,187.471-84.099,187.471-187.471c0-37.692-11.144-74.044-32.23-105.123c-1.394-2.056-3.633-3.38-6.105-3.616 c-2.469-0.232-4.922,0.646-6.678,2.402L149.663,398.459C147.907,400.215,147.026,402.663,147.261,405.135z M402.899,168.782 c15.675,26.329,23.915,56.277,23.915,87.218c0,94.187-76.626,170.813-170.813,170.813c-30.943,0-60.887-8.238-87.218-23.916 L402.899,168.782z"
            ></path>
          </g>
        </svg>
      </div>
    </div>
  </transition>
</template>
<script>
import Commentaire from "./Commentaire.vue";
import DateCommande from "./DateCommande.vue";
import Paiement from "./Paiement.vue";
export default {
  data() {
    return {
      open: false,
      commentaire: false,
      paiement: false,
      date: false,

      ladate: "aujourd'hui",
      heure: "",

      paypal: false,
      paytech: false,
      card: false,
      click: false,
      warning: false,
    };
  },

  components: { Commentaire, DateCommande, Paiement },
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
    DefinirPaiement() {
      if (this.paypal == false && this.paytech == false && this.card == false) {
        this.click = true;
        this.warning = true;
        setTimeout(() => {
          this.click = false;
        }, 1000);
      } else {
        this.paiement = true;
        this.warning = false;
      }
    },
    ClosePaiment() {
      this.paiement = false;
      this.paypal = false;
      this.paytech = false;
      this.card = false;
    },

    Paypal() {
      this.paypal = true;
      this.paytech = false;
      this.card = false;
      this.warning = false;
    },
    Paytech() {
      this.paytech = true;
      this.paypal = false;
      this.card = false;
      this.warning = false;
    },
    Card() {
      this.card = true;
      this.paypal = false;
      this.paytech = false;
      this.warning = false;
    },
  },
};
</script>
<style scoped>
.btn-clicked svg path {
  stroke: #fff;
}
.panier-enter-active,
.panier-leave-active {
  transition: transform 0.5s ease, opacity 0.5s ease;
  transform: translateY(90%);
  opacity: 0;
}

.panier-enter,
.panier-leave-to {
  opacity: 0;
  transform: translateY(0);
}

.panier-leave,
.panier-enter-to {
  opacity: 1;
  transform: translateY(0);
}
.my-button:disabled {
  cursor: not-allowed;
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

.panierrr-enter-active,
.panierrr-leave-active {
  transition: transform 0.5s ease, opacity 0.5s ease;
  transform: translateY(10%);
  opacity: 0;
}

.panierrr-enter,
.panierrr-leave-to {
  opacity: 0;
  transform: translateY(10%);
}

.panierrr-leave,
.panierrr-enter-to {
  opacity: 1;
  transform: translateY(0);
}

.pani-enter-active,
.pani-leave-active {
  transition: transform 0.2s ease, opacity 0.5s ease;
  transform: translateY(-30%);
  opacity: 0;
}

.pani-enter,
.pani-leave-to {
  opacity: 0;
  transform: translateY(-30%);
}

.pani-leave,
.pani-enter-to {
  opacity: 1;
  transform: translateY(0);
}
</style>
