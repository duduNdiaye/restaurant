<template>
  <transition name="panierrr">
    <div
      v-if="lanote"
      @click.self="lanote = false"
      class="modal z-[52] fixed top-36 duration-700 ease-in-out w-full"
    >
      <div class="modal-dialog mx-auto w-11/12 md:w-fit lg:w-1/3 my-12 md:my-24 lg:my-28">
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
              @click="lanote = false"
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
</template>

<script>
export default {
  props: {
    lanote: {
      type: Boolean,
      required: true,
    },
  },

  methods: {
    closeModal() {
      this.$emit("close");
      console.log("notation");
    },
  },
  mounted(){
    console.log(this.lanote)
  }
};
</script>

<style>
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
</style>
