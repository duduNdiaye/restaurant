<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    article: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm({

});
function destroy() {
        form.delete(route('delete.article', props.article.id));

}
</script>
<template>

<div class="fixed z-10 inset-0 overflow-y-auto" v-if="isConfirmed"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     >
  <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

    <!-- Fond sombre derrière le modal -->
    <div class="fixed inset-0 transition-opacity" aria-hidden="true"
         @click=" closePopup">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <!-- Contenu du modal -->
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden
                shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"

         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

        <!-- Titre du modal -->
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full
                      bg-red-100 sm:mx-0 sm:h-10 sm:w-10" @click="closePopup">
            <!-- Icône de suppression -->
            <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </div>
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Êtes-vous sûr de vouloir supprimer cet article ?
            </h3>
          </div>
        </div>

        <!-- Texte de confirmation -->
        <div class="mt-5">
          <p class="text-sm text-gray-500">
            Cette action est irréversible. Vous perdrez toutes les données associées à cet article.
          </p>
        </div>
  </div>

  <!-- Boutons de confirmation et d'annulation -->
  <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
    <form>
    <button class="w-full inline-flex justify-center rounded-md border border-transparent
                   shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white
                   hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                   focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
            @click="destroy();closePopup()">
      Supprimer
    </button>
    <button class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300
                   shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700
                   hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2
                   focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
            @click="closePopup">
      Annuler
    </button>
</form>
  </div>
</div>
</div>
</div>

</template>

<script>

  export default  {
    name: 'resources-js-pages-restaurant-article-article-delete-modal',
    props: ['article'],
    mounted () {

    },
    data () {
      return {
        isConfirmed:true
      }
    },
    methods: {
        closePopup(){
            this.$emit('close')
        }

    },
    computed: {

    }
}


</script>

<style >

</style>
