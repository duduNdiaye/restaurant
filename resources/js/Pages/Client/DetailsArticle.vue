<template>
  <div class="fixed inset-0 z-50 overflow-y-auto">
    <div class="min-h-full text-center md:p-5">
      <div
        @click.self="closeModal"
        class="fixed inset-0 h-full w-full bg-gray-900 bg-opacity-50 opacity-100 p-5"
      >
        <div
          class="min-w-content relative h-[38rem] inline-block max-w-full align-middle transition-all ltr:text-left rtl:text-right opacity-100 scale-100 overflow-y-scroll"
        >
          <button
            aria-label="Close panel"
            class="absolute top-4 z-[60] inline-block outline-none focus:outline-none right-4 ltr:right-4 rtl:left-4 lg:hidden"
          >
            <span class="sr-only">close</span
            ><svg
              class="h-4 w-4"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20"
              fill="currentColor"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          <article
            class="bg-white w-full max-w-6xl xl:min-w-[1152px] relative z-[51] md:rounded-xl"
          >
            <article class="rounded-lg z-[52] bg-white">
              <div
                class="flex flex-col border-b border-border-200 border-opacity-70 md:flex-row"
              >
                <div class="p-6 pt-10 md:w-1/2 lg:p-14 xl:p-16">
                  <div class="mb-8 flex items-center justify-between lg:mb-10"></div>
                  <div class="product-gallery h-full">
                    <div>
                      <div class="relative">
                        <div
                          class="swiper swiper-initialized swiper-horizontal swiper-pointer-events swiper-backface-hidden"
                          id="productGallery"
                        >
                          <div
                            class="swiper-wrapper"
                            style="transform: translate3d(0px, 0px, 0px)"
                          >
                            <div class="flex flex-col items-center justify-center">
                              <span
                                ><span
                                  ><img
                                    alt=""
                                    class="w-[60rem] h-full mb-6 product-image"
                                    aria-hidden="true"
                                    :src="article.photo"
                                  /> </span
                              ></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col items-start p-5 pt-10 md:w-1/2 lg:p-14 xl:p-16">
                  <div class="w-full">
                    <div
                      class="flex w-full items-start justify-between space-x-8 rtl:space-x-reverse"
                    >
                      <h1
                        class="text-lg font-semibold tracking-tight text-heading md:text-xl xl:text-2xl cursor-pointer transition-colors hover:text-accent"
                      >
                        {{ article.nom }}
                      </h1>
                      <span
                        ><button
                          type="button"
                          class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-gray-300 transition-colors mr-1"
                        >
                          <svg
                            viewBox="0 -28 512.001 512"
                            xmlns="http://www.w3.org/2000/svg"
                            width="21"
                            height="21"
                            fill="currentColor"
                            class="h-5 w-5 text-accent"
                          >
                            <path
                              d="M256 455.516c-7.29 0-14.316-2.641-19.793-7.438-20.684-18.086-40.625-35.082-58.219-50.074l-.09-.078c-51.582-43.957-96.125-81.918-127.117-119.313C16.137 236.81 0 197.172 0 153.871c0-42.07 14.426-80.883 40.617-109.293C67.121 15.832 103.488 0 143.031 0c29.555 0 56.621 9.344 80.446 27.77C235.5 37.07 246.398 48.453 256 61.73c9.605-13.277 20.5-24.66 32.527-33.96C312.352 9.344 339.418 0 368.973 0c39.539 0 75.91 15.832 102.414 44.578C497.578 72.988 512 111.801 512 153.871c0 43.3-16.133 82.938-50.777 124.738-30.993 37.399-75.532 75.356-127.106 119.309-17.625 15.016-37.597 32.039-58.328 50.168a30.046 30.046 0 0 1-19.789 7.43zM143.031 29.992c-31.066 0-59.605 12.399-80.367 34.914-21.07 22.856-32.676 54.45-32.676 88.965 0 36.418 13.535 68.988 43.883 105.606 29.332 35.394 72.961 72.574 123.477 115.625l.093.078c17.66 15.05 37.68 32.113 58.516 50.332 20.961-18.254 41.012-35.344 58.707-50.418 50.512-43.051 94.137-80.223 123.469-115.617 30.344-36.618 43.879-69.188 43.879-105.606 0-34.516-11.606-66.11-32.676-88.965-20.758-22.515-49.3-34.914-80.363-34.914-22.758 0-43.653 7.235-62.102 21.5-16.441 12.719-27.894 28.797-34.61 40.047-3.452 5.785-9.53 9.238-16.261 9.238s-12.809-3.453-16.262-9.238c-6.71-11.25-18.164-27.328-34.61-40.047-18.448-14.265-39.343-21.5-62.097-21.5zm0 0"
                            ></path>
                          </svg></button
                      ></span>
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                      <span class="block text-sm font-normal text-gray-500">2Pfund</span>
                      <div
                        class="inline-flex shrink-0 items-center rounded border border-accent bg-vert px-3 py-1 text-sm text-white"
                      >
                        3.33<svg
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

                    <span class="my-5 flex items-center md:my-10"
                      ><ins
                        class="text-2xl font-semibold text-vert no-underline md:text-3xl"
                        >{{ article.prix }} FCFA</ins
                      ></span
                    >
                    <div class="mt-6 flex flex-col items-center md:mt-6 lg:flex-row">
                      <div class="mb-3 w-full lg:mb-0 lg:max-w-[400px]">
                        <button
                          @click="addItemToCart(article)"
                          class="flex w-full items-center justify-center rounded bg-vert py-4 px-5 text-sm font-light text-white transition-colors duration-300 hover:bg-accent-hover focus:bg-accent-hover focus:outline-none lg:text-base"
                        >
                          <span class="font-bold text-2xl">Je commande</span>
                        </button>
                      </div>
                      <span
                        class="whitespace-nowrap ml-6 text-base text-gray-500 ltr:lg:ml-7 rtl:lg:mr-7"
                        >{{ article.quantite }} piece disponibles</span
                      >
                    </div>
                  </div>
                  <div
                    class="w-full mt-4 md:mt-6 pt-4 md:pt-6 flex flex-row items-start border-t border-border-200 border-opacity-60"
                  >
                    <span
                      class="text-sm font-semibold text-heading capitalize ltr:mr-6 rtl:ml-6 py-1"
                      >{{ article.categorie }}</span
                    >
                    <div class="flex flex-row flex-wrap">
                      <button
                        class="lowercase text-sm ml-4 text-heading tracking-wider whitespace-nowrap py-1 px-2.5 bg-transparent border border-border-200 rounded ltr:mr-2 rtl:ml-2 mb-2 transition-colors hover:border-accent hover:text-accent focus:outline-none focus:bg-opacity-100"
                      >
                        Fruits &amp; Vegetables
                      </button>
                    </div>
                  </div>
                  <div class="mt-2 flex items-center">
                    <span
                      class="py-1 text-sm font-semibold capitalize text-heading ltr:mr-6 rtl:ml-6"
                      >Sellers</span
                    ><button
                      class="text-sm ml-12 tracking-wider text-vert underline transition hover:text-accent-hover hover:no-underline"
                    >
                      {{ article.user_id }}
                    </button>
                  </div>
                </div>
              </div>
              <div
                class="border-b border-border-200 border-opacity-70 px-5 py-4 lg:px-16 lg:py-14"
              >
                <h2
                  class="mb-4 text-2xl text-vert font-bold tracking-tight text-heading md:mb-6"
                >
                  Description
                </h2>
                <p class="text-lg text-left">
                  {{ article.description }}
                </p>
              </div>
            </article>
          </article>

        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    article: Object,
    addItemToCart: Function,
  },

  methods: {
    closeModal() {
      this.$emit("close");
    },
  },
};
</script>
