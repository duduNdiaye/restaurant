<script setup>
import {  useForm } from '@inertiajs/vue3';

const props = defineProps({
    articles: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    nom: '',
    prix: '',
    categorie:'',
    quantite:'',
    tempsPreparation:'',
    description:'',
    ingredients:'',
    photo:''


});
const submit = () => {
  form.post(route('store.article'))
    // this.showCreateModal=false


};
</script>
<!-- le template--->
<template >
<div class="fixed z-10 inset-0 overflow-y-auto" v-if="isSubmitted">

      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" >
          <div class="absolute inset-0 bg-gray-500 opacity-75" @click.self="closeModal"></div>
        </div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ajouter un article</h3>
            <form @submit.prevent="" >
              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6">
                  <label for="nom" class="block text-sm font-medium text-gray-700">Nom Article</label>
                  <input type="text" name="nom" id="nom" v-model="form.nom" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="prix" class="block text-sm font-medium text-gray-700">Prix</label>
                  <input type="number" name="prix" id="prix" v-model="form.prix"   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
                  <select id="categorie" name="categorie" v-model="form.categorie"  class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option disabled value="">-------</option>
                    <option value="aliments">Aliments</option>
                    <option value="boissons">Boissons</option>
                    <option value="desserts">Desserts</option>
                  </select>
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
                  <input type="number" name="quantite" id="quantite" v-model="form.quantite" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6 sm:col-span-3">
                  <label for="tempsPreparation" class="block text-sm font-medium text-gray-700">Temps de preparation</label>
                  <input type="time" name="tempsPreparation" v-model="form.tempsPreparation" id="tempsPreparation" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6 sm:col-span-3">
                  <label for="description" class="block text-sm font-medium text-gray-700">description</label>
                  <input type="text" name="description" id="description" v-model="form.description"  class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6 sm:col-span-3">
                  <label for="ingredients" class="block text-sm font-medium text-gray-700">Ingredients</label>
                  <input type="text" name="ingredients" id="ingredients" v-model="form.ingredients" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6 sm:col-span-3">
                  <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                  <input type="text" name="photo" id="photo" v-model="form.photo" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="flex justify-start relative space-x-4 mt-4">
  <button type="button" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" @click="closeModal" >Quitter  </button>
  <button type="button" class="px-4 py-2 text-white bg-blue-400 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2" @click="submit();closeModal();showMessage()">Ajouter</button>
</div>
              </div>
            </form>
          </div>
        </div>
      </div>
</div>

</template>

<script>
  export default  {
    name: "ArtcileCreatemodal",
    props:['activemodal','showmodal'],
    data(){
        return{
            isSubmitted:true,

        }
    },
    mounted(){


    },
    methods:{
        closeModal(){
            this.$emit('close')
        },
        showMessage()
        {
            this.$emit('affiche')
        },
    }
};
</script>

<style>
</style>
