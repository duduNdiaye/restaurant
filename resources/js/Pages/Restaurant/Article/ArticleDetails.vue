<template>
    <!-- Modal pour afficher les détails de l'article -->
<div class="fixed z-10 inset-0 overflow-y-auto" v-if="isFocused">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0" >
    <!-- Fond gris pour le modal -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click.self="closeModal"></div>

    <!-- Contenu du modal -->
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <!-- Entête du modal -->
      <div class="bg-gray-50 px-4 py-3 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ article.nom }}</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ article.categorie }}</p>
      </div>

      <!-- Contenu du modal -->
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <!-- Image de l'article -->
          <img :src= article.photo :alt=article.nom  class="w-48 h-48 object-cover rounded-lg">

          <!-- Détails de l'article -->
          <div class="mt-3 text-left sm:mt-0 sm:ml-4 sm:text-left">
            <div class="mt-2">
              <p class="text-sm text-gray-500">Prix :</p>
              <p class="text-lg font-bold text-gray-900">{{ article.prix }} Frs</p>
            </div>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Description :</p>
              <p class="text-lg text-gray-900">{{ article.description }}</p>
            </div>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Ingrédients :</p>
              <p class="text-lg text-gray-900">{{ article.ingredients }}</p>
            </div>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Temps de préparation :</p>
              <p class="text-lg text-gray-900">{{ article.tempsPreparation }} minutes</p>
            </div>
            <div class="mt-2">
              <p class="text-sm text-gray-500">Quantité :</p>
              <p class="text-lg text-gray-900">{{ article.quantite }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Boutons pour fermer le modal -->
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
        @click="closeModal">
            Fermer
        </button>
      </div>
     </div>
    </div>
</div>
</template>
<script>
  export default  {
    name: "ArtcileCreatemodal",
    props:{
        article:Object,


    },
    data(){
        return{
            isFocused:true,
            // form:{
            //     nom: this.articles.nom,
            //     prix: this.articles.prix,
            //     categorie:'',
            //     quantite:'',
            //     tempsPreparation:'',
            //     description:'',
            //     ingredients:'',
            //     photo:''
            // }
        }
    },
    methods:{
        closeModal(){
            this.$emit('close')
        },


    }
};
</script>
