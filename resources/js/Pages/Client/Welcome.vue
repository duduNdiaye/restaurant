<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import { ref, onMounted, computed } from "vue";
import axios from "axios";

const props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  articles: {},
  users: {},
});
const posit = ref(false);
const cart = ref([]);
const count = ref(0);
const add = ref("");
const count1 = ref(false);
const contenu = ref("Articles");
const isLoading = ref(false);
const drop = ref(false);
const defaut = ref(false);
const alert = ref(false);

const latitude = ref(0);
const longitude = ref(0);
const errorMessage = "";
const search = ref(false);
const panier = ref(false);
const restoName = ref("");

const click = ref("Partager ma position");

const restosearch = ref("");
let isPage1 = ref(true);
const cartAnimation = ref(false);
const data = () => ({
  loading: true,
});

const getPosition = () => {
  props.users = null;
  if (navigator.geolocation) {
    isLoading.value = true;

    click.value = "Patientez...";
    navigator.geolocation.getCurrentPosition(
      (position) => {
        latitude.value = position.coords.latitude;
        longitude.value = position.coords.longitude;
        console.log(latitude.value);
        console.log(longitude.value);
        alert.value = true;
        setTimeout(() => {
          alert.value = false;
        }, 2000);
      },
      (error) => {
        console.log(error.message);
      }
    );
  } else {
    console.log("Your browser does not support geolocation API");
  }
};

const ulat = ref(14.7905795);
const ulng = ref(-16.927785);
const rlat = ref(14.760464);
const rlng = ref(-16.929817);
const EARTH_RADIUS = ref(6371);

const created = () => {
  // Charger les données des articles
  fetch("articles.json")
    .then((response) => response.json())
    .then((articles) => {
      this.articles = articles;
      this.loading = false;
    });
};

