<template>
    <transition name="panierr">
      <div v-if="show" class="w-full fixed top-4 z-[51] lg:left-80 md:left-36 max-w-2xl rounded-xl h-[32rem] bg-white p-6 md:p-12 mt-16">
        <div class="flex items-center justify-center sm:mb-10">
          <span class="lg:text-xl font-bold sm:text-xl"> Paiement </span>
        </div>

        <div class="space-y-2 h-[20rem] flex flex-col w-full">
          <div class="bg-gray-100 w-full h-16 flex items-center px-4">
            <span class="text-gray-500 font-bold">Compagnie</span>
            <img
              v-if="paypal"
              src="//img.ltwebstatic.com/images2_pi/2018/06/06/15282733431754785346.webp"
              class="h-12 mr-3 ml-auto"
            />
            <img
              v-if="card"
              src="//img.ltwebstatic.com/images2_pi/2018/06/06/15282732803587566708.webp"
              class="h-12 mr-3 ml-auto"
            />
            <img
              v-if="paytech"
              src="../../../../storage/app/public/paytech.jpg"
              class="h-12 w-24 ml-auto"
            />
          </div>
          <div class="flex space-x-4">
            <input
            v-model="nom"
              type="text"
              placeholder="Nom*"
              class="h-16 rounded border w-full border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
            />
            <input
            v-model="telephone"
              placeholder="Telephone*"
              type="text"
              class="h-16 rounded border w-full border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
            />
          </div>
          <input
            v-model="adresse"
            placeholder="Adresse*"
            type="text"
            class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
          />
          <label for="credit" class="text-gray-500 font-bold">Numero carte credit</label>
          <input
            disabled
            placeholder="**** **** **4242"
            type="text"
            class="h-16 rounded border border-gray-300 hover:border-black focus:ring-black focus:border-none focus:outline-none"
          />
        </div>

        <div class="mt-8 flex justify-end">
          <button @click="PayerCommande(),closeModal()"

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
    data(){
        return{
            nom:null,
            telephone:null,
            adresse:null,
        }
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
  methods: {
    closeModal() {
      this.$emit("close");
    },
     PayerCommande() {
      console.log("here",this.nom)
      this.fini = true
      this.$emit("Transaction",this.nom,this.telephone,this.adresse);
    },
  },
};
</script>
<style>
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
