<template>
  <transition name="panierr">
    <div
      v-if="show"
      class="w-full fixed top-4 z-[51] lg:left-80 md:left-36 max-w-2xl rounded-xl h-[32rem] bg-white p-6 md:p-12 mt-16"
    >
      <div class="flex items-center justify-center sm:mb-10">
        <span class="lg:text-xl font-bold sm:text-xl"> Paiement </span>
      </div>

      <div class="space-y-2 h-[20rem] flex flex-col w-full">
        <div class="bg-gray-100 w-full h-16 flex justify-between items-center px-4">
          <span class="text-gray-500 font-bold">Type paiement</span>

          <span class="bg-haver text-white font-bold p-2">Apres reception</span>
        </div>
        <div class="flex space-x-4">
          <input
            :class="`shake ${indication1 ? 'animate-shake ' : ''}`"
            v-model="nom"
            type="text"
            placeholder="Nom*"
            class="h-16 rounded border w-full border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
          />
          <input
            :class="`shake ${indication2 ? 'animate-shake ' : ''}`"
            v-model="telephone"
            placeholder="Telephone*"
            type="text"
            class="h-16 rounded border w-full border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
          />
        </div>
        <input
          :class="`shake ${indication3 ? 'animate-shake ' : ''}`"
          v-model="adresse"
          placeholder="Adresse*"
          type="text"
          class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
        />

        <input
          :class="`shake ${indication4 ? 'animate-shake ' : ''}`"
          v-model="email"
          placeholder="example@gmail.com"
          type="email"
          class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
        />
      </div>

      <div class="mt-8 flex justify-end">
        <button
          @click="PayerCommande()"

          class="inline-flex px-4 py-2 text-white items-center justify-center shrink-0 font-bold leading-none rounded outline-none transition duration-300 ease-in-out focus:outline-none focus:shadow focus:ring-1 focus:ring-accent-700 bg-vert text-light border border-transparent hover:bg-accent-hover"
        >
          Payer
        </button>
      </div>
    </div>
  </transition>
</template>
<script>
export default {
  data() {
    return {
      nom: null,
      telephone: null,
      adresse: null,
      email: null,
      isShaking: false,
      indication1: false,
      indication2: false,
      indication3: false,
      indication4: false,
    };
  },
  props: {
    paypal: {
      type: Boolean,
      required: true,
    },
    paytech: {
      type: Boolean,
      required: true,
    },
    card: {
      type: Boolean,
      required: true,
    },
    show: {
      type: Boolean,
      required: true,
    },
  },
  computed() {
    AllCompleted1();
  },
  methods: {
    closeModal() {
      this.$emit("close");
    },
    PayerCommande() {
      if (this.nom == null) {
        this.indication1 = true;
      } else if (this.telephone == null) {
        this.indication2 = true;
      } else if (this.adresse == null) {
        this.indication3 = true;
      } else if (this.email == null) {
        this.indication4 = true;
      }else if (this.email == null && this.nom == null && this.telephone == null) {
        this.indication4 = true;
        this.indication1 = true;
        this.indication3 = true;
        this.indication2 = true;
      }
       else {
        console.log("here", this.nom);
        this.fini = true;
        this.$emit("PhaseFinale", this.nom, this.telephone, this.adresse, this.email);
        this.closeModal();
      }
    },

    shake() {
      this.isShaking = true;
      setTimeout(() => {
        this.isShaking = false;
      }, 1000);
    },
  },
};
</script>
<style>
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

.panierr-enter-active,
.panierr-leave-active {
  transition: transform 0.5s ease, opacity 0.5s ease;
  transform: translateY(-20%);
  opacity: 0;
}

.panierr-enter,
.panierr-leave-to {
  opacity: 0;
  transform: translateY(-20%);
}

.panierr-leave,
.panierr-enter-to {
  opacity: 1;
  transform: translateY(0);
}
</style>
