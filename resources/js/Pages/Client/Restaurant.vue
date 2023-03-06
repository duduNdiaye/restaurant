<template>
  <div class="w-full px-4 pb-8 lg:p-8">
    <div
      class="grid grid-cols-1 mx-3 gap-6 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-6"
    >
      <article
        v-for="user in users"
        :key="user.id"
        class="product-card cart-type-neon my-3 relative h-full transform w-full overflow-hidden rounded-lg border border-border-200 bg-white shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow"
      >
        <div
          class="relative flex m-3 h-48 w-auto cursor-pointer items-center justify-center sm:h-64"
        >
          <span class="sr-only">Product Image</span
          ><span  @mouseover="visit = user.id,hov = true"  @mouseleave="visit = '',hov= false"
            ><button  v-if="visit == user.id" @mousemove="hov = true"  class="z-[5] absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white text-black font-bold px-4 py-2 rounded-md">Visiter</button>
            <img
              alt="Apples"
              src="../../../../storage/app/public/resto2.jpg"
              data-nimg="fill"
              :class="hov ? 'product-image rounded-md relative  duration-500 hover:opacity-40 origin-top':''"

          />
          </span>
        </div>
        <header class="p-3 mt-[-2rem] md:p-6">
          <div class="mb-2 flex flex-col space-y-4">
            <span
              class="text-sm bg-haver px-2 w-fit text-white font-black font-serif lg:text-2xl md:text-base"
              >{{ user.name }}</span
            >

            <div class="space-y-1 flex">
              <!-- <div class="flex items-center ">
                <button
                  v-for="(star, index) in stars"
                  :key="index"
                  @click="setRating(index + 1)"
                  class="focus:outline-none text-vert"
                >
                  <svg
                    :class="[index &lt; rating ? 'text-yellow-500' : 'text-gray-300']"
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
                      <rect
                        width="24"
                        height="24"
                        transform="matrix(4.37114e-08 -1 -1 -4.37114e-08 24 24)"
                        fill="white"
                      ></rect>
                      <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M11.0137 2.76683C11.379 1.89022 12.6208 1.89022 12.9861 2.76683L14.9102 7.38462C15.0654 7.75726 15.4295 8 15.8332 8H20.893C21.8234 8 22.2893 9.12483 21.6314 9.78268L17.5391 13.875C17.2823 14.1318 17.185 14.5076 17.2847 14.8568L18.9076 20.5369C19.1816 21.496 18.1122 22.2767 17.2822 21.7234L12.5546 18.5716C12.2187 18.3477 11.7811 18.3477 11.4452 18.5717L6.72544 21.7182C5.89284 22.2732 4.81988 21.49 5.09479 20.5279L6.71509 14.8568C6.81486 14.5076 6.71747 14.1318 6.46068 13.875L2.38859 9.8029C1.72328 9.13758 2.19448 8 3.13538 8H8.16658C8.57028 8 8.93438 7.75726 9.08965 7.38462L11.0137 2.76683Z"
                        fill="#323232"
                      ></path>
                    </g>
                  </svg>
                </button>
              </div> -->
              <div class="space-x-2 flex">
                <svg
                  width="79px"
                  height="79px"
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
                    <circle
                      cx="12"
                      cy="10"
                      r="3"
                      stroke="#000000"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    ></circle>
                    <path
                      d="M19 9.75C19 15.375 12 21 12 21C12 21 5 15.375 5 9.75C5 6.02208 8.13401 3 12 3C15.866 3 19 6.02208 19 9.75Z"
                      stroke="#000000"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    ></path>
                  </g>
                </svg>
                <span
                  class="text-sm text-gray-500 font-black font-serif lg:text-md md:text-base"
                  >{{ user.adresse }}</span
                >
              </div>
            </div>
          </div>
        </header>
      </article>
    </div>
    <div class="mt-8 flex justify-center lg:mt-12">
      <button
        data-variant="normal"
        class="inline-flex items-center justify-center shrink-0 font-semibold leading-none rounded outline-none transition duration-300 ease-in-out focus:outline-none focus:shadow focus:ring-1 focus:ring-accent-700 bg-accent text-light border border-transparent hover:bg-accent-hover px-5 py-0 h-12 h-11 text-sm font-semibold md:text-base"
      >
        Load More
      </button>
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
      visit:'',
      hov :false
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
    console.log(this.users);
  },
};
</script>
<style>
svg {
  height: 1.5rem;
  width: 1.5rem;
}
</style>
