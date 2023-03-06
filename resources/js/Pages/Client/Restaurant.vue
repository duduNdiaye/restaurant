<template>
  <div class="w-full px-4 pb-8 lg:p-8">
    <div  class="grid lg:grid-cols-[repeat(auto-fill,minmax(370px,1fr))] md:grid-cols-[repeat(auto-fill,minmax(370px,1fr))] grid-cols-[repeat(auto-fill,minmax(250px,1fr))] gap-3">
      <article v-for="user in users" :key="user.id"
        class="product-card cart-type-neon h-full transform md:w-[25rem] lg:w-[25rem] overflow-hidden rounded border border-border-200 bg-white shadow-sm transition-all duration-200 hov r:-translate-y-0.5 hover:shadow"
      >
        <div
          class="relative flex h-48 w-auto cursor-pointer items-center justify-center sm:h-64"
        >
          <span class="sr-only">Product Image</span
          ><span
            style="
              box-sizing: border-box;
              display: block;
              overflow: hidden;
              width: initial;
              height: initial;
              background: none;
              opacity: 1;
              border: 0px;
              margin: 0px;
              padding: 0px;
              position: absolute;
              inset: 0px;
            "
            ><img
              alt="Apples"
              src="../../../../storage/app/public/resto2.jpg"
              data-nimg="fill"
              class="product-image"
          /></span>
          <div
            class="absolute top-3 rounded bg-accent px-1.5 text-xs font-semibold leading-6 text-light ltr:right-3 rtl:left-3 sm:px-2 md:top-4 md:px-2.5 ltr:md:right-4 rtl:md:left-4"
          >
            20%
          </div>
        </div>
        <header class="p-3 md:p-6">
          <div class="mb-2 flex items-center">
            <span class="text-sm font-semibold text-heading md:text-base">$1.60</span
            ><del class="text-xs text-muted ltr:ml-2 rtl:mr-2 md:text-sm">$2.00</del>
          </div>
          <h3 class="mb-4 cursor-pointer truncate text-xs text-body md:text-sm">
            Apples
          </h3>
          <button
            class="group flex h-7 w-full items-center justify-between rounded bg-gray-100 text-xs text-body-dark transition-colors hover:border-accent hover:bg-accent hover:text-light focus:border-accent focus:bg-accent focus:text-light focus:outline-none md:h-9 md:text-sm"
          >
            <span class="flex-1">Add</span
            ><span
              class="grid h-7 w-7 place-items-center bg-gray-200 transition-colors duration-200 group-hover:bg-accent-600 group-focus:bg-accent-600 ltr:rounded-tr ltr:rounded-br rtl:rounded-tl rtl:rounded-bl md:h-9 md:w-9"
              ><svg
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                class="h-4 w-4 stroke-2"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                ></path></svg
            ></span>
          </button>
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
import 'v-calendar/dist/style.css';
export default {

  props: {
    users: Object
  },

 mounted() {
    console.log(this.users)
  },
}
</script>
