
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
             @click="deleteArticle(article)">
             <svg height="20px" width="20px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" style=".st0{fill:#000000;}" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path class="st0" d="M88.594,464.731C90.958,491.486,113.368,512,140.234,512h231.523c26.858,0,49.276-20.514,51.641-47.269 l25.642-335.928H62.952L88.594,464.731z M420.847,154.93l-23.474,307.496c-1.182,13.37-12.195,23.448-25.616,23.448H140.234 c-13.42,0-24.434-10.078-25.591-23.132L91.145,154.93H420.847z"></path> <path class="st0" d="M182.954,435.339c5.877-0.349,10.35-5.4,9.992-11.269l-10.137-202.234c-0.358-5.876-5.401-10.349-11.278-9.992 c-5.877,0.357-10.35,5.409-9.993,11.277l10.137,202.234C172.033,431.231,177.085,435.696,182.954,435.339z"></path> <path class="st0" d="M256,435.364c5.885,0,10.656-4.763,10.656-10.648V222.474c0-5.885-4.771-10.648-10.656-10.648 c-5.885,0-10.657,4.763-10.657,10.648v202.242C245.344,430.601,250.115,435.364,256,435.364z"></path> <path class="st0" d="M329.046,435.339c5.878,0.357,10.921-4.108,11.278-9.984l10.129-202.234c0.348-5.868-4.116-10.92-9.993-11.277 c-5.877-0.357-10.92,4.116-11.277,9.992L319.054,424.07C318.697,429.938,323.17,434.99,329.046,435.339z"></path> <path class="st0" d="M439.115,64.517c0,0-34.078-5.664-43.34-8.479c-8.301-2.526-80.795-13.566-80.795-13.566l-2.722-19.297 C310.388,9.857,299.484,0,286.642,0h-30.651H225.34c-12.825,0-23.728,9.857-25.616,23.175l-2.721,19.297 c0,0-72.469,11.039-80.778,13.566c-9.261,2.815-43.357,8.479-43.357,8.479C62.544,67.365,55.332,77.172,55.332,88.38v21.926h200.66 h200.676V88.38C456.668,77.172,449.456,67.365,439.115,64.517z M276.318,38.824h-40.636c-3.606,0-6.532-2.925-6.532-6.532 s2.926-6.532,6.532-6.532h40.636c3.606,0,6.532,2.925,6.532,6.532S279.924,38.824,276.318,38.824z"></path> </g> </g></svg>
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
