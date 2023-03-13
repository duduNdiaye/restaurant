<script setup>
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { defineProps, onMounted, computed, reactive, ref } from "vue";
import axios from "axios";
const temoin = ref("");
const cart = ref([]);
const count = ref(0);
const count1 = ref(false);
const contenu = ref("Articles");
const restosearch = ref("");
const showComponent = ref(false);
const texte = ref(false);
const selectedRestaurant = ref('')
const pulse = ref(0);
const drop = ref(false);

onMounted(() => {
  pulse.value = props.users.length
});

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

};

const recherche = computed(() => {


    if (restosearch.value) {
      return props.users.filter((user) =>
        user.name.toLowerCase().startsWith(restosearch.value.toLocaleLowerCase())
      );
    } else {
      return props.users;
    }
});

console.log("users:",recherche)

const onInput = () => {
    if(restosearch.value != '') {
      drop.value = true;
    } else {
      drop.value = false;
    }
};

const Chercher = (name) => {
    restosearch.value = name;
};

const scrollToResults = () => {
  // Vérifie si la référence vers la section des résultats est définie
  const results = document.getElementById("result");
  if (results) {
    results.scrollIntoView({ behavior: "smooth", block: "start", inline: "nearest" });
  }
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
        <!-- <ApplicationMark class="h-9 w-auto lg:hidden md:hidden" /> -->
        <div>
          <p class="font-bold text-xl ml-8 lg:hidden md:hidden" v-if="texte">
            Que desirez-vous manger?
          </p>
        </div>

          <div
            class="pt-2 relative md:hidden lg:block sm:block mx-auto text-gray-600"

          >
            <input @input="onInput()"
              v-model="restosearch"

              @keydown.enter="scrollToResults(),drop=false"
              class="border-none bg-gray-200 focus:ring-0 focus:border-none lg:ml-16 lg:w-96 h-[3rem] px-5 pr-16 rounded-lg text-sm focus:outline-none"
              type="search"
              autocomplete="off"
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
            <div v-if="drop" class="absolute rounded-md border border-gray-300 lg:ml-16 lg:w-96 mt-2 bg-white overflow-hidden ">
                <div class=" py-2 px-3">
                    <p v-for="user in recherche" @click="Chercher(user.name)" :key="user.id" class="cursor-pointor text-sm hover:bg-gray-100 text-start font-medium text-gray-600 py-2 border-b border-gray-100">{{user.name}}</p>
                </div>
            </div>
          </div>

      </div>

      <div
        class="md:flex bg-white lg:border-none md:border-none lg:bg-opacity-0 border-t-2 border-b-2 border-gray-200 md:items-center md:px-0 px-3 md:pb-0 pb-10 md:static absolute md:w-auto w-full top-14 duration-300 ease-in"

      >
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

          </div>
        </div>
      </div>
    </div>
  </div>
  <section class="text-gray-600 body-font bg-white mt-10">
    <div class="container px-2 py-4 mx-auto flex flex-wrap lg:block md:block hidden">
      <div class="flex flex-wrap -m-4">
        <div
          class="p-4 lg:w-4/12 w-full lg:block md:block hidden hover:scale-105 transition duration-200"
        >
          <div
            class="flex relative items-center justify-center bg-white border-2 border-gray-300 border-opacity-50 p-4 sm:flex-row flex-col"
          >
            <div class="flex-grow items-center">
              <div
                class="absolute bg-vert rounded-full p-2 -translate-x-1/2 -translate-x-1/2 left-1/2 top-[-1.5rem]"
              >
                <svg
                  fill="#ffffff"
                  class="w-14 h-14 icon"
                  version="1.1"
                  id="Layer_1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  viewBox="0 0 511.999 511.999"
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
                      <g>
                        <path
                          d="M256.747,86.809C149.033,86.809,61.4,174.442,61.4,282.156c0,107.715,87.633,195.348,195.347,195.348 c107.715,0,195.347-87.633,195.347-195.348C452.094,174.441,364.462,86.809,256.747,86.809z M256.747,462.295 c-99.328,0-180.138-80.81-180.138-180.139s80.81-180.138,180.138-180.138c99.329,0,180.138,80.809,180.138,180.138 S356.076,462.295,256.747,462.295z"
                        ></path>
                      </g>
                    </g>
                    <g>
                      <g>
                        <path
                          d="M256.748,155.943c-69.594,0-126.214,56.619-126.214,126.213c0,11.232,1.478,22.375,4.392,33.119l14.678-3.983 c-2.564-9.445-3.863-19.249-3.863-29.137c0-61.208,49.797-111.004,111.005-111.004c17.825,0,34.844,4.093,50.584,12.167 l6.941-13.534C296.364,160.6,277.01,155.943,256.748,155.943z"
                        ></path>
                      </g>
                    </g>
                    <g>
                      <g>
                        <path
                          d="M156.761,330.436l-13.691,6.624c7.979,16.492,19.726,31.348,33.97,42.961l9.611-11.787 C174.116,358.013,163.78,344.943,156.761,330.436z"
                        ></path>
                      </g>
                    </g>
                    <g>
                      <g>
                        <path
                          d="M333.721,182.124l-9.282,12.046c27.526,21.212,43.314,53.281,43.314,87.984c0,61.208-49.797,111.005-111.005,111.005 c-21.791,0-42.88-6.309-60.991-18.241l-8.368,12.699c20.602,13.575,44.585,20.751,69.359,20.751 c69.595,0,126.214-56.619,126.214-126.214C382.961,242.698,365.013,206.238,333.721,182.124z"
                        ></path>
                      </g>
                    </g>
                    <g>
                      <g>
                        <path
                          d="M63.945,48.058v88.065H47.181V48.058H31.972v88.065H15.209V48.058H0v88.065v13.111v2.098h0.057 c0.96,18.283,14.386,33.312,31.916,36.738v281.83h15.209V188.07c17.529-3.427,30.955-18.455,31.916-36.739h0.057v-2.098v-13.111 V48.058H63.945z M39.577,173.601c-12.73,0-23.211-9.813-24.278-22.27h48.557C62.787,163.788,52.306,173.601,39.577,173.601z"
                        ></path>
                      </g>
                    </g>
                    <g>
                      <g>
                        <path
                          d="M499.327,42.243c-22.486,13.731-36.456,38.628-36.456,64.975V273.63h33.919v196.269h15.209v-196.27v-92.423V34.496 L499.327,42.243z M496.791,181.205v77.215h-18.711V107.217c0-16.624,6.948-32.525,18.711-43.896V181.205z"
                        ></path>
                      </g>
                    </g>
                  </g>
                </svg>
              </div>
              <h2
                class="text-vert flex items-center justify-center text-center text-2xl title-font font-bold mb-3"
              >
                Trouver ici vos restaurants preferes
              </h2>
              <span class="flex items-center justify-center text-center"
                >Avec des services a couper le souffles, des varietes de plats, tous a
                porter de clic</span
              >
            </div>
          </div>
        </div>
        <div
          class="p-4 lg:w-4/12 w-full lg:block md:block hidden hover:scale-105 transition duration-200"
        >
          <div
            class="flex relative items-center justify-center bg-white border-2 border-gray-300 border-opacity-50 p-4 sm:flex-row flex-col"
          >
            <div class="flex-grow items-center">
              <div
                class="absolute bg-vert rounded-full p-2 -translate-x-1/2 -translate-x-1/2 left-1/2 top-[-1.5rem]"
              >
                <svg
                  class="w-14 h-14 icon"
                  viewBox="0 0 24 24"
                  stroke="#fff"
                  fill="#ffffff"
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
                      d="M17.2 20.7501C17.0776 20.7499 16.9573 20.7189 16.85 20.6601L12 18.1101L7.14999 20.6601C7.02675 20.7262 6.88746 20.7566 6.74786 20.7478C6.60825 20.7389 6.47391 20.6912 6.35999 20.6101C6.24625 20.5267 6.15796 20.4133 6.10497 20.2826C6.05199 20.1519 6.03642 20.0091 6.05999 19.8701L6.99999 14.4701L3.05999 10.6501C2.96124 10.5512 2.89207 10.4268 2.86027 10.2907C2.82846 10.1547 2.83529 10.0124 2.87999 9.88005C2.92186 9.74719 3.00038 9.62884 3.10652 9.53862C3.21266 9.4484 3.34211 9.38997 3.47999 9.37005L8.89999 8.58005L11.33 3.67005C11.3991 3.55403 11.4973 3.45795 11.6147 3.39123C11.7322 3.32451 11.8649 3.28943 12 3.28943C12.1351 3.28943 12.2678 3.32451 12.3853 3.39123C12.5027 3.45795 12.6008 3.55403 12.67 3.67005L15.1 8.58005L20.52 9.37005C20.6579 9.38997 20.7873 9.4484 20.8935 9.53862C20.9996 9.62884 21.0781 9.74719 21.12 9.88005C21.1647 10.0124 21.1715 10.1547 21.1397 10.2907C21.1079 10.4268 21.0387 10.5512 20.94 10.6501L17 14.4701L17.93 19.8701C17.9536 20.0091 17.938 20.1519 17.885 20.2826C17.832 20.4133 17.7437 20.5267 17.63 20.6101C17.5034 20.6976 17.3539 20.7463 17.2 20.7501ZM12 16.5201C12.121 16.5215 12.2403 16.5488 12.35 16.6001L16.2 18.6001L15.47 14.3101C15.4502 14.1897 15.4589 14.0664 15.4953 13.9501C15.5318 13.8337 15.595 13.7275 15.68 13.6401L18.8 10.6401L14.49 10.0001C14.3708 9.98109 14.2578 9.93401 14.1605 9.86271C14.0631 9.79141 13.9841 9.69795 13.93 9.59005L12 5.69005L10.07 9.60005C10.0159 9.70795 9.9369 9.80141 9.83952 9.87271C9.74214 9.94401 9.62918 9.99109 9.50999 10.0101L5.19999 10.6401L8.31999 13.6401C8.40493 13.7275 8.46817 13.8337 8.50464 13.9501C8.54111 14.0664 8.54979 14.1897 8.52999 14.3101L7.79999 18.6301L11.65 16.6301C11.7573 16.5683 11.8767 16.5308 12 16.5201Z"
                      fill="#000000"
                    ></path>
                  </g>
                </svg>
              </div>
              <h2
                class="text-vert flex items-center justify-center text-center text-2xl title-font font-bold mb-3"
              >
                Pouvez aussi voir les notations de chaque restaurant
              </h2>
              <span class="flex items-center justify-center text-center"
                >Des notations basees sur le restaurant, ainsi que de la qualite de ses
                produits et sevices</span
              >
            </div>
          </div>
        </div>
        <div
          class="p-4 lg:w-4/12 w-full lg:block md:block hidden hover:scale-105 transition duration-200"
        >
          <div
            class="flex relative items-center justify-center bg-white border-2 border-gray-300 border-opacity-50 p-4 sm:flex-row flex-col"
          >
            <div class="flex-grow items-center">
              <div
                class="absolute bg-vert rounded-full p-2 -translate-x-1/2 -translate-x-1/2 left-1/2 top-[-1.5rem]"
              >
                <svg
                  fill="#ffffff"
                  version="1.1"
                  id="Layer_1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                  class="w-14 h-14 icon"
                  viewBox="0 0 256 241"
                  enable-background="new 0 0 256 241"
                  xml:space="preserve"
                >
                  <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                  <g
                    id="SVGRepo_tracerCarrier"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  ></g>
                  <g id="SVGRepo_iconCarrier">
                    <path
                      d="M254,188V2H2v186h111v29H75v22h106v-22h-38v-29H254z M19,19h217v151H19L19,19z M75.397,68.237l8.796,68.658h29.376 l8.71-68.658H86.327l-7.173-24.85l-3.928,1.11l6.832,23.654L75.397,68.237z M126.463,108.287c0,0-1.11-9.991,14.176-9.991h24.338 c15.2,0,14.176,9.991,14.176,9.991H126.463z M179.066,126.903c0,0,1.025,9.991-14.176,9.991h-24.252 c-15.286,0-14.176-9.991-14.176-9.991H179.066z M128.769,122.036c-2.476,0-4.526-1.964-4.526-4.526c0-2.476,1.964-4.526,4.526-4.526 h48.334c2.476,0,4.526,1.964,4.526,4.526c0,2.476-2.049,4.526-4.526,4.526H128.769z M182.653,150.387H73.347v-8.283h109.306V150.387 z"
                    ></path>
                  </g>
                </svg>
              </div>
              <h2
                class="text-vert flex items-center justify-center text-center text-2xl title-font font-bold mb-3"
              >
                Faites vos commandes facilement sans ambiguite
              </h2>
              <span class="flex items-center justify-center text-center"
                >Commander, payer de maniere securisee et pourquoi pas vous faire
                livre!</span
              >
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
      class="bg-white lg:w-[20rem] lg:block hidden h-[39.2rem] p-3 px-8 overflow-y-auto"
    >
      <div class="max-h-full flex flex-col overflow-hidden mt-8">
        <button
          class="text-lg flex items-center justify-center space-x-3 bg-gray-200 rounded-full py-2 font-semibold"
        >
          <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                d="M9.90693 3.9999C9.93791 3.99996 9.96894 4.00001 10 4.00001C10.0311 4.00001 10.0621 3.99996 10.0931 3.9999C10.4618 3.99929 10.8242 3.99869 11.147 4.08519C12.0098 4.31636 12.6836 4.99023 12.9148 5.85296C13.0013 6.1758 13.0007 6.53821 13.0001 6.90693C13.0001 6.93792 13 6.96895 13 7.00001H21C21.5523 7.00001 22 7.44772 22 8.00001C22 8.55229 21.5523 9.00001 21 9.00001H13C13 9.03107 13.0001 9.0621 13.0001 9.09309C13.0007 9.46181 13.0013 9.82422 12.9148 10.1471C12.6836 11.0098 12.0098 11.6837 11.147 11.9148C10.8242 12.0013 10.4618 12.0007 10.0931 12.0001C10.0621 12.0001 10.0311 12 10 12C9.96894 12 9.93791 12.0001 9.90692 12.0001C9.5382 12.0007 9.17579 12.0013 8.85295 11.9148C7.99022 11.6837 7.31635 11.0098 7.08519 10.1471C6.99868 9.82421 6.99928 9.46181 6.9999 9.09308C6.99995 9.0621 7 9.03106 7 9.00001H5C4.44772 9.00001 4 8.55229 4 8.00001C4 7.44772 4.44772 7.00001 5 7.00001H7C7 6.96895 6.99995 6.93792 6.9999 6.90693C6.99928 6.53821 6.99868 6.1758 7.08519 5.85296C7.31635 4.99023 7.99022 4.31636 8.85295 4.08519C9.17579 3.99869 9.5382 3.99929 9.90693 3.9999ZM9.49861 6.00536C9.39195 6.01022 9.36685 6.01805 9.37059 6.01704C9.19804 6.06328 9.06327 6.19805 9.01704 6.3706C9.0162 6.37411 9.00963 6.40483 9.00535 6.49861C9.00024 6.61064 9 6.75845 9 7.00001V9.00001C9 9.24156 9.00024 9.38937 9.00535 9.5014C9.01021 9.60806 9.01804 9.63315 9.01704 9.62942C9.06327 9.80196 9.19804 9.93674 9.37059 9.98297C9.36685 9.98197 9.39195 9.98979 9.49861 9.99466C9.61063 9.99977 9.75844 10 10 10C10.2416 10 10.3894 9.99977 10.5014 9.99466C10.608 9.98979 10.6331 9.98197 10.6294 9.98297C10.802 9.93674 10.9367 9.80196 10.983 9.62942C10.982 9.63315 10.9898 9.60806 10.9946 9.5014C10.9998 9.38937 11 9.24156 11 9.00001V7.00001C11 6.75845 10.9998 6.61064 10.9946 6.49861C10.9898 6.39196 10.982 6.36686 10.983 6.3706M9.49861 6.00536C9.61063 6.00025 9.75844 6.00001 10 6.00001L9.49861 6.00536ZM10 6.00001C10.2416 6.00001 10.3894 6.00025 10.5014 6.00536L10 6.00001ZM10.5014 6.00536C10.5952 6.00963 10.6259 6.0162 10.6294 6.01704L10.5014 6.00536ZM10.6298 6.01713C10.6298 6.01713 10.6296 6.0171 10.6294 6.01704L10.6298 6.01713ZM15.9069 11.9999C15.9379 12 15.9689 12 16 12C16.0311 12 16.0621 12 16.0931 11.9999C16.4618 11.9993 16.8242 11.9987 17.147 12.0852C18.0098 12.3164 18.6836 12.9902 18.9148 13.853C19.0013 14.1758 19.0007 14.5382 19.0001 14.9069C19.0001 14.9379 19 14.9689 19 15H21C21.5523 15 22 15.4477 22 16C22 16.5523 21.5523 17 21 17H19C19 17.0311 19.0001 17.0621 19.0001 17.0931C19.0007 17.4618 19.0013 17.8242 18.9148 18.1471C18.6836 19.0098 18.0098 19.6837 17.147 19.9148C16.8242 20.0013 16.4618 20.0007 16.0931 20.0001C16.0621 20.0001 16.0311 20 16 20C15.9689 20 15.9379 20.0001 15.9069 20.0001C15.5382 20.0007 15.1758 20.0013 14.853 19.9148C13.9902 19.6837 13.3164 19.0098 13.0852 18.1471C12.9987 17.8242 12.9993 17.4618 12.9999 17.0931C12.9999 17.0621 13 17.0311 13 17H5C4.44772 17 4 16.5523 4 16C4 15.4477 4.44772 15 5 15H13C13 14.969 12.9999 14.9379 12.9999 14.9069C12.9993 14.5382 12.9987 14.1758 13.0852 13.853C13.3164 12.9902 13.9902 12.3164 14.853 12.0852C15.1758 11.9987 15.5382 11.9993 15.9069 11.9999ZM15.4986 14.0054C15.392 14.0102 15.3669 14.018 15.3706 14.017C15.198 14.0633 15.0633 14.1981 15.017 14.3706C15.018 14.3669 15.0102 14.392 15.0054 14.4986C15.0002 14.6106 15 14.7585 15 15V17C15 17.2416 15.0002 17.3894 15.0054 17.5014C15.0102 17.6081 15.018 17.6332 15.017 17.6294C15.0633 17.802 15.198 17.9367 15.3706 17.983C15.3669 17.982 15.392 17.9898 15.4986 17.9947C15.6106 17.9998 15.7584 18 16 18C16.2416 18 16.3894 17.9998 16.5014 17.9947C16.608 17.9898 16.6331 17.982 16.6294 17.983C16.802 17.9367 16.9367 17.802 16.983 17.6294C16.982 17.6332 16.9898 17.6081 16.9946 17.5014C16.9998 17.3894 17 17.2416 17 17V15C17 14.7585 16.9998 14.6106 16.9946 14.4986C16.9898 14.392 16.982 14.3669 16.983 14.3706C16.9367 14.1981 16.802 14.0633 16.6294 14.017C16.6331 14.018 16.608 14.0102 16.5014 14.0054C16.3894 14.0002 16.2416 14 16 14C15.7584 14 15.6106 14.0002 15.4986 14.0054Z"
                fill="#0F1729"
              ></path>
            </g>
          </svg>
          <span>Trier</span>
        </button>
        <div class="flex mt-8 px-6 flex-col items-start justify-center space-y-4">
          <button
            class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
          >
            Restos par defaut
          </button>
          <button
            class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
          >
            Les mieux notes
          </button>
          <button
            class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
          >
            Avec livraison
          </button>
          <button
            class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
          >
            Plat nationaux
          </button>
          <button
            class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
          >
            Fast Food
          </button>
          <button
            class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
          >
            Patisserie
          </button>
        </div>
      </div>
    </aside>
    <div class="w-full h-fit px-4 pb-8 mb-12 lg:p-8">
      <div
        id="result"
        class="grid lg:grid-cols-[repeat(auto-fill,minmax(270px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3"
      >
        <article
          v-for="user in recherche"
          :key="user.id"
          :class="{'animate-pulse':users.length == 0}"
          class="product-card hover:shadow-xl duration-300 cart-type-neon overflow-hidden bg-white"
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
import Dropdown from "vue-dropdowns";
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
      showSearchBar: false,
      current: 0,
    };
  },
 components:{Dropdown},
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
    window.addEventListener("scroll", this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll);
  },
  methods: {
    handleScroll() {
      this.scrollY = window.scrollY;

      if (this.scrollY > 0) {
        this.showSearchBar = true;
      } else {
        this.showSearchBar = false;
      }
    },
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
