<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    menujour: {
        type: Object,
        default: () => ({}),
    },
    articles:{
        type: Array,
        default: () => ({}),
    }
});
const form = useForm({
    id:props.menujour.id,
    jour_semaine: props.menujour.jour_semaine,

    selectedArticles: props.menujour.articles.map((article) => article.id),
});
const submit = () => {
  form.put(route('edit.menu',props.menujour.id))
    // this.showCreateModal=false


};
    </script>
<template >
<div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center" v-if="isSubmitted">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" @click.self="closeModal"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

      <div class="modal-content py-4 text-left px-6">
        <div class="flex justify-between items-center pb-3">
          <p class="text-2xl font-bold">Modifier un menu</p>
          <div class="modal-close cursor-pointer z-50" @click="closeModal">
            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
              <path d="M18 1.8l-1.8-1.8-7.2 7.2-7.2-7.2-1.8 1.8 7.2 7.2-7.2 7.2 1.8 1.8 7.2-7.2 7.2 7.2 1.8-1.8-7.2-7.2z"></path>
            </svg>
          </div>
        </div>
        <form >
            <input type="hidden" v-model="form.id" name="id">
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="jour_semaine">Jour du menu</label>
          <input type="text" class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="jour_semaine" name="jour_semaine" disabled v-model="form.jour_semaine">

        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="menu_articles">Articles</label>
            <Multiselect
            v-model="form.selectedArticles"
            mode="tags"


            :options="articleOptions"
            :search="true"
            label="name"
            track-by="id"
            :multiple="true"
            name="selectedArticles[]"
             />

        </div>
       <p>{{ form.selectedArticles }}</p>


        <div class="flex justify-end pt-2">
          <button class="modal-close px-4 bg-gray-400 p-3 rounded-lg text-white hover:bg-gray-300" type="button" @click="closeModal">Annuler</button>
          <button class="px-4 bg-blue-500 p-3 ml-3 rounded-lg text-white hover:bg-blue-400" type="button" @click="submit();closeModal()">Modifier</button>
        </div>
    </form>

      </div>
    </div>
  </div>

</template>

<script>
  import Multiselect from '@vueform/multiselect';
  export default  {
    name: 'resources-js-pages-restaurant-menu-menu-edit',
    props: [],
    mounted () {

    },
    data () {
      return {
        isSubmitted:true
      }
    },
    methods: {
        closeModal(){
            this.$emit('close')
        }
    },
    computed: {
        articleOptions() {
      return this.articles.map((article) => ({
        id: article.id,
        name: article.nom,
        value: article.id,
      }));
    },
    }
}


</script>

<style src="@vueform/multiselect/themes/default.css"></style>
