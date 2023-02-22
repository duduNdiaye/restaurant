
<template>

<div class="flex flex-col">
    <button
      class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-4"
      @click="showmodal">
      Créer un nouvel article
    </button>
    <h1 class="text-3xl font-semibold mb-6">Liste des articles </h1>
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catégorie</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temps de préparation</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" >

              <tr v-for="article in articlesAll" :key="article.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ article.nom }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ article.prix }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ article.categorie }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ article.quantite }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ article.tempsPreparation }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <img :src=" article.photo" alt="Article" class="w-10 h-10 rounded-full" />
                </td>
                <td class="border py-2 px-4">
            <button type="submit"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mr-2"
              @click="editArtcile(article)">
              Modifier
            </button>
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
             @click="deleteArticle(article)" >
              Supprimer
            </button>
          </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</div>
<!-- modal -->
<ArticleCreateModal v-if="activemodal" @close="activemodal=false" >
</ArticleCreateModal>

<ArticleEditModal
:articles="articledites"
v-if="activedit"
@close="activedit=false"
></ArticleEditModal>

<ArticleDeleteModal
:article="articleAsupprimer"
v-if="activedelete"
@close="activedelete=false"
>
</ArticleDeleteModal>

</template>

<script>
import ArticleCreateModal from './Article/ArticleCreateModal.vue';
import ArticleEditModal from './Article/ArticleEditModal .vue';
import ArticleDeleteModal from './Article/ArticleDeleteModal.vue';

  export default  {
    name: "tablearticles",
    props: {
        articlesAll: Array,
    },
    data(){
        return {
            activemodal: false,
            activedit:false,
            articledites:null,
            activedelete:false,
            articleAsupprimer:null
        };
    },
    methods: {
        showmodal(){
            this.activemodal=!this.activemodal;
        },
        editArtcile(article){
            this.activedit=!this.activedit
            this.articledites=article
            console.log(this.activedit)
        },
        deleteArticle(article){
            this.activedelete=!this.activedelete
            this.articleAsupprimer=article
            console.log(this.activedelete)
        }

    },
    computed:{

    },
    components: { ArticleCreateModal, ArticleEditModal, ArticleDeleteModal }
};


</script>

<style >

</style>
