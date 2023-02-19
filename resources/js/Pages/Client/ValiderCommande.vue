<script setup>
import { Head, Link } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  articles: {},
});
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
    <div class="px-4 py-8 bg-gray-100 lg:py-24 xl:py-14 xl:px-16 2xl:px-20">
      <div
        class="flex flex-col items-center w-full mt-16 max-w-6xl m-auto rtl:space-x-reverse lg:flex-row lg:items-start lg:space-x-8"
      >
        <div class="w-full space-y-6 lg:max-w-2xl">
          <div class="p-5 bg-white shadow-xl md:p-8">
            <div class="mb-5 flex items-center justify-between md:mb-8">
              <div class="flex items-center space-x-3 rtl:space-x-reverse md:space-x-4">
                <span
                  class="flex items-center justify-center w-8 h-8 text-lg rounded-full bg-vert text-white lg:text-xl"
                  >1</span
                >
                <p class="text-lg capitalize text-heading lg:text-xl">Contact Number</p>
              </div>
              <button
                class="flex items-center text-sm font-semibold transition-colors duration-200 text-vert hover:text-vert-hover focus:text-vert-hover focus:outline-none"
              >
                <svg
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  class="h-4 w-4 stroke-2 ltr:mr-0.5 rtl:ml-0.5"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                  ></path></svg
                >Update
              </button>
            </div>
            <div class="w-full">
              <div class="react-tel-input">
                <div class="special-label">Phone</div>
                <input
                  class="form-control p-3 ltr:pr-4 rtl:pl-4 ltr:pl-14 rtl:pr-14 flex items-center w-full appearance-none transition duration-300 ease-in-out text-heading text-sm focus:!outline-none focus:ring-0 border border-gray-300 rounded focus:border-gray-200 h-12"
                  placeholder="1 (702) 123-4567"
                  disabled=""
                  type="tel"
                  value="(+221)778021496"
                />
                <div class="flag-dropdown">
                  <div
                    class="selected-flag"
                    title="United States: + 1"
                    tabindex="0"
                    role="button"
                    aria-haspopup="listbox"
                  >
                    <div class="flag us"><div class="arrow"></div></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="p-5 bg-white shadow-700 md:p-8">
            <div class="flex items-center justify-between mb-5 md:mb-8">
              <div class="flex items-center space-x-3 md:space-x-4 rtl:space-x-reverse">
                <span
                  class="rounded-full w-8 h-8 bg-vert flex items-center justify-center text-lg lg:text-xl text-white"
                  >2</span
                >
                <p class="text-lg lg:text-xl text-heading capitalize">Billing Address</p>
              </div>
              <button
                class="flex items-center text-sm font-semibold text-vert transition-colors duration-200 focus:outline-none focus:text-vert-hover hover:text-vert-hover"
              >
                <svg
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  class="w-4 h-4 stroke-2 ltr:mr-0.5 rtl:ml-0.5"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                  ></path></svg
                >Add
              </button>
            </div>
            <div
              id="headlessui-radiogroup-35"
              role="radiogroup"
              aria-labelledby="headlessui-label-36"
            >
              <label class="sr-only" id="headlessui-label-36" role="none"
                >Billing Address</label
              >
              <div
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3"
                role="none"
              >
                <div
                  id="headlessui-radiogroup-option-37"
                  role="radio"
                  aria-checked="true"
                  tabindex="0"
                >
                  <div
                    class="group relative cursor-pointer rounded border p-4 hover:border-vert border-vert shadow-sm"
                  >
                    <p class="mb-3 text-sm font-semibold capitalize text-heading">
                      Billing
                    </p>
                    <p class="text-sm text-sub-heading">
                      2231 Kidd Avenue, AK, Kipnuk, 99614, United States
                    </p>
                    <div
                      class="absolute top-4 flex space-x-2 opacity-0 group-hover:opacity-100 ltr:right-4 rtl:left-4 rtl:space-x-reverse"
                    >
                      <button
                        class="flex h-5 w-5 items-center justify-center rounded-full bg-vert text-white"
                      >
                        <span class="sr-only">Edit</span
                        ><svg
                          class="h-3 w-3"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                          ></path>
                        </svg></button
                      ><button
                        class="flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-white"
                      >
                        <span class="sr-only">Delete</span
                        ><svg
                          class="h-3 w-3"
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="p-5 bg-white shadow-700 md:p-8">
            <div class="flex items-center justify-between mb-5 md:mb-8">
              <div class="flex items-center space-x-3 md:space-x-4 rtl:space-x-reverse">
                <span
                  class="rounded-full w-8 h-8 bg-vert flex items-center justify-center text-lg lg:text-xl text-white"
                  >3</span
                >
                <p class="text-lg lg:text-xl text-heading capitalize">Shipping Address</p>
              </div>
              <button
                class="flex items-center text-sm font-semibold text-vert transition-colors duration-200 focus:outline-none focus:text-vert-hover hover:text-vert-hover"
              >
                <svg
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                  class="w-4 h-4 stroke-2 ltr:mr-0.5 rtl:ml-0.5"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                  ></path></svg
                >Add
              </button>
            </div>
            <div
              id="headlessui-radiogroup-38"
              role="radiogroup"
              aria-labelledby="headlessui-label-39"
            >
              <label class="sr-only" id="headlessui-label-39" role="none"
                >Shipping Address</label
              >
              <div
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3"
                role="none"
              >
                <div
                  id="headlessui-radiogroup-option-40"
                  role="radio"
                  aria-checked="true"
                  tabindex="0"
                >
                  <div
                    class="group relative cursor-pointer rounded border p-4 hover:border-vert border-vert shadow-sm"
                  >
                    <p class="mb-3 text-sm font-semibold capitalize text-heading">
                      Shipping
                    </p>
                    <p class="text-sm text-sub-heading">
                      2148 Straford Park, KY, Winchester, 40391, United States
                    </p>
                    <div
                      class="absolute top-4 flex space-x-2 opacity-0 group-hover:opacity-100 ltr:right-4 rtl:left-4 rtl:space-x-reverse"
                    >
                      <button
                        class="flex h-5 w-5 items-center justify-center rounded-full bg-vert text-white"
                      >
                        <span class="sr-only">Edit</span
                        ><svg
                          class="h-3 w-3"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                          ></path>
                        </svg></button
                      ><button
                        class="flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-white"
                      >
                        <span class="sr-only">Delete</span
                        ><svg
                          class="h-3 w-3"
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="p-5 bg-white shadow-700 md:p-8">
            <div class="mb-5 flex items-center justify-between md:mb-8">
              <div class="flex items-center space-x-3 rtl:space-x-reverse md:space-x-4">
                <span
                  class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-lg text-white lg:text-xl"
                  >4</span
                >
                <p class="text-lg capitalize text-heading lg:text-xl">
                  Delivery Schedule
                </p>
              </div>
            </div>
            <div
              id="headlessui-radiogroup-41"
              role="radiogroup"
              aria-labelledby="headlessui-label-42"
            >
              <label class="sr-only" id="headlessui-label-42" role="none"
                >Delivery Schedule</label
              >
              <div
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3"
                role="none"
              >
                <div
                  id="headlessui-radiogroup-option-43"
                  role="radio"
                  aria-checked="true"
                  tabindex="0"
                >
                  <div
                    class="relative p-4 rounded border cursor-pointer group hover:border-vert border-vert shadow-sm"
                  >
                    <span class="text-sm text-heading font-semibold block mb-2"
                      >Express Delivery</span
                    ><span class="text-sm text-heading block"
                      >90 min express delivery</span
                    >
                  </div>
                </div>
                <div
                  id="headlessui-radiogroup-option-44"
                  role="radio"
                  aria-checked="false"
                  tabindex="-1"
                >
                  <div
                    class="relative p-4 rounded border cursor-pointer group hover:border-vert bg-gray-100 border-transparent"
                  >
                    <span class="text-sm text-heading font-semibold block mb-2"
                      >Morning</span
                    ><span class="text-sm text-heading block">8.00 AM - 11.00 AM</span>
                  </div>
                </div>
                <div
                  id="headlessui-radiogroup-option-45"
                  role="radio"
                  aria-checked="false"
                  tabindex="-1"
                >
                  <div
                    class="relative p-4 rounded border cursor-pointer group hover:border-vert bg-gray-100 border-transparent"
                  >
                    <span class="text-sm text-heading font-semibold block mb-2">Noon</span
                    ><span class="text-sm text-heading block">11.00 AM - 2.00 PM</span>
                  </div>
                </div>
                <div
                  id="headlessui-radiogroup-option-46"
                  role="radio"
                  aria-checked="false"
                  tabindex="-1"
                >
                  <div
                    class="relative p-4 rounded border cursor-pointer group hover:border-vert bg-gray-100 border-transparent"
                  >
                    <span class="text-sm text-heading font-semibold block mb-2"
                      >Afternoon</span
                    ><span class="text-sm text-heading block">2.00 PM - 5.00 PM</span>
                  </div>
                </div>
                <div
                  id="headlessui-radiogroup-option-47"
                  role="radio"
                  aria-checked="false"
                  tabindex="-1"
                >
                  <div
                    class="relative p-4 rounded border cursor-pointer group hover:border-vert bg-gray-100 border-transparent"
                  >
                    <span class="text-sm text-heading font-semibold block mb-2"
                      >Evening</span
                    ><span class="text-sm text-heading block">5.00 PM - 8.00 PM</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="w-full mt-10 mb-10 sm:mb-12 lg:mb-0 lg:w-96">
          <div class="w-full lg:ml-12">
            <div class="mb-4 flex flex-col items-center space-x-4 rtl:space-x-reverse">
              <span class="text-xl font-bold text-heading">Your Order</span>
            </div>
            <div class="flex flex-col border-b border-border-200 py-3">
              <div class="flex justify-between py-2">
                <div class="flex items-center justify-between text-xl">
                  <span class="text-lg text-gray-500"
                    ><span class="text-xl font-extrabold text-black">1</span
                    ><span class="mx-2">x</span><span>Brussels Sprout</span> |
                    <span>1lb</span></span
                  >
                </div>
                <span class="text-lg text-gray-500">$3.00</span>
              </div>
            </div>
            <div class="mt-4 space-y-2">
              <div class="flex justify-between">
                <p class="text-lg text-gray-500">Sub Total</p>
                <span class="text-lg text-gray-500">$3.00</span>
              </div>
              <div class="flex justify-between">
                <p class="text-lg text-gray-500">Tax</p>
                <span class="text-sm text-gray-500">Calculated at checkout</span>
              </div>
              <div class="flex justify-between">
                <p class="text-sm text-gray-500">Estimated Shipping</p>
                <span class="text-sm text-gray-500">Calculated at checkout</span>
              </div>
            </div>
            <button
              data-variant="normal"
              class="inline-flex items-center justify-center shrink-0 font-bold leading-none rounded outline-none transition duration-300 ease-in-out focus:outline-none focus:shadow focus:ring-1 focus:ring-vert-700 bg-vert text-white text-lg border border-transparent hover:bg-vert-hover px-5 py-0 h-12 mt-5 w-full"
            >
              Check Availability
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