onMounted(() => {
  if (localStorage.getItem("cart")) {
    cart.value = JSON.parse(localStorage.getItem("cart"));
    count.value = cart.value.length;
  }
  if (count.value != 0) {
    count1.value = true;
  }

  for (let i = 0; i < props.articles.length; i++) {
    for (let u = 0; u < props.users.length; u++) {
      if (props.articles[i].user_id == props.users[u].id) {
        props.articles[i].nomResto = props.users[u].name;
      }
    }
  }

  const lat1Rad = (ulat.value * Math.PI) / 180;
  const lon1Rad = (ulng.value * Math.PI) / 180;
  const lat2Rad = (rlat.value * Math.PI) / 180;
  const lon2Rad = (rlng.value * Math.PI) / 180;

  const dLat = lat2Rad - lat1Rad;
  const dLon = lon2Rad - lon1Rad;

  const a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(lat1Rad) * Math.cos(lat2Rad) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  const distance = EARTH_RADIUS.value * c;
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

const addItemToCart = (article) => {
  //Vérifie si l'article est déjà dans le panier
  let index = cart.value.findIndex((item) => item.nom === article.nom);
  if (index === -1) {
    cart.value.push({
      id: article.id,
      nom: article.nom,
      photo: article.photo,
      prix: parseFloat(article.prix),
      quantite: 1,
      total: parseFloat(article.prix),
      restau: article.nomResto ?? "Nom du restaurant non spécifié",
      resto_id: article.user_id
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

const recherche = computed(() => {
  if (restosearch.value) {
    return props.users.filter((user) =>
      user.name.toLowerCase().startsWith(restosearch.value.toLocaleLowerCase())
    );
  } else if (defaut == true) {
    click.value = "Partager ma position";
    return props.users;
  } else {
    return props.users;
  }
});

const Articles = computed(() => {
  if (count.value) {
    console.log("Filtre moi ca petasse")
    return props.articles.filter((article) =>
       article.nomResto == cart.value[0].restau
    );
  } else {
    return props.articles;
  }
});

const resto = computed(() => {
  const maxDistance = 2; // distance maximale en km
  const filteredRestos = props.users.filter((user) => {
    const R = 6371; // rayon de la terre en km
    const dLat = toRadians(user.latitude - latitude.value);
    const dLng = toRadians(user.longitude - longitude.value);
    const a =
      Math.sin(dLat / 2) * Math.sin(dLat / 2) +
      Math.cos(toRadians(latitude.value)) *
        Math.cos(toRadians(user.latitude)) *
        Math.sin(dLng / 2) *
        Math.sin(dLng / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c;
    return distance <= maxDistance;
  });
  return filteredRestos;
});

const toRadians = (degrees) => {
  return degrees * (Math.PI / 180);
};

const onInput = () => {
  if (restosearch.value != "") {
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
  const results = document.getElementById("results");
  if (results) {
    results.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
  }
};

const scrollToPosition = () => {
  // Vérifie si la référence vers la section des résultats est définie
  const results = document.getElementById("position");
  if (results) {
    results.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
  }
};
const scrollBack = () => {
  // Vérifie si la référence vers la section des résultats est définie
  const results = document.getElementById("default");
  if (results) {
    results.scrollIntoView({ behavior: "smooth", block: "start", inline: "nearest" });
  }
};
const scrollArticle = () => {
  // Vérifie si la référence vers la section des résultats est définie
  const results = document.getElementById("article");
  if (results) {
    results.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
  }
};
</script>

<template>
  <Head title="Welcome" />

  <div class="'bg-gray-100">
    <header>
      <nav
        id="navbar"
        class="fixed flex space-x-5 md:px-3 bg-haver z-40 transform-cpu items-center justify-center lg:justify-between lg:px-3 py-3 w-full"
      >
        <div class="flex space-x-10">
          <a
            :href="route('resto.accueil')"
            class="hover:text-vert lg:block bg-black border-white text-white hover:bg-white hidden rounded-full px-3 lg:mt-2 h-fit font-bold"
            >Le panier</a
          >

          <button
            @click="search = true"
            class="md:block lg:block hidden px-3 lg:mt-2 h-fit font-bold"
          >
            <svg
              class="w-6 h-6 icon"
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
                  d="M15 15L21 21"
                  stroke="#323232"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                ></path>
                <path
                  d="M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                  stroke="#323232"
                  stroke-width="2"
                ></path>
              </g>
            </svg>
          </button>
          <button
            @click="scrollArticle()"
            class="hover:text-vert text-black text-lg md:block lg:block hidden hover:bg-white hover:rounded-full px-3 lg:mt-2 h-fit font-bold"
          >
            Nos articles
          </button>
        </div>
        <h1
          class="text-4xl lg:text-center text-black px-2 md:ml-0 font-title font-extrabold"
        >
          ClicMiam
        </h1>
        <div v-if="canLogin" class="flex space-x-10">
          <button
            @click="scrollToPosition()"
            class="hover:text-vert lg:block hidden text-lg lg:flex text-black hover:bg-white hover:rounded-full px-3 lg:mt-1 h-fit font-bold"
          >
            <div class="relative flex h-3 w-3">
              <span
                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"
              ></span>
              <span class="inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
            </div>
            <span>Geolocalisation</span>
          </button>
          <a
            v-if="$page.props.user"
            :href="route('dashboard')"
            class="px-3 py-2 bg-vert font-bold text-white rounded hover:bg-haver mt-3 md:mt-0"
            >dashboard</a
          >

          <template v-else>
            <a
              :href="route('login')"
              class="px-3 h-fit justify-center lg:ml-4 md:ml-4 text-center bg-white font-bold text-vert hover:text-white rounded-full hover:bg-black lg:mt-1 md:mt-0"
              >Se connecter
            </a>
            <a
              v-if="canRegister"
              :href="route('register')"
              class="px-3 h-fit lg:ml-4 md:ml-4 font-bold text-center hover:text-white bg-white text-vert rounded-full lg:mt-1 hover:bg-black md:mt-0"
              >S'inscrire
            </a>
          </template>
        </div>
      </nav>
    </header>

    <div class="relative w-full lg:h-[33rem] overflow-hidden">
      <div class="carousel">
        <div class="carousel-inner">
          <div :class="['carousel-item', index1 === current ? 'active' : '']">
            <img
              src="/storage/pexels-chan-walrus-958545.jpg"
              alt="item.caption"
              class="w-full"
            />
            <div class="carousel-caption flex flex-col items-center justify-center">
              <h3 class="text-4xl text-white font-black bg-black lg:w-96">
                Bienvenue sur ClicMiam
              </h3>
            </div>
          </div>
          <div :class="['carousel-item', index2 === current ? 'active' : '']">
            <img
              src="/storage/pexels-ella-olsson-3026808.jpg"
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
              src="/storage/pexels-narda-yescas-1566837.jpg"
              alt="item.caption"
              class="w-full"
            />
            <div class="carousel-caption flex flex-col items-center justify-center">
              <h3 class="text-4xl text-white font-black bg-black w-96">
                Dans vos restaurants preferes
              </h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="text-gray-600 body-font bg-white lg:mt-10">
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
                    class="w-8 h-8 icon"
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
                    class="w-8 h-8 icon"
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
                    class="w-8 h-8 icon"
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
          class="w-[32rem] rounded-lg lg:hidden md:hidden h-52 mt-5 flex items-center justify-center"
          alt=""
        />
      </div>
    </section>
    <footer
      class="fixed bottom-0 border-t-2 z-[55] border-gray-200 shadow-2xl bg-white w-full px-6 py-3 lg:hidden md:hidden"
    >
      <div class="flex justify-between items-center">
        <div>
          <button
            @click="toggleMenu()"
            class="absolute md:hidden mt-5 left-6 top-0.5 cursor-pointer text-4xl"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="w-6 h-6"
            >
              :class="[open ? 'bi bi-x text-red-500' : 'bi bi-filter-left text-blue-500']"
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5"
              />
            </svg>
          </button>
        </div>
        <div>
          <button
            @click="toggleMenu()"
            class="absolute md:hidden mt-5 top-0.5 cursor-pointer text-4xl"
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
                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
              />
            </svg>
          </button>
        </div>
        <div>
          <button
            @click="toggleCart()"
            class="absolute md:hidden mt-5 top-0.5 cursor-pointer text-4xl"
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
                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
              />
            </svg>
          </button>
        </div>
        <div>
          <button
            @click="(showModal = !showModal), (showModal1 = !showModal1)"
            class="absolute md:hidden mt-5 top-0.5 cursor-pointer text-4xl"
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
        </div>
        <div>
          <button
            class="mt-2"
            @click="(showSearchBar = !showSearchBar), (texte = !texte)"
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
                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
              />
            </svg>
          </button>
        </div>
      </div>
    </footer>

    <!-- <div v-if="showModal1"
            class="modal fixed top-0 left-0  w-full h-full overflow-x-hidden overflow-y-auto bg-opacity-40 bg-gray-700 z-50">

        </div> -->

    <!-- modal de position -->

    <div
      :class="[showTitre ? 'left-0' : 'left-[-100%] lg:block md:block hidden']"
      class="border-l-2 border-gray-100 z-50 transform-gpu duration-700 ease-in-out fixed right-0 bottom-0 lg:h-screen lg:w-[22rem] w-[22rem] h-screen bg-white text-white p-3"
    >
      <div class="flex flex-col">
        <div class="flex justify-between border-b-2 border-gray-100 py-3">
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
              <span class="font-bold ml-2 text-vert">0 items</span>
            </div>
          </div>
          <div class="justify-end">
            <button
              @click="showTitre = false"
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
        <div>
          <aside
            class="bg-white h-[39.2rem] bg-light xl:block xl:w-72 undefined p-3 px-8 overflow-y-auto"
          >
            <div class="max-h-full flex-grow overflow-hidden">
              <ul class="text-gray-700">
                <li class="my-2 py-2 flex">
                  <svg
                    viewBox="0 0 1024 1024"
                    class="w-6 h-6 icon"
                    version="1.1"
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
                        d="M32 831.328a160 160 0 0 0 160 160h640a160 160 0 0 0 160-160H32z"
                        fill="#E29460"
                      ></path>
                      <path
                        d="M832 959.328H192a160 160 0 0 1-156.768-128H32a160 160 0 0 0 160 160h640a160 160 0 0 0 160-160h-3.232a160 160 0 0 1-156.768 128z"
                        fill=""
                      ></path>
                      <path
                        d="M960 607.328H64a64 64 0 0 0 0 128h896a64 64 0 0 0 0-128z"
                        fill="#EF4D4D"
                      ></path>
                      <path
                        d="M960 703.328H64a63.904 63.904 0 0 1-61.76-48c-1.312 5.184-2.24 10.464-2.24 16a64 64 0 0 0 64 64h896a64 64 0 0 0 64-64c0-5.568-0.928-10.848-2.24-16a63.872 63.872 0 0 1-61.76 48z"
                        fill=""
                      ></path>
                      <path
                        d="M960 351.328H64a64 64 0 0 0 0 128h896a64 64 0 0 0 0-128z"
                        fill="#EF4D4D"
                      ></path>
                      <path
                        d="M960 447.328H64a63.904 63.904 0 0 1-61.76-48c-1.312 5.184-2.24 10.464-2.24 16a64 64 0 0 0 64 64h896a64 64 0 0 0 64-64c0-5.568-0.928-10.848-2.24-16a63.872 63.872 0 0 1-61.76 48z"
                        fill=""
                      ></path>
                      <path d="M32 767.328h960v32H32z" fill="#469FCC"></path>
                      <path d="M32 511.328h960v64H32z" fill="#EDD87E"></path>
                      <path
                        d="M405.024 765.056l-126.4 126.4a31.968 31.968 0 0 1-45.248 0l-126.4-126.4h-24.224l152.896 152.896a31.968 31.968 0 0 0 45.248 0l152.896-152.896h-28.768z"
                        fill=""
                      ></path>
                      <path
                        d="M233.376 891.456a31.968 31.968 0 0 0 45.248 0l126.4-126.4H106.976l126.4 126.4zM570.496 765.056l92.128 92.128a31.968 31.968 0 0 0 45.248 0L800 765.056h-229.504z"
                        fill="#EDD87E"
                      ></path>
                      <path
                        d="M800 765.056l-92.128 92.128a31.968 31.968 0 0 1-45.248 0l-92.128-92.128h-24.224l118.624 118.624a31.968 31.968 0 0 0 45.248 0l118.624-118.624H800zM928 383.328c-57.6 0-96-64-96-64s-64 64-160 64-160-64-160-64-38.4 64-96 64-96-64-96-64-64 64-160 64-160-64-160-64v32s64 64 160 64 160-64 160-64 38.4 64 96 64 96-64 96-64 64 64 160 64 160-64 160-64 38.4 64 96 64 96-64 96-64v-32s-38.4 64-96 64z"
                        fill=""
                      ></path>
                      <path
                        d="M512.128 31.328c-256 0-480 96-480 224h960c0-128-224-224-480-224z"
                        fill="#E29460"
                      ></path>
                      <path
                        d="M720.128 143.328m-16 0a16 16 0 1 0 32 0 16 16 0 1 0-32 0Z"
                        fill=""
                      ></path>
                      <path
                        d="M592.128 111.328m-16 0a16 16 0 1 0 32 0 16 16 0 1 0-32 0Z"
                        fill=""
                      ></path>
                      <path
                        d="M432.128 175.328m-16 0a16 16 0 1 0 32 0 16 16 0 1 0-32 0Z"
                        fill=""
                      ></path>
                      <path
                        d="M464.128 111.328m-16 0a16 16 0 1 0 32 0 16 16 0 1 0-32 0Z"
                        fill=""
                      ></path>
                      <path
                        d="M272.128 111.328m-16 0a16 16 0 1 0 32 0 16 16 0 1 0-32 0Z"
                        fill=""
                      ></path>
                      <path
                        d="M864 223.328c-96 0-160 64-160 64s-38.4-64-96-64-96 64-96 64-64-64-160-64-160 64-160 64-38.4-64-96-64-96 64-96 64v32s64 64 160 64 160-64 160-64 38.4 64 96 64 96-64 96-64 64 64 160 64 160-64 160-64 38.4 64 96 64 96-64 96-64v-32s-64-64-160-64z"
                        fill="#3AAD73"
                      ></path>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Burgers</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    class="w-6 h-6 icon"
                    version="1.1"
                    id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 512 512"
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
                      <polygon
                        style="fill: #e5ffe8"
                        points="231.394,87.077 243.697,46.922 268.303,46.922 280.606,87.077 "
                      ></polygon>
                      <path
                        style="fill: #b3b3b3"
                        d="M43.615,291.161c0-117.296,95.088-212.384,212.385-212.384c117.296,0,212.385,95.088,212.385,212.384 H43.615z"
                      ></path>
                      <path
                        style="opacity: 0.1; enable-background: new"
                        d="M277.808,79.885c-7.17-0.731-14.445-1.108-21.808-1.108 c-117.297,0-212.385,95.088-212.385,212.384H87.23C87.23,181.228,170.756,90.804,277.808,79.885z"
                      ></path>
                      <path
                        style="fill: #ffe7cc"
                        d="M113.056,472.22c-2.976,0-5.811-1.27-7.794-3.489c-1.982-2.22-2.924-5.18-2.589-8.137l3.659-32.273 c0.296-2.606,1.56-5.004,3.542-6.722l79.742-69.068c1.9-1.646,4.328-2.551,6.841-2.551h87.952c13.406,0,24.313,10.907,24.313,24.313 c0,13.406-10.907,24.313-24.313,24.313h-68.886v25.1l142.56-0.113l42.18-42.181c4.592-4.591,10.698-7.12,17.192-7.12 c6.495,0,12.6,2.529,17.193,7.12c9.478,9.479,9.478,24.905-0.001,34.384l-53.361,53.361c-1.959,1.959-4.617,3.061-7.388,3.061 H113.056V472.22z"
                      ></path>
                      <g style="opacity: 0.1">
                        <path
                          d="M117.017,449.817c0.296-2.606,1.56-5.005,3.542-6.722l79.742-69.068c1.9-1.646,4.328-2.551,6.841-2.551h87.952 c5.029,0,9.708,1.535,13.59,4.162c0.024-0.445,0.039-0.893,0.039-1.346c0-13.406-10.907-24.313-24.313-24.313h-87.952 c-2.513,0-4.941,0.906-6.841,2.551l-79.742,69.068c-1.982,1.717-3.246,4.116-3.542,6.722l-3.659,32.273 c-0.335,2.957,0.607,5.917,2.589,8.137s4.818,3.489,7.794,3.489h1.42L117.017,449.817z"
                        ></path>
                      </g>
                      <path
                        style="fill: #ccffe8"
                        d="M132.593,487.077c0,5.967-4.837,10.805-10.806,10.805H75.864c-5.968,0-10.806-4.838-10.806-10.805 v-97.251c0-5.967,4.837-10.805,10.806-10.805h45.923c5.968,0,10.806,4.838,10.806,10.805V487.077z"
                      ></path>
                      <path
                        style="opacity: 0.1; enable-background: new"
                        d="M86.727,487.077v-97.251c0-5.967,4.837-10.805,10.806-10.805H75.864 c-5.968,0-10.806,4.838-10.806,10.805v97.251c0,5.967,4.837,10.805,10.806,10.805h21.669 C91.563,497.882,86.727,493.044,86.727,487.077z"
                      ></path>
                      <path
                        style="fill: #e5ffe8"
                        d="M504.163,300.932c0,5.771-4.678,10.449-10.449,10.449H18.286c-5.771,0-10.449-4.678-10.449-10.449 v-12.016c0-5.77,4.678-10.449,10.449-10.449h475.429c5.771,0,10.449,4.679,10.449,10.449V300.932z"
                      ></path>
                      <path
                        style="fill: #b3b3b3"
                        d="M237.642,56.474c-1.829,0-3.516-0.98-4.422-2.568l-18.358-32.171c-0.899-1.576-0.892-3.51,0.02-5.079 c0.911-1.569,2.588-2.535,4.402-2.535h73.431c1.814,0,3.492,0.965,4.402,2.535c0.911,1.569,0.918,3.505,0.019,5.079l-18.358,32.171 c-0.906,1.588-2.594,2.568-4.422,2.568H237.642z"
                      ></path>
                      <path
                        d="M132.747,245.552c-4.328,0-7.837,3.509-7.837,7.837c0,4.328,3.509,7.837,7.837,7.837h35.438 c4.328,0,7.837-3.509,7.837-7.837c0-4.328-3.509-7.837-7.837-7.837H132.747z"
                      ></path>
                      <path
                        d="M417.456,366.456c-8.586,0-16.659,3.344-22.733,9.416l-39.887,39.888l-131.474,0.105v-9.423h61.049 c17.727,0,32.149-14.422,32.149-32.149c0-17.727-14.423-32.149-32.149-32.149h-87.952c-4.397,0-8.649,1.586-11.971,4.464 l-44.642,38.666c-2.04-8.082-9.351-14.09-18.058-14.09H75.864c-10.28,0-18.643,8.362-18.643,18.642v97.251 c0,10.28,8.363,18.642,18.643,18.642h45.923c10.28,0,18.643-8.362,18.643-18.642v-7.021h38.247c4.328,0,7.837-3.509,7.837-7.837 s-3.509-7.837-7.837-7.837h-38.248V405.5l54.319-47.047c0.474-0.412,1.081-0.637,1.709-0.637h87.952 c9.084,0,16.476,7.391,16.476,16.476c0,9.084-7.392,16.476-16.476,16.476h-5.945v-21.053c0-4.328-3.509-7.837-7.837-7.837 s-7.837,3.509-7.837,7.837v21.053h-47.267c-4.328,0-7.837,3.509-7.837,7.837v25.103c0,2.079,0.827,4.074,2.298,5.543 c1.47,1.469,3.462,2.294,5.539,2.294c0.002,0,0.004,0,0.006,0l142.56-0.113c2.076-0.001,4.068-0.828,5.535-2.296l42.179-42.18 c3.113-3.112,7.251-4.825,11.652-4.825s8.539,1.714,11.651,4.825c6.423,6.424,6.423,16.877,0,23.301l-2.055,2.055l-12.955-12.955 c-3.06-3.06-8.023-3.06-11.082,0c-3.06,3.06-3.06,8.023,0,11.082l12.955,12.955l-40.223,40.223 c-0.494,0.493-1.149,0.765-1.847,0.765H206.889c-4.328,0-7.837,3.509-7.837,7.837c0,4.328,3.509,7.837,7.837,7.837h167.009 c4.884,0,9.476-1.902,12.93-5.356l53.361-53.361c12.534-12.536,12.534-32.932,0-45.467 C434.117,369.8,426.044,366.456,417.456,366.456z M124.757,487.077c0,1.637-1.332,2.969-2.97,2.969h-15.125v-35.864 c0-4.328-3.509-7.837-7.837-7.837s-7.837,3.509-7.837,7.837v35.864H75.864c-1.637,0-2.97-1.331-2.97-2.969v-97.251 c0-1.637,1.332-2.969,2.97-2.969h45.923c1.637,0,2.97,1.331,2.97,2.969V487.077z"
                      ></path>
                      <path
                        d="M493.714,270.63h-18.455c-2.152-23.44-7.991-46.177-17.48-67.817c-11.819-26.953-28.673-50.944-50.097-71.304 c-3.137-2.981-8.098-2.856-11.079,0.282c-2.981,3.137-2.855,8.098,0.282,11.079c19.904,18.917,35.562,41.202,46.54,66.237 c8.614,19.645,13.997,40.264,16.104,61.524h-68.738c-4.328,0-7.837,3.509-7.837,7.837s3.509,7.837,7.837,7.837h102.922 c1.44,0,2.612,1.172,2.612,2.612v12.015c0,1.44-1.172,2.612-2.612,2.612H18.286c-1.44,0-2.612-1.172-2.612-2.612v-12.016 c0-1.44,1.172-2.612,2.612-2.612h334.89c4.328,0,7.837-3.509,7.837-7.837c0-4.328-3.509-7.837-7.837-7.837H52.491 c0.316-3.156,0.706-6.291,1.165-9.404h52.923c4.328,0,7.837-3.509,7.837-7.837c0-4.328-3.509-7.837-7.837-7.837H56.606 C77.387,154.648,158.887,86.615,256,86.615c43.789,0,85.545,13.635,120.754,39.43c3.491,2.557,8.396,1.801,10.954-1.691 c2.558-3.491,1.801-8.395-1.691-10.953c-30.214-22.135-64.903-35.944-101.603-40.645l-3.201-10.443 c1.777-1.114,3.3-2.644,4.373-4.523l18.357-32.17c2.277-3.987,2.258-8.932-0.047-12.898c-2.305-3.972-6.589-6.439-11.18-6.439 h-73.431c-4.592,0-8.876,2.467-11.178,6.434c-2.307,3.97-2.326,8.913-0.05,12.9l18.359,32.171c1.072,1.879,2.594,3.408,4.372,4.523 l-3.208,10.469C126.223,85.903,46.274,168.199,36.757,270.63H18.286C8.203,270.63,0,278.833,0,288.915v12.016 c0,10.082,8.203,18.286,18.286,18.286h475.429c10.082,0,18.286-8.204,18.286-18.286v-12.016 C512,278.833,503.796,270.63,493.714,270.63z M256,70.941c-3.878,0-7.73,0.109-11.561,0.308l2.126-6.939h18.868l2.125,6.937 C263.723,71.05,259.869,70.941,256,70.941z M224.011,21.956h63.976l-15.224,26.68h-33.528L224.011,21.956z"
                      ></path>
                      <circle
                        style="fill: #8ccccc"
                        cx="98.826"
                        cy="412.109"
                        r="10.157"
                      ></circle>
                      <g>
                        <path
                          style="fill: #ffffff"
                          d="M382.485,149.448c-16.435,6.808-21.953,12.327-28.761,28.761 c-6.808-16.435-12.326-21.953-28.761-28.761c16.434-6.808,21.953-12.326,28.761-28.761 C360.532,137.122,366.051,142.64,382.485,149.448z"
                        ></path>
                        <circle
                          style="fill: #ffffff"
                          cx="396.392"
                          cy="179.974"
                          r="12.689"
                        ></circle>
                      </g>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Plats nationaux</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    viewBox="0 0 1024 1024"
                    class="w-6 h-6 icon"
                    version="1.1"
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
                        d="M519.232137 503.49783l267.977124-443.100669s195.514642 98.992076 221.338662 334.724454C594.799146 485.36457 519.232137 503.49783 519.232137 503.49783z"
                        fill="#EBA824"
                      ></path>
                      <path
                        d="M953.372011 405.70523c17.427686-2.398953 36.337077-7.97299 55.175912-10.583615-25.753462-235.66182-221.338662-334.724454-221.338662-334.724454l-30.410253 47.767381c48.825742 37.465996 167.29167 122.911045 196.573003 297.540688z"
                        fill="#6E4921"
                      ></path>
                      <path
                        d="M426.872459 568.340109l209.202784-354.198305c-61.314408-36.26652-132.789086-57.151519-209.202784-57.151519-227.194929 0-411.349824 184.154896-411.349824 411.349824s184.154896 411.349824 411.349824 411.349824 411.349824-184.154896 411.349824-411.349824c0-31.609729-3.668986-62.302212-10.442499-91.865776L426.872459 568.340109z"
                        fill="#EBA824"
                      ></path>
                      <path
                        d="M787.420933 485.717357c6.067939 26.600152 9.384138 54.188107 9.384138 82.622752 0 204.334321-165.598291 369.932612-369.932612 369.932612S56.939847 772.67443 56.939847 568.340109c0-204.334321 165.598291-369.932612 369.932612-369.932612 68.722938 0 133.000758 18.768277 188.106112 51.436367l21.026114-35.631503c-61.314408-36.26652-132.789086-57.151519-209.202783-57.151519-227.194929 0-411.349824 184.154896-411.349825 411.349824s184.154896 411.349824 411.349825 411.349825 411.349824-184.154896 411.349824-411.349825c0-31.609729-3.668986-62.302212-10.4425-91.865775l-40.288293 9.172466z"
                        fill="#6E4921"
                      ></path>
                      <path
                        d="M444.088472 671.283401m-48.825742 0a48.825742 48.825742 0 1 0 97.651485 0 48.825742 48.825742 0 1 0-97.651485 0Z"
                        fill="#4C2510"
                      ></path>
                      <path
                        d="M781.846896 219.574726m-35.913733 0a35.913733 35.913733 0 1 0 71.827465 0 35.913733 35.913733 0 1 0-71.827465 0Z"
                        fill="#4C2510"
                      ></path>
                      <path
                        d="M655.549094 582.87494m-19.826638 0a19.826638 19.826638 0 1 0 39.653276 0 19.826638 19.826638 0 1 0-39.653276 0Z"
                        fill="#4C2510"
                      ></path>
                      <path
                        d="M406.058017 897.278853m-19.050506 0a19.050506 19.050506 0 1 0 38.101012 0 19.050506 19.050506 0 1 0-38.101012 0Z"
                        fill="#4C2510"
                      ></path>
                      <path
                        d="M165.245504 591.624061m-35.913732 0a35.913733 35.913733 0 1 0 71.827465 0 35.913733 35.913733 0 1 0-71.827465 0Z"
                        fill="#623520"
                      ></path>
                      <path
                        d="M358.502308 515.704265m-23.848411 0a23.848412 23.848412 0 1 0 47.696823 0 23.848412 23.848412 0 1 0-47.696823 0Z"
                        fill="#FFFCF4"
                      ></path>
                      <path
                        d="M492.7731 312.781093m-13.758699 0a13.758699 13.758699 0 1 0 27.517398 0 13.758699 13.758699 0 1 0-27.517398 0Z"
                        fill="#FFFCF4"
                      ></path>
                      <path
                        d="M868.914766 373.460484m-13.758699 0a13.758699 13.758699 0 1 0 27.517398 0 13.758699 13.758699 0 1 0-27.517398 0Z"
                        fill="#FFFCF4"
                      ></path>
                      <path
                        d="M284.417005 851.416523m-44.592296 0a44.592297 44.592297 0 1 0 89.184593 0 44.592297 44.592297 0 1 0-89.184593 0Z"
                        fill="#FDFDEC"
                      ></path>
                      <path
                        d="M211.672294 534.543099l53.341418-6.702956s-29.493006-92.641907-22.79005-108.164542c4.162888-3.598429 18.13326-6.209054 16.580996 17.568801-1.058361 7.620203 41.20554 14.464273 27.446841-39.371047-5.715152-17.074898-39.018259-42.122786-85.092262-27.587956-21.237787 8.255219-58.844898 30.551368-40.217736 76.272583 5.362365 8.608007 17.074898 13.617584 20.179425-1.90505 3.104527-18.486047 13.829257-31.256942 17.921588-13.617584S211.672294 534.543099 211.672294 534.543099zM532.779164 775.073382l31.115827 38.242128s57.786536-67.876249 73.097498-70.204644c4.797905 1.481706 13.617584 11.077517-5.644594 21.449459-6.420726 2.892855 8.749121 39.088817 43.886722 2.257838 10.513057-12.700338 13.829257-50.730793-19.756081-79.588782-16.722111-12.488665-52.283057-30.974712-78.81265 5.715151-4.092331 8.325777-2.328395 19.897196 11.289189 14.817061 15.875422-6.561841 30.974712-4.374561 19.332736 7.337973-11.783091 11.712534-74.508647 59.973817-74.508647 59.973816zM643.977675 375.153862L635.722456 403.517949s53.200303 5.362365 59.550472 12.135879c0.917247 2.892855-0.846689 10.513057-12.488666 4.515675-3.598429-2.18728-16.298767 17.639358 13.829257 22.437263 9.87804 0.846689 29.775236-10.4425 32.526976-36.830979 0.493902-12.488665-2.540068-36.337077-29.704679-36.972094-5.50348 0.846689-10.583615 5.644595-3.457314 10.583615 8.608007 5.574037 12.700338 13.758699 2.963412 11.994763s-54.964239-16.228209-54.964239-16.228209z"
                        fill="#E8BC38"
                      ></path>
                      <path
                        d="M327.315924 384.114656s27.940743-105.342245 110.069592-102.096603c-1.552263 35.067043-10.301385 102.096603-110.069592 102.096603zM254.35954 627.537794s61.878867 3.810101 69.287397 49.954661c-19.756081 3.03397-58.139323 5.644595-69.287397-49.954661zM781.846896 295.776752s37.113209 2.257838 41.558327 29.986908c-11.853648 1.763936-34.855371 3.386757-41.558327-29.986908z"
                        fill="#3D7C38"
                      ></path>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Pizzas</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    viewBox="0 0 1024 1024"
                    class="w-6 h-6 icon"
                    version="1.1"
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
                        d="M0 832a128 128 0 0 0 128 128h768a128 128 0 0 0 128-128H0z"
                        fill="#EAEAEA"
                      ></path>
                      <path
                        d="M896 928H128a127.68 127.68 0 0 1-123.456-96H0a128 128 0 0 0 128 128h768a128 128 0 0 0 128-128h-4.544A127.68 127.68 0 0 1 896 928z"
                        fill=""
                      ></path>
                      <path
                        d="M960 800v-288a64 64 0 0 0-64-64H128a64 64 0 0 0-64 64v288h896zM896 448V160a64 64 0 0 0-64-64H192a64 64 0 0 0-64 64v288h768z"
                        fill="#EACA44"
                      ></path>
                      <path d="M64 768h896v32H64z" fill=""></path>
                      <path
                        d="M64 640h896v64H64zM128 288h768v64H128z"
                        fill="#EAEAEA"
                      ></path>
                      <path
                        d="M352 32a64 64 0 0 0-64 64h128a64 64 0 0 0-64-64zM512 32a64 64 0 0 0-64 64h128a64 64 0 0 0-64-64zM672 32a64 64 0 0 0-64 64h128a64 64 0 0 0-64-64z"
                        fill="#EF4D4D"
                      ></path>
                      <path
                        d="M832 96H192a64 64 0 0 0-64 64v68.096l10.048 6.976s10.944 7.712 21.952 7.712 21.952-7.712 21.952-7.712L240 194.784c6.72-3.68 9.76-3.744 16 0l58.048 40.288s10.944 7.712 21.952 7.712 21.952-7.712 21.952-7.712L416 194.784c6.72-3.68 9.76-3.744 16 0l58.048 40.288s10.944 7.712 21.952 7.712 21.952-7.712 21.952-7.712L592 194.784c6.72-3.68 9.76-3.744 16 0l58.048 40.288s10.944 7.712 21.952 7.712 21.952-7.712 21.952-7.712L768 194.784c6.72-3.68 9.76-3.744 16 0l58.048 40.288s10.944 7.712 21.952 7.712 21.952-7.712 21.952-7.712L896 228.096V160a64 64 0 0 0-64-64zM64 512v62.56a30.208 30.208 0 0 0 8.672 1.44c11.008 0 21.952-7.712 21.952-7.712L152.672 528c6.72-3.68 9.76-3.744 16 0l58.048 40.288s10.944 7.712 21.952 7.712 21.952-7.712 21.952-7.712l58.048-40.288c6.72-3.68 9.76-3.744 16 0l58.048 40.288s10.944 7.712 21.952 7.712 21.952-7.712 21.952-7.712l58.048-40.288c6.72-3.68 9.76-3.744 16 0l58.048 40.288s10.944 7.712 21.952 7.712 21.952-7.712 21.952-7.712l58.048-40.288c6.72-3.68 9.76-3.744 16 0l58.048 40.288s10.944 7.712 21.952 7.712 21.952-7.712 21.952-7.712l58.048-40.288a17.6 17.6 0 0 1 7.904-2.688 14.912 14.912 0 0 1 7.584 2.688l58.048 40.288s10.944 7.712 21.952 7.712a30.368 30.368 0 0 0 7.84-1.184V512a64 64 0 0 0-64-64H128a64 64 0 0 0-64 64z"
                        fill="#4F3923"
                      ></path>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Gâteaux</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    class="w-6 h-6 icon"
                    version="1.1"
                    id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 512.002 512.002"
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
                      <circle
                        style="fill: #ffd15d"
                        cx="256.001"
                        cy="256"
                        r="256"
                      ></circle>
                      <path
                        style="fill: #f9b54c"
                        d="M511.887,263.401L404.091,155.605l12.964,77.831l-73.859-73.859L238.188,278.464L123.283,172.063 l-3.843,19.504l-19.504-19.504l-3.949,20.954l-20.954-20.954l-8.083,19.004l2.755,36.216l28.276,28.275v28.312L86.486,386.386 L207.49,507.39c15.71,3.013,31.923,4.611,48.512,4.611C394.91,512,507.969,401.361,511.887,263.401z"
                      ></path>
                      <circle
                        style="fill: #e6f3ff"
                        cx="255.432"
                        cy="256"
                        r="130.379"
                      ></circle>
                      <g>
                        <path
                          style="fill: #cfdbe6"
                          d="M255.432,125.616c72.009,0,130.386,58.375,130.386,130.384s-58.375,130.384-130.386,130.384V125.616 z"
                        ></path>
                        <circle
                          style="fill: #cfdbe6"
                          cx="255.432"
                          cy="256"
                          r="78.231"
                        ></circle>
                      </g>
                      <path
                        style="fill: #b8c9d9"
                        d="M255.432,177.769c43.206,0,78.231,35.025,78.231,78.231c0,43.206-35.025,78.231-78.231,78.231 V177.769z"
                      ></path>
                      <path
                        style="fill: #f1543f"
                        d="M207.23,247.486c0-13.31,10.79-24.102,24.102-24.102c13.31,0,24.102,10.79,24.102,24.102 c0-13.31,10.79-24.102,24.102-24.102c13.31,0,24.102,10.79,24.102,24.102c0,23.047-48.202,50.612-48.202,50.612 S207.23,271.831,207.23,247.486z"
                      ></path>
                      <path
                        style="fill: #c1321f"
                        d="M255.432,247.486c0-13.31,10.79-24.102,24.102-24.102c13.31,0,24.102,10.79,24.102,24.102 c0,23.047-48.202,50.612-48.202,50.612L255.432,247.486z"
                      ></path>
                      <path
                        style="fill: #804000"
                        d="M392.929,151.692v234.693h18.965v-77.178l0,0c10.431,0,18.758-8.716,18.258-19.135 C428.066,246.679,420.251,145.051,392.929,151.692z"
                      ></path>
                      <path
                        style="fill: #935635"
                        d="M119.792,170.546h-3.424c-2.751,0-4.98,2.363-4.98,5.28v32.997c0,2.915-2.229,5.28-4.98,5.28 c-2.751,0-4.98-2.363-4.98-5.28v-32.997c0-2.915-2.231-5.28-4.98-5.28h-4.98c-2.751,0-4.98,2.363-4.98,5.28v32.997 c0,2.915-2.229,5.28-4.98,5.28c-2.751,0-4.98-2.363-4.98-5.28v-32.997c0-2.915-2.231-5.28-4.98-5.28h-3.424 c-2.751,0-4.98,2.363-4.98,5.28v33.602c0,14.034,10.318,25.483,23.347,26.367v150.59h14.943v-150.59 c13.029-0.883,23.347-12.333,23.347-26.367v-33.602C124.774,172.911,122.543,170.546,119.792,170.546z"
                      ></path>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Entrees</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    class="w-6 h-6 icon"
                    version="1.1"
                    id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 512 512"
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
                      <path
                        style="fill: #cf8f3d"
                        d="M512,395.131C512,459.676,397.386,512,256,512S0,459.676,0,395.131s114.616-116.87,256-116.87 S512,330.585,512,395.131z"
                      ></path>
                      <path
                        style="fill: #ffbb5e"
                        d="M512,365.449c0,64.545-114.615,116.87-256,116.87S0,429.995,0,365.449s114.616-116.87,256-116.87 S512,300.904,512,365.449z"
                      ></path>
                      <path
                        style="fill: #cf8f3d"
                        d="M512,335.769c0,64.545-114.615,116.87-256,116.87S0,400.314,0,335.769s114.616-116.87,256-116.87 S512,271.223,512,335.769z"
                      ></path>
                      <path
                        style="fill: #ffbb5e"
                        d="M512,306.087c0,64.545-114.615,116.87-256,116.87S0,370.633,0,306.087s114.616-116.87,256-116.87 S512,241.542,512,306.087z"
                      ></path>
                      <path
                        style="fill: #cf8f3d"
                        d="M512,276.406c0,64.545-114.615,116.87-256,116.87S0,340.951,0,276.406s114.616-116.87,256-116.87 S512,211.86,512,276.406z"
                      ></path>
                      <path
                        style="fill: #ffbb5e"
                        d="M512,246.725c0,64.545-114.615,116.87-256,116.87S0,311.271,0,246.725s114.616-116.87,256-116.87 S512,182.18,512,246.725z"
                      ></path>
                      <path
                        style="fill: #cf8f3d"
                        d="M512,217.044c0,64.545-114.615,116.87-256,116.87S0,281.589,0,217.044s114.616-116.87,256-116.87 S512,152.498,512,217.044z"
                      ></path>
                      <path
                        style="fill: #ffce76"
                        d="M227.165,67.273c17.68,26.602,21.61,73.972-1.017,99.418c-1.76,1.978-4.203,2.987-6.657,2.987 c-2.105,0-4.217-0.741-5.914-2.251c-3.675-3.268-4.005-8.895-0.738-12.571c15.047-16.922,14.802-54.695-0.504-77.725 C199.621,58.017,194.29,30.58,198.753,7.234c0.924-4.829,5.586-7.998,10.418-7.073c4.831,0.924,7.998,5.587,7.075,10.418 C212.667,29.29,217.056,52.074,227.165,67.273z M300.2,67.274c-10.11-15.205-14.495-37.988-10.913-56.693 c0.925-4.829-2.241-9.495-7.071-10.42c-4.833-0.925-9.495,2.241-10.42,7.071c-4.47,23.339,0.858,50.777,13.575,69.901 c15.307,23.027,15.554,60.8,0.506,77.727c-3.268,3.675-2.936,9.304,0.739,12.571c1.696,1.508,3.809,2.249,5.914,2.249 c2.455,0,4.898-1.01,6.658-2.989C321.812,141.241,317.881,93.87,300.2,67.274z M113.543,190.894h-2.441 c-4.917,0-8.904,3.987-8.904,8.904s3.987,8.904,8.904,8.904h2.441c4.917,0,8.904-3.987,8.904-8.904S118.46,190.894,113.543,190.894z M208.54,247.109h-2.441c-4.917,0-8.904,3.987-8.904,8.904s3.987,8.904,8.904,8.904h2.441c4.917,0,8.904-3.987,8.904-8.904 S213.458,247.109,208.54,247.109z M317.305,217.71h-2.442c-4.917,0-8.904,3.987-8.904,8.904s3.987,8.904,8.904,8.904h2.442 c4.917,0,8.904-3.987,8.904-8.904S322.223,217.71,317.305,217.71z M429.986,207.871h-2.438c-4.917,0-8.904,3.987-8.904,8.904 c0,4.917,3.987,8.904,8.904,8.904h2.438c4.917,0,8.904-3.987,8.904-8.904C438.89,211.858,434.904,207.871,429.986,207.871z"
                      ></path>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Desserts</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    class="w-6 h-6 icon"
                    version="1.1"
                    id="Layer_1"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 512 512"
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
                      <path
                        style="fill: #f7ba9c"
                        d="M456.348,267.13L456.348,267.13c0,36.883-29.9,66.783-66.783,66.783h-3.141L331.92,431.26 c-6.134,10.955-16.746,17.585-28.147,17.585H256h-47.773c-11.401,0-22.013-6.63-28.147-17.585l-54.505-97.347h-3.141 c-36.883,0-66.783-29.9-66.783-66.783l0,0c0-36.883,29.9-66.783,66.783-66.783h1.422c-6.305-16.414-9.77-34.236-9.77-52.87l0,0 C114.087,66.028,180.115,0,261.565,0l0,0c0.087,0,0.174,0.003,0.26,0.003c0.931,16.023,4.425,31.358,10.069,45.606 c15.034,30.366,39.492,54.577,70.864,67.824h21.51c30.737,0,55.653,24.917,55.653,55.653l0,0c0,12.79-4.324,24.562-11.579,33.956 C436.082,211.158,456.348,236.77,456.348,267.13z"
                      ></path>
                      <path
                        style="fill: #b74941"
                        d="M456.348,267.13L456.348,267.13c0,36.883-29.9,66.783-66.783,66.783h-3.141L331.92,431.26 c-6.134,10.955-16.746,17.585-28.147,17.585H256h-47.773c-11.401,0-22.013-6.63-28.147-17.585l-54.505-97.347h-3.141 c-36.883,0-66.783-29.9-66.783-66.783l0,0c0-36.883,29.9-66.783,66.783-66.783h0.899c32.131,53.354,90.613,88.586,157.432,89.043 c108.429,0.742,139.455-82.615,128.069-86.193C436.319,211.472,456.348,236.95,456.348,267.13z"
                      ></path>
                      <path
                        style="fill: #f7ba9c"
                        d="M129.804,304.947c-1.819,4.198-5.917,6.708-10.219,6.708c-1.477,0-2.977-0.296-4.42-0.92 c-17.415-7.545-30.793-22.292-36.706-40.46c-1.902-5.846,1.293-12.127,7.139-14.029c5.846-1.903,12.127,1.294,14.029,7.139 c3.939,12.102,12.828,21.916,24.389,26.924C129.656,292.753,132.247,299.306,129.804,304.947z"
                      ></path>
                      <path
                        style="fill: #db6d53"
                        d="M420.291,169.087L420.291,169.087c0,12.79-0.557,59.272-95.468,59.272 c-74.175,0-133.383-48.28-133.383-102.981c0-39.672,31.288-73.77,76.965-89.582c1.06,3.363,2.569,6.559,3.858,9.813 c9.978,20.156,24.11,37.6,41.658,50.925c14.564,11.059,32.429,16.899,50.716,16.899l0,0 C395.374,113.434,420.291,138.35,420.291,169.087z"
                      ></path>
                      <path
                        style="fill: #323030"
                        d="M333.205,500.866c0,6.147-4.983,11.13-11.13,11.13h-66.01c-0.022,0-0.042,0.003-0.065,0.003 c-0.022,0-0.043-0.003-0.065-0.003h-66.01c-6.147,0-11.13-4.983-11.13-11.13s4.983-11.13,11.13-11.13h54.944v-40.89h-36.643 c-11.401,0-22.013-6.63-28.147-17.585l-54.505-97.348h260.848L331.92,431.26c-6.134,10.955-16.746,17.585-28.147,17.585H267.13 v40.89h54.944C328.222,489.736,333.205,494.719,333.205,500.866z"
                      ></path>
                      <path
                        style="fill: #403e3e"
                        d="M256,405.704c-43.216,0-79.202-30.89-87.126-71.791h174.25 C335.202,374.814,299.216,405.704,256,405.704z"
                      ></path>
                      <path
                        style="fill: #612324"
                        d="M297.41,50.511c28.557-14.125,63.155-2.414,77.274,26.138c14.119,28.56,2.414,63.156-26.142,77.276 c-28.56,14.12-63.155,2.414-77.274-26.142C257.145,99.227,268.851,64.63,297.41,50.511L297.41,50.511z"
                      ></path>
                      <path
                        style="fill: #92393c"
                        d="M315.678,58.369c14.785-7.313,32.697-1.25,40.006,13.532c7.309,14.786,1.25,32.697-13.535,40.007 c-14.786,7.31-32.697,1.25-40.006-13.533C294.833,83.591,300.893,65.678,315.678,58.369L315.678,58.369z"
                      ></path>
                      <path
                        style="fill: #5c4d38"
                        d="M389.565,9.863c0,3.268-2.649,5.918-5.918,5.918c-1.38,0-2.711,0.509-3.75,1.431 c-19.782,17.572-34.482,36.328-44.941,65.457c-0.867,2.415-3.143,3.919-5.57,3.919c-0.663,0-1.339-0.112-1.999-0.349 c-3.076-1.104-4.674-4.493-3.57-7.57c11.146-31.043,26.919-55.329,48.22-74.25C375.244,1.569,379.368,0,383.647,0 C386.916,0,389.565,6.595,389.565,9.863z"
                      ></path>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Glaces</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    class="w-6 h-6 icon"
                    viewBox="0 0 512 512"
                    baseProfile="tiny"
                    overflow="visible"
                    version="1.1"
                    xml:space="preserve"
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
                      <g id="Layer_1"></g>
                      <g id="Layer_2"></g>
                      <g id="Layer_3">
                        <g>
                          <path
                            d="M430.493,368.04H37.488c0,0-31.521-76.965,30.85-142.453s142.143-89.793,222.304-59.412 S435.187,263.394,430.493,368.04z"
                            fill="#AF602D"
                          ></path>
                          <path
                            d="M290.642,166.175c-26.505-10.046-52.968-14.107-78.773-12.683c19.399,1.061,39.074,5.217,58.772,12.683 c80.162,30.381,144.545,97.219,139.85,201.865h20.001C435.187,263.394,370.804,196.556,290.642,166.175z"
                            fill="#A05423"
                          ></path>
                          <path
                            d="M285.236,199.767c-28.39,24.259-35.005,63.633-14.774,87.944c20.231,24.31,59.646,24.352,88.036,0.092 c11.657-9.961,19.642-22.47,23.605-35.438c7.499-24.54,21.252-45.07,39.413-60.589l11.493-9.821c2.08-1.777,2.345-4.897,0.595-7 l-25.838-31.048c-1.783-2.142-4.973-2.413-7.092-0.603l-11.394,9.736c-18.162,15.519-40.452,25.789-65.588,29.135 C310.409,183.943,296.893,189.805,285.236,199.767z"
                            fill="#D97C41"
                          ></path>
                          <path
                            d="M433.604,174.954l-25.838-31.048c-1.783-2.142-4.973-2.413-7.092-0.603L392.837,150l20.766,24.954 c1.75,2.103,1.485,5.222-0.595,7l-11.493,9.821c-18.162,15.519-31.915,36.048-39.413,60.589 c-3.962,12.968-11.947,25.477-23.604,35.439c-11.196,9.567-24.106,15.337-36.878,17.348c18.542,3.082,39.722-2.687,56.879-17.348 c11.657-9.961,19.642-22.47,23.604-35.439c7.499-24.54,21.252-45.07,39.413-60.589l11.493-9.821 C435.089,180.177,435.354,177.058,433.604,174.954z"
                            fill="#C76D33"
                          ></path>
                          <path
                            d="M452.709,111.739l-41.91,35.812l19.689,23.659l41.922-35.822c1.505-1.286,3.65-1.611,5.411-0.706 c6.386,3.281,14.351,2.603,20.163-2.363c7.759-6.63,8.738-18.387,2.187-26.259c-2.033-2.443-4.553-4.225-7.293-5.322 c-1.533-0.614-2.658-1.955-2.99-3.572c-0.602-2.932-1.911-5.76-3.951-8.211c-6.551-7.872-18.152-8.88-25.911-2.25 c-5.816,4.97-7.819,12.819-5.698,19.754C454.911,108.368,454.227,110.442,452.709,111.739z"
                            fill="#F2C7AE"
                          ></path>
                          <g>
                            <path
                              d="M500.171,106.059c-2.033-2.443-4.553-4.225-7.293-5.322c-1.533-0.614-2.658-1.955-2.99-3.572 c-0.602-2.932-1.911-5.76-3.951-8.211c-4.803-5.772-12.318-7.837-19.046-5.923c3.413,0.979,6.586,2.967,9.046,5.923 c2.04,2.451,3.349,5.279,3.951,8.211c0.332,1.617,1.457,2.958,2.99,3.572c2.74,1.097,5.26,2.879,7.293,5.322 c6.551,7.872,5.572,19.629-2.187,26.259c-2.06,1.761-4.394,2.971-6.829,3.669c5.668,1.617,11.993,0.464,16.829-3.669 C505.744,125.688,506.722,113.931,500.171,106.059z"
                              fill="#EFB899"
                            ></path>
                            <path
                              d="M467.821,134.681c-1.761-0.904-3.906-0.579-5.411,0.706l-36.078,30.828l4.156,4.994l41.078-35.1 C470.278,135.774,469.021,135.298,467.821,134.681z"
                              fill="#EFB899"
                            ></path>
                          </g>
                          <path
                            d="M391.929,429.678H62.201c-28.856,0-52.249-23.392-52.249-52.249v-8.728h434.225v8.728 C444.178,406.285,420.785,429.678,391.929,429.678z"
                            fill="#FFAAA1"
                          ></path>
                          <path
                            d="M424.177,368.701v8.726c0,28.857-23.393,52.251-52.251,52.251h20.001 c28.857,0,52.251-23.393,52.251-52.251v-8.726H424.177z"
                            fill="#FF938A"
                          ></path>
                          <g>
                            <ellipse
                              cx="29.523"
                              cy="352.933"
                              fill="#F54432"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                            <ellipse
                              cx="73.287"
                              cy="352.933"
                              fill="#59C230"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                            <ellipse
                              cx="117.353"
                              cy="352.933"
                              fill="#F54432"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                            <ellipse
                              cx="161.117"
                              cy="352.933"
                              fill="#59C230"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                            <ellipse
                              cx="205.183"
                              cy="352.933"
                              fill="#F54432"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                            <ellipse
                              cx="248.947"
                              cy="352.933"
                              fill="#59C230"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                            <ellipse
                              cx="293.013"
                              cy="352.933"
                              fill="#F54432"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                            <ellipse
                              cx="336.777"
                              cy="352.933"
                              fill="#59C230"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                            <ellipse
                              cx="380.843"
                              cy="352.933"
                              fill="#F54432"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                            <ellipse
                              cx="424.607"
                              cy="352.933"
                              fill="#59C230"
                              rx="22.033"
                              ry="22.18"
                            ></ellipse>
                          </g>
                          <path
                            d="M29.523,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.033,11.082,17.033,21.599 c0,10.517-7.274,19.318-17.033,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C51.556,340.683,41.691,330.753,29.523,330.753z"
                            fill="#E83826"
                          ></path>
                          <path
                            d="M73.287,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.033,11.082,17.033,21.599 c0,10.517-7.274,19.318-17.033,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C95.32,340.683,85.456,330.753,73.287,330.753z"
                            fill="#4EB229"
                          ></path>
                          <path
                            d="M117.353,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.033,11.082,17.033,21.599 c0,10.517-7.274,19.318-17.033,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C139.386,340.683,129.521,330.753,117.353,330.753z"
                            fill="#E83826"
                          ></path>
                          <path
                            d="M161.117,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.032,11.082,17.032,21.599 c0,10.517-7.274,19.318-17.032,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C183.15,340.683,173.286,330.753,161.117,330.753z"
                            fill="#4EB229"
                          ></path>
                          <path
                            d="M205.183,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.033,11.082,17.033,21.599 c0,10.517-7.274,19.318-17.033,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C227.216,340.683,217.351,330.753,205.183,330.753z"
                            fill="#E83826"
                          ></path>
                          <path
                            d="M248.947,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.033,11.082,17.033,21.599 c0,10.517-7.274,19.318-17.033,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C270.98,340.683,261.115,330.753,248.947,330.753z"
                            fill="#4EB229"
                          ></path>
                          <path
                            d="M293.013,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.033,11.082,17.033,21.599 c0,10.517-7.274,19.318-17.033,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C315.045,340.683,305.181,330.753,293.013,330.753z"
                            fill="#E83826"
                          ></path>
                          <path
                            d="M336.777,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.033,11.082,17.033,21.599 c0,10.517-7.274,19.318-17.033,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C358.81,340.683,348.945,330.753,336.777,330.753z"
                            fill="#4EB229"
                          ></path>
                          <path
                            d="M380.843,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.032,11.082,17.032,21.599 c0,10.517-7.274,19.318-17.032,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C402.875,340.683,393.011,330.753,380.843,330.753z"
                            fill="#E83826"
                          ></path>
                          <path
                            d="M424.607,330.753c-1.721,0-3.393,0.205-5,0.581c9.758,2.281,17.033,11.082,17.033,21.599 c0,10.517-7.274,19.318-17.033,21.599c1.607,0.376,3.279,0.581,5,0.581c12.168,0,22.033-9.93,22.033-22.18 C446.64,340.683,436.775,330.753,424.607,330.753z"
                            fill="#4EB229"
                          ></path>
                        </g>
                      </g>
                      <g id="Layer_4"></g>
                      <g id="Layer_5"></g>
                      <g id="Layer_6"></g>
                      <g id="Layer_7"></g>
                      <g id="Layer_8"></g>
                      <g id="Layer_9"></g>
                      <g id="Layer_10"></g>
                      <g id="Layer_11"></g>
                      <g id="Layer_12"></g>
                      <g id="Layer_13"></g>
                      <g id="Layer_14"></g>
                      <g id="Layer_15"></g>
                      <g id="Layer_16"></g>
                      <g id="Layer_17"></g>
                      <g id="Layer_18"></g>
                      <g id="Layer_19"></g>
                      <g id="Layer_20"></g>
                      <g id="Layer_21"></g>
                      <g id="Layer_22"></g>
                      <g id="Layer_23"></g>
                      <g id="Layer_24"></g>
                      <g id="Layer_25"></g>
                      <g id="Layer_26"></g>
                      <g id="Layer_27"></g>
                      <g id="Layer_28"></g>
                      <g id="Layer_29"></g>
                      <g id="Layer_30"></g>
                      <g id="Layer_31"></g>
                      <g id="Layer_32"></g>
                      <g id="Layer_33"></g>
                      <g id="Layer_34"></g>
                      <g id="Layer_35"></g>
                      <g id="Layer_36"></g>
                      <g id="Layer_37"></g>
                      <g id="Layer_38"></g>
                      <g id="Layer_39"></g>
                      <g id="Layer_40"></g>
                      <g id="Layer_41"></g>
                      <g id="Layer_42"></g>
                      <g id="Layer_43"></g>
                      <g id="Layer_44"></g>
                      <g id="Layer_45"></g>
                      <g id="Layer_46"></g>
                      <g id="Layer_47"></g>
                      <g id="Layer_48"></g>
                      <g id="Layer_49"></g>
                      <g id="Layer_50">
                        <g>
                          <g>
                            <path
                              d="M29.572,338.573c-4.054,0-7.39-3.233-7.493-7.309c-0.697-27.314,5.82-67.589,40.828-104.348 c32.454-34.084,68.759-56.866,107.903-67.714c40.412-11.199,81.623-9.026,122.485,6.461 c12.251,4.643,24.055,10.089,35.083,16.188c2.393,1.253,4.026,3.759,4.026,6.646c0,4.142-3.353,7.5-7.495,7.5 c-1.272,0-2.531-0.323-3.644-0.939c-10.448-5.786-21.646-10.957-33.286-15.368c-75.526-28.624-151.601-8.179-214.209,57.571 c-31.461,33.034-37.32,69.145-36.695,93.62c0.105,4.141-3.166,7.584-7.307,7.689C29.702,338.572,29.636,338.573,29.572,338.573z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M111.189,382.045H79.448c-4.143,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h31.741c4.143,0,7.5,3.358,7.5,7.5 S115.332,382.045,111.189,382.045z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M199.012,382.045h-31.731c-4.143,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h31.731c4.143,0,7.5,3.358,7.5,7.5 S203.155,382.045,199.012,382.045z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M286.836,382.045h-31.721c-4.143,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h31.721c4.143,0,7.5,3.358,7.5,7.5 S290.978,382.045,286.836,382.045z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M374.679,382.045h-31.741c-4.143,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h31.741c4.143,0,7.5,3.358,7.5,7.5 S378.822,382.045,374.679,382.045z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M418.441,382.045h-31.432c-4.143,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h31.432c4.143,0,7.5,3.358,7.5,7.5 S422.584,382.045,418.441,382.045z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M330.608,382.045h-31.432c-4.143,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h31.432c4.143,0,7.5,3.358,7.5,7.5 S334.751,382.045,330.608,382.045z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M242.774,382.045h-31.432c-4.143,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h31.432c4.143,0,7.5,3.358,7.5,7.5 S246.917,382.045,242.774,382.045z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M154.951,382.045H123.52c-4.143,0-7.5-3.358-7.5-7.5s3.358-7.5,7.5-7.5h31.431c4.143,0,7.5,3.358,7.5,7.5 S159.093,382.045,154.951,382.045z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M67.117,382.045H37.486c-3.089,0-5.863-1.895-6.987-4.773l-0.189-0.479c-1.535-3.848,0.34-8.211,4.188-9.746 c1.854-0.74,3.828-0.688,5.549-0.003h27.07c4.143,0,7.5,3.358,7.5,7.5S71.26,382.045,67.117,382.045z"
                            ></path>
                          </g>
                          <g>
                            <path
                              d="M428.322,338.904c-3.646,0-6.843-2.663-7.406-6.378c-4.908-32.404-17.659-61.524-37.899-86.55 c-2.605-3.221-2.105-7.944,1.116-10.548c3.22-2.605,7.944-2.105,10.548,1.115c21.936,27.126,35.753,58.663,41.065,93.737 c0.621,4.095-2.196,7.918-6.292,8.539C429.075,338.876,428.696,338.904,428.322,338.904z"
                            ></path>
                          </g>
                          <g>
                            <g>
                              <path
                                d="M311.477,319.97c-1.952,0-3.899-0.082-5.835-0.246c-16.455-1.399-30.998-8.757-40.951-20.717 c-22.809-27.409-15.781-71.57,15.667-98.443l0,0c12.414-10.608,27.055-17.29,42.34-19.325 c22.966-3.057,44.303-12.533,61.706-27.402l11.394-9.736c2.562-2.189,5.816-3.238,9.18-2.952 c3.358,0.285,6.394,1.869,8.549,4.459l25.838,31.049c4.352,5.23,3.685,13.08-1.488,17.5l-11.494,9.821 c-17.417,14.883-30.25,34.62-37.112,57.077c-4.549,14.886-13.507,28.355-25.905,38.949 C348.318,312.862,329.697,319.97,311.477,319.97z M290.102,211.969L290.102,211.969c-25.241,21.569-31.468,56.31-13.881,77.444 c7.366,8.852,18.266,14.309,30.692,15.365c16.058,1.369,33.079-4.531,46.708-16.177c10.224-8.737,17.591-19.777,21.304-31.928 c7.698-25.192,22.122-47.357,41.714-64.098l9.618-8.219l-22.639-27.204l-9.469,8.091c-19.606,16.754-43.63,27.428-69.471,30.868 C312.267,197.761,300.311,203.246,290.102,211.969z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M431.109,183.119c-0.359,0-0.72-0.016-1.083-0.046c-3.358-0.286-6.394-1.87-8.549-4.461l-13.291-15.97 c-4.352-5.229-3.685-13.078,1.486-17.498l37.03-31.642c-2.262-9.549,0.953-19.597,8.445-26 c5.28-4.511,11.989-6.676,18.884-6.088c6.922,0.588,13.196,3.87,17.665,9.242c2.462,2.957,4.251,6.446,5.222,10.161 c3.457,1.607,6.553,3.987,9.013,6.944c9.153,10.998,7.771,27.488-3.079,36.759c-7.5,6.411-17.837,7.949-26.798,4.115 l-36.847,31.486C436.922,182.074,434.08,183.119,431.109,183.119z M421.294,154.944l10.093,12.127l36.145-30.885 c3.869-3.308,9.25-3.966,13.711-1.676c3.882,1.994,8.539,1.448,11.864-1.393c4.643-3.968,5.224-11.038,1.294-15.759 c-1.184-1.421-2.636-2.484-4.318-3.158c-3.882-1.554-6.704-4.928-7.547-9.023c-0.376-1.831-1.173-3.486-2.37-4.924 c-1.883-2.264-4.513-3.645-7.406-3.891c-2.86-0.242-5.662,0.66-7.868,2.545c-3.383,2.891-4.716,7.546-3.398,11.859 c1.448,4.734-0.09,9.906-3.918,13.176L421.294,154.944z"
                              ></path>
                            </g>
                          </g>
                          <g>
                            <path
                              d="M391.922,443.678H62.198c-32.947,0-59.751-26.804-59.751-59.751v-8.726c0-4.142,3.358-7.5,7.5-7.5h434.225 c4.143,0,7.5,3.358,7.5,7.5v8.726C451.672,416.874,424.868,443.678,391.922,443.678z M17.447,382.701v1.226 c0,24.675,20.075,44.75,44.751,44.75h329.724c24.675,0,44.75-20.075,44.75-44.75v-1.226H17.447z"
                            ></path>
                          </g>
                          <g>
                            <g>
                              <path
                                d="M29.518,382.934c-16.285,0-29.533-13.314-29.533-29.68s13.249-29.68,29.533-29.68c16.284,0,29.532,13.314,29.532,29.68 S45.802,382.934,29.518,382.934z M29.518,338.574c-8.013,0-14.533,6.585-14.533,14.68s6.52,14.68,14.533,14.68 s14.532-6.585,14.532-14.68S37.531,338.574,29.518,338.574z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M73.282,382.934c-16.285,0-29.533-13.314-29.533-29.68s13.249-29.68,29.533-29.68c16.284,0,29.532,13.314,29.532,29.68 S89.566,382.934,73.282,382.934z M73.282,338.574c-8.013,0-14.533,6.585-14.533,14.68s6.52,14.68,14.533,14.68 s14.532-6.585,14.532-14.68S81.295,338.574,73.282,338.574z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M117.348,382.934c-16.285,0-29.533-13.314-29.533-29.68s13.249-29.68,29.533-29.68s29.533,13.314,29.533,29.68 S133.632,382.934,117.348,382.934z M117.348,338.574c-8.013,0-14.533,6.585-14.533,14.68s6.52,14.68,14.533,14.68 s14.533-6.585,14.533-14.68S125.361,338.574,117.348,338.574z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M161.112,382.934c-16.285,0-29.533-13.314-29.533-29.68s13.249-29.68,29.533-29.68s29.533,13.314,29.533,29.68 S177.397,382.934,161.112,382.934z M161.112,338.574c-8.013,0-14.533,6.585-14.533,14.68s6.52,14.68,14.533,14.68 c8.013,0,14.533-6.585,14.533-14.68S169.125,338.574,161.112,338.574z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M205.177,382.934c-16.284,0-29.532-13.314-29.532-29.68s13.249-29.68,29.532-29.68c16.285,0,29.533,13.314,29.533,29.68 S221.462,382.934,205.177,382.934z M205.177,338.574c-8.013,0-14.532,6.585-14.532,14.68s6.519,14.68,14.532,14.68 c8.013,0,14.533-6.585,14.533-14.68S213.19,338.574,205.177,338.574z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M248.942,382.934c-16.285,0-29.533-13.314-29.533-29.68s13.249-29.68,29.533-29.68s29.533,13.314,29.533,29.68 S265.226,382.934,248.942,382.934z M248.942,338.574c-8.013,0-14.533,6.585-14.533,14.68s6.52,14.68,14.533,14.68 s14.533-6.585,14.533-14.68S256.955,338.574,248.942,338.574z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M293.008,382.934c-16.285,0-29.533-13.314-29.533-29.68s13.249-29.68,29.533-29.68c16.284,0,29.532,13.314,29.532,29.68 S309.292,382.934,293.008,382.934z M293.008,338.574c-8.013,0-14.533,6.585-14.533,14.68s6.52,14.68,14.533,14.68 c8.013,0,14.532-6.585,14.532-14.68S301.021,338.574,293.008,338.574z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M336.771,382.934c-16.284,0-29.532-13.314-29.532-29.68s13.249-29.68,29.532-29.68c16.285,0,29.533,13.314,29.533,29.68 S353.056,382.934,336.771,382.934z M336.771,338.574c-8.013,0-14.532,6.585-14.532,14.68s6.519,14.68,14.532,14.68 s14.533-6.585,14.533-14.68S344.784,338.574,336.771,338.574z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M380.837,382.934c-16.285,0-29.533-13.314-29.533-29.68s13.249-29.68,29.533-29.68c16.285,0,29.533,13.314,29.533,29.68 S397.122,382.934,380.837,382.934z M380.837,338.574c-8.013,0-14.533,6.585-14.533,14.68s6.52,14.68,14.533,14.68 c8.013,0,14.533-6.585,14.533-14.68S388.85,338.574,380.837,338.574z"
                              ></path>
                            </g>
                            <g>
                              <path
                                d="M427.722,382.706c-1.102,0-2.162-0.243-3.121-0.685c-1.248,0.575-2.667,0.814-4.132,0.616 c-1.419-0.191-2.822-0.496-4.172-0.906c-11.409-3.342-19.66-13.162-21.028-25.03c-0.131-1.12-0.198-2.285-0.198-3.448 c0-1.164,0.067-2.329,0.2-3.464c1.721-14.94,14.331-26.218,29.33-26.218c1.718,0,3.424,0.152,5.071,0.451 c14.139,2.406,24.461,14.705,24.461,29.231c0,14.679-10.893,27.308-25.338,29.376 C428.434,382.681,428.077,382.706,427.722,382.706z M424.601,338.573c-7.376,0-13.58,5.567-14.429,12.949 c-0.068,0.58-0.101,1.141-0.101,1.732s0.032,1.152,0.099,1.716c0.678,5.886,4.747,10.737,10.369,12.373 c0.032,0.01,0.065,0.02,0.099,0.03c0.587,0.18,1.204,0.313,1.836,0.399c0.755,0.102,1.47,0.313,2.129,0.615 c0.641-0.293,1.334-0.501,2.067-0.606c7.105-1.017,12.462-7.262,12.462-14.526c0-7.188-5.072-13.268-12.059-14.457 C426.226,338.643,425.422,338.573,424.601,338.573z"
                              ></path>
                            </g>
                          </g>
                        </g>
                      </g>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Poulet</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    viewBox="0 0 1024 1024"
                    class="w-6 h-6 icon"
                    version="1.1"
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
                        d="M205.9 244.7c-35.2 0-63.9-28.7-63.9-63.9s28.6-63.9 63.9-63.9h103.3c6.1 0 11 4.9 11 11s-4.9 11-11 11H205.9c-23.1 0-41.9 18.8-41.9 41.9s18.8 41.9 41.9 41.9c6.1 0 11 4.9 11 11s-4.9 11-11 11z"
                        fill="#86878E"
                      ></path>
                      <path
                        d="M250 331.4h-93.2c-6.1 0-11-4.9-11-11s4.9-11 11-11H250c17.8 0 32.3-14.5 32.3-32.3 0-17.8-14.5-32.3-32.3-32.3h-45.3c-6.1 0-11-4.9-11-11s4.9-11 11-11H250c30 0 54.3 24.4 54.3 54.3S280 331.4 250 331.4z"
                        fill="#86878E"
                      ></path>
                      <path
                        d="M135.2 356.6c-6.1 0-11-4.9-11-11 0-19.9 16.2-36.1 36.1-36.1h31c6.1 0 11 4.9 11 11s-4.9 11-11 11h-31c-7.8 0-14.1 6.3-14.1 14.1 0 6-4.9 11-11 11z"
                        fill="#86878E"
                      ></path>
                      <path
                        d="M508.9 248.2v194.7h-109c-4.1 0-7.5-3.3-7.5-7.5v-70.9c0.1-64.2 52.2-116.3 116.5-116.3z"
                        fill="#FFD400"
                      ></path>
                      <path
                        d="M508.9 453.9h-109c-10.2 0-18.5-8.3-18.5-18.5v-70.9c0-70.3 57.2-127.4 127.4-127.4 6.1 0 11 4.9 11 11v194.7c0.1 6.2-4.8 11.1-10.9 11.1z m-105.4-22h94.4V259.8c-53 5.5-94.4 50.4-94.4 104.8v67.3z"
                        fill="#C13105"
                      ></path>
                      <path
                        d="M770.2 497.3c6.4 6.3 6.4 16.7 0 23C732.5 557.5 603.7 672 450.7 672S168.9 557.4 131.2 520.2c-6.4-6.3-6.4-16.7 0-23 37.7-37.2 166.5-151.7 319.5-151.7s281.7 114.6 319.5 151.8z"
                        fill="#FFD400"
                      ></path>
                      <path
                        d="M450.7 682.9c-67.5 0-137.7-21.3-208.6-63.5-56.6-33.6-98.6-71.7-118.6-91.4-5.2-5.1-8.1-12-8.1-19.3 0-7.3 2.9-14.2 8.1-19.3 20-19.7 62.1-57.8 118.6-91.4 70.9-42.1 141.1-63.5 208.6-63.5s137.7 21.3 208.6 63.5c56.6 33.6 98.6 71.7 118.6 91.4 5.2 5.1 8.1 12 8.1 19.3s-2.9 14.2-8.1 19.3c-20 19.7-62.1 57.8-118.6 91.4-70.9 42.2-141.1 63.5-208.6 63.5z m0-326.3c-37.8 0-171.8 10.7-311.8 148.5-1.3 1.3-1.5 2.9-1.5 3.7 0 0.8 0.2 2.3 1.5 3.7C278.9 650.3 413 661 450.7 661c37.8 0 171.8-10.7 311.8-148.5 1.3-1.3 1.5-2.9 1.5-3.7 0-0.8-0.2-2.3-1.5-3.7-140-137.8-274.1-148.5-311.8-148.5z"
                        fill="#C13105"
                      ></path>
                      <path d="M775 508.7l153.1 88.4V420.4z" fill="#FFD400"></path>
                      <path
                        d="M928.1 608.1c-1.9 0-3.8-0.5-5.5-1.5l-153.1-88.4c-3.4-2-5.5-5.6-5.5-9.5 0-3.9 2.1-7.6 5.5-9.5l153.1-88.4c3.4-2 7.6-2 11 0 3.4 2 5.5 5.6 5.5 9.5v176.8c0 3.9-2.1 7.6-5.5 9.5-1.7 1-3.6 1.5-5.5 1.5zM797 508.8l120.1 69.3V439.4L797 508.8zM339.9 555.8c-0.9 0-1.9-0.1-2.9-0.4-5.9-1.6-9.3-7.6-7.8-13.5 13.9-51.7-4.5-106.4-46.7-139.3-4.8-3.7-5.6-10.6-1.9-15.4s10.6-5.6 15.4-1.9c49.2 38.4 70.6 102.1 54.4 162.4-1.2 4.9-5.6 8.1-10.5 8.1zM246 538.1c-19.2 0-34.8-15.6-34.8-34.8s15.6-34.8 34.8-34.8 34.8 15.6 34.8 34.8-15.5 34.8-34.8 34.8z m0-47.7c-7.1 0-12.8 5.8-12.8 12.8 0 7.1 5.8 12.8 12.8 12.8s12.8-5.8 12.8-12.8c0.1-7.1-5.7-12.8-12.8-12.8z"
                        fill="#C13105"
                      ></path>
                      <path
                        d="M607.8 480.4c-3.6 0-7.2-1.8-9.3-5C575 439 529 416.3 478.2 416.3c-6.1 0-11-4.9-11-11s4.9-11 11-11c58.1 0 111.3 26.5 138.8 69.2 3.3 5.1 1.8 11.9-3.3 15.2-1.8 1.1-3.8 1.7-5.9 1.7z"
                        fill="#FFFFFF"
                      ></path>
                      <path
                        d="M751.2 873.4H271.5c-68.1 0-123.3-55.2-123.3-123.3 0-58.2 47.2-105.4 105.4-105.4h515.6c58.2 0 105.4 47.2 105.4 105.4-0.1 68.1-55.3 123.3-123.4 123.3z"
                        fill="#26AEEA"
                      ></path>
                      <path
                        d="M751.2 884.4H271.5c-74.1 0-134.3-60.3-134.3-134.3 0-64.2 52.2-116.4 116.4-116.4h515.6c64.2 0 116.4 52.2 116.4 116.4-0.1 74-60.3 134.3-134.4 134.3zM253.5 655.7c-52.1 0-94.4 42.3-94.4 94.4 0 61.9 50.4 112.3 112.3 112.3h479.7c61.9 0 112.3-50.4 112.3-112.3 0-52.1-42.3-94.4-94.4-94.4H253.5z"
                        fill="#17217F"
                      ></path>
                      <path
                        d="M779.5 821.9H243.1c-126.3 0-228.7-102.4-228.7-228.7h993.9c0 126.3-102.4 228.7-228.8 228.7z"
                        fill="#26AEEA"
                      ></path>
                      <path
                        d="M779.5 832.9H243.1c-64 0-124.2-24.9-169.5-70.2S3.4 657.2 3.4 593.2c0-6.1 4.9-11 11-11h993.9c6.1 0 11 4.9 11 11 0 64-24.9 124.2-70.2 169.5s-105.5 70.2-169.6 70.2zM25.7 604.2c2.7 54 25 104.4 63.5 143 41.1 41.1 95.8 63.8 154 63.8h536.4c58.2 0 112.8-22.6 154-63.8 38.5-38.5 60.8-88.9 63.5-143H25.7z"
                        fill="#17217F"
                      ></path>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Poissons</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    class="w-6 h-6 icon"
                    xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink"
                    version="1.1"
                    id="Capa_1"
                    viewBox="0 0 470 470"
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
                        <path
                          style="fill: #ffffff"
                          d="M147.368,309.008l-50,0.094l-17.19-17.094c-9.763-9.764-25.592-9.763-35.355,0 c-9.763,9.763-9.763,25.592,0,35.355l11.643,11.636l90.902,20.009V309.008z"
                        ></path>
                        <path
                          style="fill: #fd7555"
                          d="M245.37,191.01c-64.9,0-118,53.1-118,118v30l187.13,20V191L245.37,191.01z"
                        ></path>
                        <path
                          style="fill: #fdfa7b"
                          d="M314.5,191l-30,168.01L428.61,339c2.54-9.59,3.89-19.64,3.89-30C432.5,244.1,379.4,191,314.5,191z"
                        ></path>
                        <path
                          style="fill: #fefdca"
                          d="M196.5,309c0,10.36,1.35,20.41,3.89,30c0,0.01,114.11,20.01,114.11,20.01V191 C249.6,191,196.5,244.1,196.5,309z"
                        ></path>
                        <path
                          style="fill: #fe9f88"
                          d="M314.5,221v138.01L397.23,339c3.41-9.37,5.27-19.47,5.27-30C402.5,260.48,363.02,221,314.5,221z"
                        ></path>
                        <path
                          style="fill: #fec8bb"
                          d="M372.5,309c0,10.53-1.23,20.63-3.47,30l-54.53,20.004l-82.73-19.994 c-3.41-9.38-5.27-19.48-5.27-30.01c0-48.52,39.48-88,88-88C346.48,221,372.5,260.48,372.5,309z"
                        ></path>
                        <path
                          style="fill: #ffffff"
                          d="M314.5,279c-16.542,0-30,13.458-30,30c0,16.542,13.458,30,30,30c16.542,0,30-13.458,30-30 C344.5,292.457,331.042,279,314.5,279z"
                        ></path>
                        <path
                          style="fill: #fdce6e"
                          d="M407.5,354l-51.667,65h30c16.5,0,34.269-12.807,39.487-28.46L437.5,354H407.5z"
                        ></path>
                        <path
                          style="fill: #fdfa7b"
                          d="M32.5,354l12.18,36.54C49.898,406.193,67.667,419,84.167,419h271.667 c16.5,0,34.269-12.807,39.487-28.46L407.5,354H32.5z"
                        ></path>
                        <path
                          style="fill: #fefdca"
                          d="M447.5,339h-425c-8.284,0-15,6.716-15,15s6.716,15,15,15h425c8.284,0,15-6.716,15-15 S455.784,339,447.5,339z"
                        ></path>
                        <path
                          d="M447.5,331.5h-9.551c1.353-7.403,2.051-14.935,2.051-22.5c0-69.199-56.299-125.497-125.5-125.497h-69.133 c-66.69,0-121.389,52.292-125.271,118.028l-19.644,0.061l-14.971-14.887c-6.139-6.139-14.3-9.52-22.981-9.52 c-8.682,0-16.843,3.381-22.981,9.52C33.381,292.843,30,301.004,30,309.685c0,8.142,2.973,15.826,8.408,21.814H22.5 C10.094,331.5,0,341.593,0,354s10.094,22.5,22.5,22.5h9.594l5.47,16.411c6.278,18.835,26.749,33.589,46.603,33.589h301.666 c19.854,0,40.324-14.754,46.603-33.589l5.47-16.411h9.594c12.406,0,22.5-10.093,22.5-22.5S459.906,331.5,447.5,331.5z M425,309 c0,7.581-0.792,15.124-2.333,22.5H407.3c1.78-7.334,2.7-14.863,2.7-22.5c0-52.659-42.841-95.5-95.5-95.5 c-19.818,0-38.842,6.044-55.015,17.478c-3.382,2.391-4.186,7.072-1.794,10.454c2.391,3.382,7.069,4.187,10.454,1.794 c13.626-9.634,29.655-14.726,46.354-14.726c44.388,0,80.5,36.112,80.5,80.5c0,7.675-1.093,15.218-3.218,22.5H237.218 C235.093,324.218,234,316.675,234,309c0-16.7,5.092-32.729,14.726-46.355c2.392-3.382,1.588-8.062-1.794-10.454 c-3.385-2.392-8.062-1.588-10.454,1.794C225.044,270.157,219,289.181,219,309c0,7.637,0.92,15.166,2.7,22.5h-15.367 C204.792,324.124,204,316.581,204,309c0-60.928,49.57-110.497,110.5-110.497S425,248.072,425,309z M245.367,198.503h9.681 C215.756,219.727,189,261.296,189,309c0,7.565,0.699,15.097,2.051,22.5h-56.184v-22.492 C134.867,248.075,184.438,198.503,245.367,198.503z M50.125,322.06C46.82,318.755,45,314.36,45,309.685 c0-4.674,1.82-9.069,5.126-12.374c3.305-3.305,7.699-5.126,12.374-5.126s9.069,1.82,12.39,5.141l17.189,17.094 c1.41,1.404,3.32,2.217,5.312,2.182l22.477-0.07V331.5H59.571L50.125,322.06z M447.5,361.5h-14.844c-0.024,0-335.156,0-335.156,0 c-4.143,0-7.5,3.358-7.5,7.5s3.357,7.5,7.5,7.5h324.594l-3.889,11.668c-4.216,12.647-19.04,23.332-32.372,23.332H84.167 c-13.332,0-28.156-10.685-32.372-23.332L47.906,376.5H67.5c4.143,0,7.5-3.358,7.5-7.5s-3.357-7.5-7.5-7.5H37.37 c-0.027,0-14.87,0-14.87,0c-4.136,0-7.5-3.364-7.5-7.5s3.364-7.5,7.5-7.5h425c4.136,0,7.5,3.364,7.5,7.5S451.636,361.5,447.5,361.5 z"
                        ></path>
                        <path
                          d="M284.5,316.5c4.143,0,7.5-3.358,7.5-7.5c0-12.407,10.094-22.5,22.5-22.5S337,296.593,337,309c0,4.142,3.357,7.5,7.5,7.5 s7.5-3.358,7.5-7.5c0-20.678-16.822-37.5-37.5-37.5S277,288.322,277,309C277,313.142,280.357,316.5,284.5,316.5z"
                        ></path>
                        <path
                          style="fill: #fec8bb"
                          d="M210.001,133.501c0-11.837,3.051-17.432,6.584-23.909c3.944-7.232,8.416-15.429,8.416-31.091 c0-15.631-4.454-23.825-8.394-31.046c-1.265-2.354-3.75-3.955-6.609-3.955c-4.142,0-7.5,3.358-7.5,7.5 c0,1.307,0.336,2.535,0.924,3.605c3.531,6.473,6.579,12.066,6.579,23.896c0,11.837-3.051,17.432-6.584,23.909 c-3.944,7.232-8.416,15.429-8.416,31.091c0,15.662,4.471,23.858,8.415,31.09c1.361,2.496,3.935,3.91,6.591,3.91 c1.213,0,2.444-0.295,3.584-0.917c3.637-1.983,4.977-6.539,2.993-10.175C213.052,150.931,210.001,145.338,210.001,133.501z"
                        ></path>
                        <path
                          style="fill: #fec8bb"
                          d="M260.001,133.501c0-11.837,3.051-17.432,6.584-23.909c3.944-7.232,8.416-15.429,8.416-31.091 c0-15.631-4.454-23.825-8.394-31.046c-1.265-2.354-3.75-3.955-6.609-3.955c-4.142,0-7.5,3.358-7.5,7.5 c0,1.307,0.336,2.535,0.924,3.605c3.531,6.473,6.579,12.066,6.579,23.896c0,11.837-3.051,17.432-6.584,23.909 c-3.944,7.232-8.416,15.429-8.416,31.091c0,15.662,4.471,23.858,8.415,31.09c1.361,2.496,3.935,3.91,6.591,3.91 c1.213,0,2.444-0.295,3.584-0.917c3.637-1.983,4.977-6.539,2.993-10.175C263.052,150.931,260.001,145.338,260.001,133.501z"
                        ></path>
                      </g>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Viandes</a>
                </li>
                <li class="my-2 py-2 flex">
                  <svg
                    viewBox="0 0 1024 1024"
                    class="w-6 h-6 icon"
                    version="1.1"
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
                        d="M710.3 1002.7H360.2L266 241.2h538.4z"
                        fill="#FFFFFF"
                      ></path>
                      <path
                        d="M710.3 1013.7H360.2c-5.6 0-10.2-4.1-10.9-9.7l-94.1-761.5c-0.4-3.1 0.6-6.3 2.7-8.6 2.1-2.4 5.1-3.7 8.2-3.7h538.4c3.2 0 6.2 1.4 8.2 3.7 2.1 2.4 3.1 5.5 2.7 8.6L721.3 1004c-0.8 5.6-5.5 9.7-11 9.7z m-340.4-22h330.6L792 252.2H278.5l91.4 739.5z"
                        fill="#E01042"
                      ></path>
                      <path
                        d="M296.6 488.5l63.6 514.2h350.1l63.5-514.2z"
                        fill="#F27596"
                      ></path>
                      <path
                        d="M710.3 1013.7H360.2c-5.6 0-10.2-4.1-10.9-9.7l-63.6-514.2c-0.4-3.1 0.6-6.3 2.7-8.6 2.1-2.4 5.1-3.7 8.2-3.7h477.2c3.2 0 6.2 1.4 8.2 3.7 2.1 2.4 3.1 5.5 2.7 8.6L721.1 1004c-0.6 5.6-5.3 9.7-10.8 9.7z m-340.4-22h330.6l60.8-492.2H309.1l60.8 492.2z"
                        fill="#E01042"
                      ></path>
                      <path
                        d="M422.6 816m-28.8 0a28.8 28.8 0 1 0 57.6 0 28.8 28.8 0 1 0-57.6 0Z"
                        fill="#E01042"
                      ></path>
                      <path
                        d="M622 870.8m-28.8 0a28.8 28.8 0 1 0 57.6 0 28.8 28.8 0 1 0-57.6 0Z"
                        fill="#E01042"
                      ></path>
                      <path
                        d="M468.4 640.3m-28.8 0a28.8 28.8 0 1 0 57.6 0 28.8 28.8 0 1 0-57.6 0Z"
                        fill="#E01042"
                      ></path>
                      <path
                        d="M439.6 1013.7c-1 0-2-0.1-3-0.4-5.9-1.6-9.3-7.7-7.6-13.5L682 91.4c0.9-3.3 3.4-6.1 6.6-7.3L871 13.4c5.7-2.2 12 0.6 14.2 6.3 2.2 5.7-0.6 12-6.3 14.2l-177.2 68.6-251.5 903.1c-1.3 5-5.8 8.1-10.6 8.1z"
                        fill="#17217F"
                      ></path>
                      <path
                        d="M266 241.2h154.6c2-10.4 3.1-21.2 3.1-32.2 0-95.9-77.7-173.6-173.6-173.6-95.9 0-173.6 77.7-173.6 173.6 0 95.9 77.7 173.6 173.6 173.6 11.3 0 22.3-1.2 32.9-3.2l-17-138.2z"
                        fill="#FFD400"
                      ></path>
                      <path
                        d="M250.2 393.6c-101.8 0-184.6-82.8-184.6-184.6S148.4 24.5 250.2 24.5 434.8 107.3 434.8 209c0 11.1-1.1 22.6-3.3 34.2-1 5.2-5.5 9-10.8 9H278.5L294 378c0.7 5.7-3.2 11.1-8.8 12.2-11.8 2.3-23.6 3.4-35 3.4z m0-347.1c-89.6 0-162.6 72.9-162.6 162.6s72.9 162.6 162.6 162.6c6.8 0 13.7-0.5 20.7-1.4l-15.8-127.7c-0.4-3.1 0.6-6.3 2.7-8.6 2.1-2.4 5.1-3.7 8.2-3.7h145.2c1-7.2 1.5-14.3 1.5-21.2 0.1-89.7-72.9-162.6-162.5-162.6z"
                        fill="#C13105"
                      ></path>
                      <path
                        d="M321.9 378.9c-4.2 0-8.1-2.4-10-6.4-2.6-5.5-0.2-12.1 5.4-14.6 38-17.6 67.5-48.8 82.9-87.7 2.2-5.6 8.6-8.4 14.3-6.2 5.6 2.2 8.4 8.6 6.2 14.3-17.5 44.2-50.9 79.5-94.1 99.5-1.6 0.7-3.1 1.1-4.7 1.1z"
                        fill="#C13105"
                      ></path>
                    </g>
                  </svg>
                  <a href="#" class="block ml-6 hover:text-gray-900">Boissons</a>
                </li>
              </ul>
            </div>
          </aside>
        </div>
      </div>
    </div>

    <div class="flex border-t border-solid border-border-200 border-opacity-100">
      <aside
        ref="aside"
        :class="{ 'lg:sticky lg:top-16 relative': isAsideSticky }"
        class="bg-white lg:w-[22rem] h-[39.2rem] border-r border-gray-100 lg:block hidden p-3 px-8"
      >
        <div class="max-h-full flex flex-col overflow-hidden overflow-y-auto">
          <button
            class="text-lg flex items-center justify-center space-x-3 bg-gray-200 rounded-full py-2 font-semibold"
          >
            <svg
              class="w-8 h-8 icon"
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
                  d="M9.90693 3.9999C9.93791 3.99996 9.96894 4.00001 10 4.00001C10.0311 4.00001 10.0621 3.99996 10.0931 3.9999C10.4618 3.99929 10.8242 3.99869 11.147 4.08519C12.0098 4.31636 12.6836 4.99023 12.9148 5.85296C13.0013 6.1758 13.0007 6.53821 13.0001 6.90693C13.0001 6.93792 13 6.96895 13 7.00001H21C21.5523 7.00001 22 7.44772 22 8.00001C22 8.55229 21.5523 9.00001 21 9.00001H13C13 9.03107 13.0001 9.0621 13.0001 9.09309C13.0007 9.46181 13.0013 9.82422 12.9148 10.1471C12.6836 11.0098 12.0098 11.6837 11.147 11.9148C10.8242 12.0013 10.4618 12.0007 10.0931 12.0001C10.0621 12.0001 10.0311 12 10 12C9.96894 12 9.93791 12.0001 9.90692 12.0001C9.5382 12.0007 9.17579 12.0013 8.85295 11.9148C7.99022 11.6837 7.31635 11.0098 7.08519 10.1471C6.99868 9.82421 6.99928 9.46181 6.9999 9.09308C6.99995 9.0621 7 9.03106 7 9.00001H5C4.44772 9.00001 4 8.55229 4 8.00001C4 7.44772 4.44772 7.00001 5 7.00001H7C7 6.96895 6.99995 6.93792 6.9999 6.90693C6.99928 6.53821 6.99868 6.1758 7.08519 5.85296C7.31635 4.99023 7.99022 4.31636 8.85295 4.08519C9.17579 3.99869 9.5382 3.99929 9.90693 3.9999ZM9.49861 6.00536C9.39195 6.01022 9.36685 6.01805 9.37059 6.01704C9.19804 6.06328 9.06327 6.19805 9.01704 6.3706C9.0162 6.37411 9.00963 6.40483 9.00535 6.49861C9.00024 6.61064 9 6.75845 9 7.00001V9.00001C9 9.24156 9.00024 9.38937 9.00535 9.5014C9.01021 9.60806 9.01804 9.63315 9.01704 9.62942C9.06327 9.80196 9.19804 9.93674 9.37059 9.98297C9.36685 9.98197 9.39195 9.98979 9.49861 9.99466C9.61063 9.99977 9.75844 10 10 10C10.2416 10 10.3894 9.99977 10.5014 9.99466C10.608 9.98979 10.6331 9.98197 10.6294 9.98297C10.802 9.93674 10.9367 9.80196 10.983 9.62942C10.982 9.63315 10.9898 9.60806 10.9946 9.5014C10.9998 9.38937 11 9.24156 11 9.00001V7.00001C11 6.75845 10.9998 6.61064 10.9946 6.49861C10.9898 6.39196 10.982 6.36686 10.983 6.3706M9.49861 6.00536C9.61063 6.00025 9.75844 6.00001 10 6.00001L9.49861 6.00536ZM10 6.00001C10.2416 6.00001 10.3894 6.00025 10.5014 6.00536L10 6.00001ZM10.5014 6.00536C10.5952 6.00963 10.6259 6.0162 10.6294 6.01704L10.5014 6.00536ZM10.6298 6.01713C10.6298 6.01713 10.6296 6.0171 10.6294 6.01704L10.6298 6.01713ZM15.9069 11.9999C15.9379 12 15.9689 12 16 12C16.0311 12 16.0621 12 16.0931 11.9999C16.4618 11.9993 16.8242 11.9987 17.147 12.0852C18.0098 12.3164 18.6836 12.9902 18.9148 13.853C19.0013 14.1758 19.0007 14.5382 19.0001 14.9069C19.0001 14.9379 19 14.9689 19 15H21C21.5523 15 22 15.4477 22 16C22 16.5523 21.5523 17 21 17H19C19 17.0311 19.0001 17.0621 19.0001 17.0931C19.0007 17.4618 19.0013 17.8242 18.9148 18.1471C18.6836 19.0098 18.0098 19.6837 17.147 19.9148C16.8242 20.0013 16.4618 20.0007 16.0931 20.0001C16.0621 20.0001 16.0311 20 16 20C15.9689 20 15.9379 20.0001 15.9069 20.0001C15.5382 20.0007 15.1758 20.0013 14.853 19.9148C13.9902 19.6837 13.3164 19.0098 13.0852 18.1471C12.9987 17.8242 12.9993 17.4618 12.9999 17.0931C12.9999 17.0621 13 17.0311 13 17H5C4.44772 17 4 16.5523 4 16C4 15.4477 4.44772 15 5 15H13C13 14.969 12.9999 14.9379 12.9999 14.9069C12.9993 14.5382 12.9987 14.1758 13.0852 13.853C13.3164 12.9902 13.9902 12.3164 14.853 12.0852C15.1758 11.9987 15.5382 11.9993 15.9069 11.9999ZM15.4986 14.0054C15.392 14.0102 15.3669 14.018 15.3706 14.017C15.198 14.0633 15.0633 14.1981 15.017 14.3706C15.018 14.3669 15.0102 14.392 15.0054 14.4986C15.0002 14.6106 15 14.7585 15 15V17C15 17.2416 15.0002 17.3894 15.0054 17.5014C15.0102 17.6081 15.018 17.6332 15.017 17.6294C15.0633 17.802 15.198 17.9367 15.3706 17.983C15.3669 17.982 15.392 17.9898 15.4986 17.9947C15.6106 17.9998 15.7584 18 16 18C16.2416 18 16.3894 17.9998 16.5014 17.9947C16.608 17.9898 16.6331 17.982 16.6294 17.983C16.802 17.9367 16.9367 17.802 16.983 17.6294C16.982 17.6332 16.9898 17.6081 16.9946 17.5014C16.9998 17.3894 17 17.2416 17 17V15C17 14.7585 16.9998 14.6106 16.9946 14.4986C16.9898 14.392 16.982 14.3669 16.983 14.3706C16.9367 14.1981 16.802 14.0633 16.6294 14.017C16.6331 14.018 16.608 14.0102 16.5014 14.0054C16.3894 14.0002 16.2416 14 16 14C15.7584 14 15.6106 14.0002 15.4986 14.0054Z"
                  fill="#0F1729"
                ></path>
              </g>
            </svg>
            <span>Trier</span>
          </button>
          <div class="flex mt-2 px-6 flex-col items-start justify-center space-y-4">
            <button
              @click="(defaut = true), (latitude = 0), (longitude = 0), scrollBack()"
              class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
            >
              Restos par defaut
            </button>
            <button
              @click="scrollToPosition()"
              class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
            >
              Proche de ma position
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
          <span
            class="text-sm flex mt-6 items-center justify-center space-x-3 bg-gray-200 rounded-full py-2 font-semibold"
          >
            <span>Quelques articles</span>
          </span>
          <div class="flex mt-2 mb-6 px-6 flex-col items-start justify-center space-y-4">
            <button
              @click="scrollArticle()"
              class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
            >
              Nos articles
            </button>
            <button
              @click="getPosition()"
              class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
            >
              Pizza
            </button>
            <button
              class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
            >
              Burger
            </button>
            <button
              class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
            >
              Boissons
            </button>
            <button
              class="text-sm font-bold text-gray-500 hover:text-black hover:duration-200"
            >
              Plat nationaux
            </button>
          </div>
        </div>
      </aside>
      <div class="w-full h-fit px-4 pb-8 mb-12 lg:p-8" id="default">
        <span class="font-bold text-3xl">Les restaurants disponibles</span>
        <div
          id="results"
          class="mt-5 mb-10 grid lg:grid-cols-[repeat(auto-fill,minmax(270px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3"
        >
          <article
            v-for="user in recherche"
            :key="user.id"
            :class="{ 'animate-pulse': recherche.length == 0 }"
            class="product-card hover:scale-105 rounded-md mb-5 shadow-xl duration-100 p-3 cart-type-neon overflow-hidden bg-white"
          >
            <span
              class="block overflow-hidden w-auto lg:h-56 bg-transparent opacity-100 lg:m-0 lg:p-0 lg:inset-0 m-0 p-0 inset-0"
            >
              <a :href="route('restaurant.details', user.id)" class="rounded-md">
                <img
                  :src="'/storage/'+user.profile_photo_path"
                  alt="Product image"
                  class="w-[32rem] h-40 mb-6 product-image"
                />
              </a>
              <header
                class="md:p-6 lg:mt-[-3rem] mt-[-1.5rem] lg:ml-[-1.4rem] lg:mr-[-1.4rem]"
              >
                <div class="flex">
                  <span
                    class="text-lg lg:text-xl font-semibold text-heading md:text-base"
                  >
                    {{ user.name }}</span
                  >

                  <div class="flex space-x-1 bg-gray-200 rounded-full px-2 ml-auto mt-2">
                    <svg
                      class="w-8 h-8 icon"
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
                      class="h-6 w-6 icon"
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
                </div>
              </header>
            </span>
          </article>
        </div>
        <div class="h-[30rem]" v-if="resto.length">
          <span class="font-bold text-3xl">Les restaurants proche de ma position</span>
          <div
            id="results"
            class="mt-5 grid lg:grid-cols-[repeat(auto-fill,minmax(270px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3"
          >
            <article
              v-for="user in resto"
              :key="user.id"
              :class="{ 'animate-pulse': recherche.length == 0 }"
              class="product-card hover:scale-105 rounded-md shadow-xl duration-100 p-3 cart-type-neon overflow-hidden bg-white"
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
                    <span
                      class="text-lg lg:text-xl font-semibold text-heading md:text-base"
                    >
                      {{ user.name }}</span
                    >

                    <div
                      class="flex space-x-1 bg-gray-200 rounded-full px-2 ml-auto mt-2"
                    >
                      <svg
                        class="w-8 h-8 icon"
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
                        class="h-6 w-6 icon"
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
                  </div>
                </header>
              </span>
            </article>
          </div>
        </div>
        <div id="position" v-else>
          <span class="font-bold text-3xl">Les restaurants proche de ma position</span>
          <div
            class="mt-5 p-4 flex shadow-xl flex-col h-[30rem] bg-grocery space-y-3 items-center justify-center"
          >
            <span class="flex justify-center items-center"
              >Voir les restaurants proches de ma position</span
            >
            <button @click="getPosition()" class="bg- font-bold bg-black text-white p-3">
              {{ click }}
            </button>
          </div>
        </div>
        <div class="mt-20" id="article">
          <span class="font-bold text-3xl">Nos article</span>
          <div
            id="results"
            class="mt-5 grid lg:grid-cols-[repeat(auto-fill,minmax(150px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(200px,1fr))] grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-3"
          >
            <article
              v-for="article in Articles"
              :key="article.id"
              class="product-card  w-fit cart-type-neon overflow-hidden bg-white duration-100 hover:-translate-y-0.5 hover:-translate-x-0.1 hover:shadow"
            >
              <span
                @mouseover="add = article.id"
                @mouseleave="add = ''"
                class="box-border block overflow-hidden w-auto lg:h-56 bg-transparent opacity-100 border-0 m-0 p-0 inset-0"
              >
                <button @click="showModals(article)" class="rounded-md w-full">
                  <img
                    :src="article.photo"
                    alt="Product image"
                    class="lg:w-[12rem] lg:h-36 mb-6 object-cover object-center"
                  />
                </button>
                <header
                  class="md:p-6 lg:mt-[-4rem] md:mt-[-4rem] md:ml-[-1.4rem] md:mr-[-1.4rem] mt-[-1.5rem] lg:ml-[-1.4rem] lg:mr-[-1.4rem]"
                >
                  <div class="py-2 flex flex-col">
                    <div class="flex">
                      <div class="flex flex-col">
                        <h3
                          class="lg:text-xl md:text-2xl text-black font-semibold md:text-sm"
                        >
                          {{ article.nom }}
                        </h3>
                        <span class="lg:text-sm font-medium text-heading md:text-base">
                          {{ article.prix }} FCFA</span
                        >
                      </div>
                      <button @click="addItemToCart(article)" class="ml-auto">
                        <svg
                          class="w-12 h-12 icon text-haver"
                          viewBox="0 0 24 24"
                          fill="currentColor"
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
                    <div class="text-xs text-white bg-red-200 p-1">
                       Restaurant  {{article.nomResto}}
                    </div>
                  </div>
                </header>
              </span>
            </article>
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="false"
      class="flex h-[40rem] border-t border-solid border-border-200 border-opacity-100"
    >
      <div class="w-full h-fit px-4 pb-8 lg:p-8">
        <div class="w-full py-5 border mb-10 bg-white shadow-2xl border-gray-200">
          <div id="resultss" class="text-2xl flex space-x-3 text-black px-5 font-bold">
            <svg
              class="w-6 h-6 icon"
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
            <span> Les restaurants les plus proche de votre positon</span>
          </div>
        </div>
        <div
          class="grid lg:grid-cols-[repeat(auto-fill,minmax(270px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(250px,1fr))] grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3"
        >
          <article
            v-for="user in resto"
            :key="user.id"
            :class="{ 'animate-pulse': users.length == 0 }"
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
                  <span
                    class="text-lg lg:text-xl font-semibold text-heading md:text-base"
                  >
                    {{ user.name }}</span
                  >

                  <div class="flex space-x-1 bg-gray-200 rounded-full px-2 ml-auto mt-2">
                    <svg
                      class="w-4 h-4 icon"
                      viewBox="0 0 24 24"
                      fill="#a9d8d1"
                      stroke="#a9d8d1"
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
                      class="w-6 h-6 icon"
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
                </div>
              </header>
            </span>
          </article>
        </div>
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
        <span class="font-bold ml-2 text-sm text-white">{{ count }} items</span>
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
    class="border-l-2 border-gray-100 z-50 transform-gpu duration-400 ease-in-out fixed right-0 top-[4rem] lg:h-[35rem] lg:w-[27rem] md:w-[24rem] w-[21rem] h-[29rem] bg-white text-white p-3"
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
  <transition name="pan">
    <div
      v-if="alert"
      class="bg-white font-bold z-[52] flex h-14 text-white p-4 fixed top-10 left-[30rem]"
    >
      <div class="flex mb-3">
        <span class="text-lg text-black font-bold">Voici les restos proches de vous</span>
        <svg
          class="w-6 h-6 ml-3 icon"
          viewBox="0 0 512 512"
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
              d="M256 17.108c-75.73 0-137.122 61.392-137.122 137.122.055 23.25 6.022 46.107 11.58 56.262L256 494.892l119.982-274.244h-.063c11.27-20.324 17.188-43.18 17.202-66.418C393.122 78.5 331.73 17.108 256 17.108zm0 68.56a68.56 68.56 0 0 1 68.56 68.562A68.56 68.56 0 0 1 256 222.79a68.56 68.56 0 0 1-68.56-68.56A68.56 68.56 0 0 1 256 85.67z"
            ></path>
          </g>
        </svg>
      </div>
    </div>
  </transition>
  <transition name="pan">
    <div
      v-if="search"
      class="bg-white rounded-md h-96 font-bold z-[52] left-1/3 text-white p-4 fixed top-10"
    >
      <div class="pt-2 relative md:hidden lg:block sm:block mx-auto text-gray-600">
        <input
          @input="onInput()"
          v-model="restosearch"
          class="border border-black bg-white focus:ring-0 focus:border-black lg:w-96 h-[3rem] px-5 rounded-full text-sm focus:outline-none"
          type="search"
          autocomplete="off"
          name="search"
          placeholder="Search"
        />

        <div v-if="drop" class="overflow-y-scroll h-full">
          <p
            v-for="user in recherche"
            @click="
              Chercher(user.name), (drop = false), scrollToResults(), (search = false)
            "
            :key="user.id"
            class="cursor-pointor mx-3 mt-2 text-sm hover:bg-gray-100 text-start font-medium text-gray-600 py-2 border-b border-gray-100"
          >
            {{ user.name }}
          </p>
        </div>
      </div>
    </div>
  </transition>
  <div
    v-if="alert"
    class="z-50 transform-gpu fixed top-0 left-0 w-full h-full bg-opacity-30 bg-black flex justify-center"
  ></div>
  <div
    @click.self="search = false"
    v-if="search"
    class="z-50 transform-gpu fixed top-0 left-0 w-full h-full bg-opacity-50 bg-black flex justify-center"
  ></div>
  <transition name="panier">
    <div
      v-if="panier"
      class="bg-vert font-bold flex h-14 z-[55] text-white rounded-md p-4 fixed top-[35rem] right-4"
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
  <DetailsArticle
    @close="selectedArticle = null"
    :addItemToCart="addItemToCart"
    v-if="selectedArticle"
    :article="selectedArticle"
  />
</template>

<script>
import { ref } from "vue";
import DetailsArticle from "./DetailsArticle.vue";
import Restaurant from "./Restaurant.vue";

export default {
  data() {
    return {
      open: false,
      showSearchBar: false,
      texte: true,
      color: false,
      scrollY: 0,
      fixed: false,
      showComponent: false,
      showModal: false,
      showModal1: false,
      isAsideSticky: false,
      navbarHeight: 0,
      showTitre: false,
      resto: "",
      show: false,
      selectedArticle: null,
      index1: 0,
      index2: 1,
      index3: 2,
      current: 0,
    };
  },
  components: { DetailsArticle, Restaurant },

  mounted() {
    window.addEventListener("scroll", this.handleScroll);
    const navbar = document.querySelector("#navbar");
    const navbarStyle = getComputedStyle(navbar);
    this.navbarHeight = parseInt(navbarStyle.height, 10);
    window.addEventListener("scroll", this.hondleScroll);
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll);
    window.removeEventListener("scroll", this.hondleScroll);
  },

  created() {
    setInterval(() => {
      this.current = (this.current + 1) % 3;
      this.shak = true;
    }, 5000);
  },
  methods: {
    toggleMenu() {
      this.open = !this.open;
    },
    toggleCart() {
      this.showComponent = !this.showComponent;
    },
    handleScroll() {
      this.scrollY = window.scrollY;

      if (this.scrollY > 0) {
        this.color = true;
        this.showSearchBar = true;
        this.texte = false;
      } else {
        this.color = false;
        this.showSearchBar = false;
        this.texte = true;
      }
    },
    hondleScroll() {
      const pageYOffset = window.scrollY;
      if (pageYOffset >= this.navbarHeight) {
        this.isAsideSticky = true;
        console.log("coco");
      } else {
        this.isAsideSticky = false;
      }
    },
    showModals(article) {
      console.log("details");
      this.selectedArticle = article;
      this.show = !this.show;
    },
  },
};
</script>
<style scoped>
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
.bg-grocery {
  background-image: url(../../../../storage/app/public/geo.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.bg-resto {
  background-image: url(../../../../storage/app/public/vbe.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-color: rgba(255, 255, 255, 0.5);
}

.btn-clicked svg path {
  stroke: #fff;
}

.fixedd {
  position: fixed;
  width: 100%;
  /* Largeur de l'élément fixé */
  z-index: 0;
  /* Z-index de l'élément fixé */
}

.top-0 {
  top: 0;
  /* Fixer l'élément en haut de la page */
}
.animate-slide-left {
  animation: slide-left 0.5s;
}

.slide-left-active {
  animation-fill-mode: forwards;
}

@keyframes slide-left {
  from {
    transform: translateX(100%);
  }
  to {
    transform: translateX(0);
  }
}
@keyframes slide-right {
  from {
    transform: translateX(-100%);
  }
  to {
    transform: translateX(0);
  }
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

.pan-enter-active,
.pan-leave-active {
  transition: transform 0.2s ease, opacity 0.5s ease;
  transform: translateY(-30%);
  opacity: 0;
}

.pan-enter,
.pan-leave-to {
  opacity: 0;
  transform: translateY(-30%);
}

.pan-leave,
.pan-enter-to {
  opacity: 1;
  transform: translateY(0);
}
</style>
