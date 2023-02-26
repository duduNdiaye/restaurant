<template>
  <div
    class="z-50 transform-gpu fixed top-0 left-0 w-full h-full overflow-x-hidden overflow-y-auto bg-opacity-80 bg-black"
  >
    <div
      @click.self="closeModal"
      class="modal fixed top-0 duration-700 ease-in-out w-full"
    >
      <div class="modal-dialog mx-auto w-11/12 md:w-2/3 lg:w-1/3 my-12 md:my-24 lg:my-28">
        <div
          class="modal-content relative flex flex-col h-full bg-white shadow-lg rounded-md text-current"
        >
          <div
            class="modal-header h-28 bg-gray-100 flex-shrink-0 items-center justify-between px-4 py-3 border-b border-gray-200 rounded-t-md"
          >
            <h5
              class="text-xl mb-4 font-bold flex items-center justify-center leading-normal text-gray-800"
            >
              Commande pour...
            </h5>
            <div class="flex items-center justify-center">
              <button
                @click="Aujourdhui()"
                class="flex items-center justify-center px-5 mr-3 h-8 w-56"
                :class="[
                  aujourdhui
                    ? 'bg-vert text-white duration-300 translate-x-0'
                    : 'bg-white text-black duration-300',
                ]"
              >
                <svg
                  fill="#ffffff"
                  class="h-6 w-6 icon"
                  viewBox="0 0 32 32"
                  version="1.1"
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
                    <title>time</title>
                    <path
                      d="M11.188 27.188c-6.188 0-11.188-5-11.188-11.188s5-11.219 11.188-11.219 11.219 5.031 11.219 11.219-5.031 11.188-11.219 11.188zM11.188 7.563c-4.625 0-8.375 3.813-8.375 8.438s3.75 8.375 8.375 8.375 8.438-3.75 8.438-8.375-3.813-8.438-8.438-8.438zM14.219 20.281l-3.969-2.906c-0.281-0.219-0.563-0.688-0.563-1.063v-6.344c0-0.344 0.313-0.625 0.688-0.625h1.313c0.344 0 0.625 0.281 0.625 0.625v5c0 0.375 0.281 0.844 0.563 1.063l2.906 2.094c0.281 0.219 0.344 0.656 0.125 0.938l-0.781 1.063c-0.219 0.281-0.625 0.344-0.906 0.156z"
                    ></path>
                  </g>
                </svg>
                <span>Aujourd'hui</span>
              </button>
              <button
                @click="PlusTard()"
                :class="[
                  plustard
                    ? 'bg-vert text-white duration-300 translate-x-0'
                    : 'bg-white text-black duration-300',
                ]"
                class="px-5 border-1 flex items-center justify-center border-gray-200 h-8 w-56"
              >
                <svg
                  fill="#000000"
                  class="h-4 w-4 icon mr-2"
                  viewBox="0 0 100.353 100.353"
                  id="Layer_1"
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
                        d="M32.286,42.441h-9.762c-0.829,0-1.5,0.671-1.5,1.5v9.762c0,0.828,0.671,1.5,1.5,1.5h9.762c0.829,0,1.5-0.672,1.5-1.5 v-9.762C33.786,43.113,33.115,42.441,32.286,42.441z M30.786,52.203h-6.762v-6.762h6.762V52.203z"
                      ></path>
                      <path
                        d="M55.054,42.441h-9.762c-0.829,0-1.5,0.671-1.5,1.5v9.762c0,0.828,0.671,1.5,1.5,1.5h9.762c0.828,0,1.5-0.672,1.5-1.5 v-9.762C56.554,43.113,55.882,42.441,55.054,42.441z M53.554,52.203h-6.762v-6.762h6.762V52.203z"
                      ></path>
                      <path
                        d="M77.12,42.441h-9.762c-0.828,0-1.5,0.671-1.5,1.5v9.762c0,0.828,0.672,1.5,1.5,1.5h9.762c0.828,0,1.5-0.672,1.5-1.5v-9.762 C78.62,43.113,77.948,42.441,77.12,42.441z M75.62,52.203h-6.762v-6.762h6.762V52.203z"
                      ></path>
                      <path
                        d="M32.286,64.677h-9.762c-0.829,0-1.5,0.672-1.5,1.5v9.762c0,0.828,0.671,1.5,1.5,1.5h9.762c0.829,0,1.5-0.672,1.5-1.5 v-9.762C33.786,65.349,33.115,64.677,32.286,64.677z M30.786,74.439h-6.762v-6.762h6.762V74.439z"
                      ></path>
                      <path
                        d="M55.054,64.677h-9.762c-0.829,0-1.5,0.672-1.5,1.5v9.762c0,0.828,0.671,1.5,1.5,1.5h9.762c0.828,0,1.5-0.672,1.5-1.5 v-9.762C56.554,65.349,55.882,64.677,55.054,64.677z M53.554,74.439h-6.762v-6.762h6.762V74.439z"
                      ></path>
                      <path
                        d="M77.12,64.677h-9.762c-0.828,0-1.5,0.672-1.5,1.5v9.762c0,0.828,0.672,1.5,1.5,1.5h9.762c0.828,0,1.5-0.672,1.5-1.5v-9.762 C78.62,65.349,77.948,64.677,77.12,64.677z M75.62,74.439h-6.762v-6.762h6.762V74.439z"
                      ></path>
                      <path
                        d="M89,13.394h-9.907c-0.013,0-0.024,0.003-0.037,0.004V11.4c0-3.268-2.658-5.926-5.926-5.926s-5.926,2.659-5.926,5.926v1.994 H56.041V11.4c0-3.268-2.658-5.926-5.926-5.926s-5.926,2.659-5.926,5.926v1.994H33.025V11.4c0-3.268-2.658-5.926-5.926-5.926 s-5.926,2.659-5.926,5.926v1.995c-0.005,0-0.01-0.001-0.015-0.001h-9.905c-0.829,0-1.5,0.671-1.5,1.5V92.64 c0,0.828,0.671,1.5,1.5,1.5H89c0.828,0,1.5-0.672,1.5-1.5V14.894C90.5,14.065,89.828,13.394,89,13.394z M70.204,11.4 c0-1.614,1.312-2.926,2.926-2.926s2.926,1.312,2.926,2.926v8.277c0,1.613-1.312,2.926-2.926,2.926s-2.926-1.312-2.926-2.926V11.4z M50.115,8.474c1.613,0,2.926,1.312,2.926,2.926v8.277c0,1.613-1.312,2.926-2.926,2.926c-1.614,0-2.926-1.312-2.926-2.926v-4.643 c0.004-0.047,0.014-0.092,0.014-0.141s-0.01-0.094-0.014-0.141V11.4C47.189,9.786,48.501,8.474,50.115,8.474z M24.173,11.4 c0-1.614,1.312-2.926,2.926-2.926c1.613,0,2.926,1.312,2.926,2.926v8.277c0,1.613-1.312,2.926-2.926,2.926 c-1.614,0-2.926-1.312-2.926-2.926V11.4z M87.5,91.14H12.753V16.394h8.405c0.005,0,0.01-0.001,0.015-0.001v3.285 c0,3.268,2.659,5.926,5.926,5.926s5.926-2.658,5.926-5.926v-3.283h11.164v3.283c0,3.268,2.659,5.926,5.926,5.926 s5.926-2.658,5.926-5.926v-3.283h11.163v3.283c0,3.268,2.658,5.926,5.926,5.926s5.926-2.658,5.926-5.926V16.39 c0.013,0,0.024,0.004,0.037,0.004H87.5V91.14z"
                      ></path>
                    </g>
                  </g>
                </svg>
                <span>Plus tard</span>
              </button>
            </div>
          </div>
          <div class="modal-body h-10 bg-gray-100 px-4" :class="{ 'h-[24rem]': plustard }">
            <!-- <select class="w-full rounded-lg border-gray-200 focus:ring-black focus:border-none">
                <option value="1" class="text-center">A emporter</option>
                <option value="2" class="text-center ">Livraison</option>
                <option value="3" class="text-center">Sur place</option>
              </select> -->
            <div v-if="plustard" class="flex items-center justify-center mt-2">
              <DatePicker v-model="date" />
            </div>
            <div class="flex items-center justify-center">
                <input
              :class="{'mt-3 w-56 ':plustard}"
              type="time"
              class="h-10 border-2 border-gray-200 w-full rounded-lg focus:ring-vert focus:border-none focus:outline-none"
            />
            </div>
          </div>
          <div
            class="modal-footer bg-gray-100 flex-shrink-0 flex-wrap items-center justify-end px-4 py-3 border-t border-gray-200 rounded-b-md"
          >
            <button
              type="button"
              class="px-6 ml-36 flex items-center justify-center py-2.5 bg-vert text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-haver hover:shadow-lg focus:bg-haver focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
            >
              Valider
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
      plustard: false,
      aujourdhui: true,
      date: new Date(),
    };
  },
  props: {
    dater: {
      type: Boolean,
      required: true,
    },
  },
  components: {},

  methods: {
    closeModal() {
      this.$emit("close");
      console.log(this.comment);
    },
    PlusTard() {
      this.plustard = !this.plustard;
      this.aujourdhui = !this.aujourdhui;
    },
    Aujourdhui() {
      this.plustard = !this.plustard;
      this.aujourdhui = !this.aujourdhui;
    },
  },
};
</script>
