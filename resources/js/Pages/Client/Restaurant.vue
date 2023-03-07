<template>
  <div class="flex border-t border-solid border-border-200 border-opacity-100">
    <aside
      :class="{ 'lg:sticky lg:top-16 relative': isAsideSticky }"
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
            class="block overflow-hidden w-auto h-56 bg-transparent opacity-100 lg:m-0 lg:p-0 lg:inset-0 m-0 p-0 inset-0"
          >
            <a :href="route('restaurant.details',user.id)" class="rounded-md">
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
                <div
                  class="inline-flex ml-auto shrink-0 items-center rounded-full border border-accent bg-vert px-3 py-1 text-sm text-white"
                >
                  3.3<svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 25.056 24"
                    class="h-2.5 w-2.5 ltr:ml-1 rtl:mr-1"
                  >
                    <g data-name="Group 36413" fill="currentColor">
                      <path
                        id="Path_22667"
                        data-name="Path 22667"
                        d="M19.474,34.679l-6.946-4.346L5.583,34.679a.734.734,0,0,1-1.1-.8L6.469,25.93.263,20.668a.735.735,0,0,1,.421-1.3l8.1-.566,3.064-7.6a.765.765,0,0,1,1.362,0l3.064,7.6,8.1.566a.735.735,0,0,1,.421,1.3L18.588,25.93l1.987,7.949a.734.734,0,0,1-1.1.8Z"
                        transform="translate(0 -10.792)"
                      ></path>
                    </g>
                  </svg>
                </div>
              </div>
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
    };
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
<style>
svg {
  height: 1.5rem;
  width: 1.5rem;
}
</style>
