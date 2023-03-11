
<template>
<DashLayout>
<div class="flex flex-col">
    <button
      class="bg-vert hover:bg-haver text-white font-bold py-2 px-4 rounded my-4"
      @click="showmodal">
      Créer un nouvel article
    </button>
    <div class="fixed bottom-4 right-4 z-50">
        <div v-if="message && message=='article ajouté'" class="bg-green-600 text-white px-4 py-2 rounded-md shadow-md">
            Votre insertion a été effectuée avec succès !
        </div>
    </div>
    <div class="fixed bottom-4 right-4 z-50">
        <div v-if="message && message=='article modifié'" class="bg-yellow-600 text-white px-4 py-2 rounded-md shadow-md">
            Votre modification a été effectuée avec succès !
        </div>
    </div>
    <div class="fixed bottom-4 right-4 z-50">
        <div v-if="message && message=='article supprimé'" class="bg-red-600 text-white px-4 py-2 rounded-md shadow-md">
            Votre suppression a été effectuée avec succès !
        </div>
    </div>

    <div class="flex flex-row justify-between">
        <h1 class="text-3xl font-semibold mb-6">Liste des articles </h1>
        <!--ICI LA SEARCH BAR-->
        <!-- <div class="flex items-center mb-4">
          <label for="search" class="mr-2 text-md font-semibold ">Rechercher:</label>
          <input type="text" id="search"  name="search" v-model="search" @keyup="searching" class="w-64 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500" >
        </div> -->
        <!-- endpoint -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4">
                <label for="search" class="mr-2 text-md font-semibold ">Rechercher:</label>
                <input type="search" id="search"  name="search" v-model="search" @keyup="searching" class="w-full py-2 pl-10 pr-4 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:outline-none" placeholder="Recherche">
            </div>
        </div>

        <!--FIN DE LA SEARCH BAR-->
    </div>
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
                <th></th>
                <th></th>
              </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200" >

              <tr v-for="article in articles.data" :key="article.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ article.nom }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ article.prix }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ article.categorie }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ article.quantite }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ article.tempsPreparation }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <img :src=" article.photo" alt="Article" class="w-10 h-10 rounded-full" />
                </td>
                <td class="border py-2 px-4">
            <button type="submit" class=" text-white font-bold py-1 px-1 rounded mr-2"
             @click="">
             <svg width="25px" height="25px" viewBox="-2.4 -2.4 28.80 28.80" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#1a5fb4"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <circle cx="12" cy="12" r="4" fill="#33363F"></circle> <path d="M21 12C21 12 20 4 12 4C4 4 3 12 3 12" stroke="#33363F" stroke-width="2"></path> </g></svg>
            </button>
            <button type="submit"
              class=" text-white font-bold py-1 px-1 rounded mr-2"
              @click="editArtcile(article)">
              <svg width="25px" height="25px" viewBox="0 0 24 24"  style="hover {color: #e5a50a;}" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C12 20.4477 12.4477 20 13 20H21C21.5523 20 22 20.4477 22 21C22 21.5523 21.5523 22 21 22H13C12.4477 22 12 21.5523 12 21Z" fill="#f8e45c"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M20.7736 8.09994C22.3834 6.48381 22.315 4.36152 21.113 3.06183C20.5268 2.4281 19.6926 2.0233 18.7477 2.00098C17.7993 1.97858 16.8167 2.34127 15.91 3.09985C15.8868 3.11925 15.8645 3.13969 15.8432 3.16111L2.87446 16.1816C2.31443 16.7438 2 17.5051 2 18.2987V19.9922C2 21.0937 2.89197 22 4.00383 22H5.68265C6.48037 22 7.24524 21.6823 7.80819 21.1171L20.7736 8.09994ZM17.2071 5.79295C16.8166 5.40243 16.1834 5.40243 15.7929 5.79295C15.4024 6.18348 15.4024 6.81664 15.7929 7.20717L16.7929 8.20717C17.1834 8.59769 17.8166 8.59769 18.2071 8.20717C18.5976 7.81664 18.5976 7.18348 18.2071 6.79295L17.2071 5.79295Z" fill="#f8e45c"></path> </g></svg>
            </button>
            <button type="submit" class=" text-white font-bold py-1 px-1 rounded"
             @click="deleteArticle(article)">
             <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M4 7H20" stroke="#ed333b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 10L7.70141 19.3578C7.87432 20.3088 8.70258 21 9.66915 21H14.3308C15.2974 21 16.1257 20.3087 16.2986 19.3578L18 10" stroke="#ed333b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#ed333b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
          </td>
              </tr>
            </tbody>
          </table>
          <Pagination :links="articles.links" />
        </div>
      </div>
    </div>

</div>
<!-- modal -->
<ArticleCreateModal v-if="activemodal"  @affiche="GererMessage('article ajouté')" @close="activemodal=false" >
</ArticleCreateModal>

<ArticleEditModal
:articles="articledites"
v-if="activedit"
@affiche="GererMessage('article modifié')"
@close="activedit=false"
></ArticleEditModal>

<ArticleDeleteModal
:article="articleAsupprimer"
v-if="activedelete"
@affiche="GererMessage('article supprimé')"
@close="activedelete=false"
>
</ArticleDeleteModal>
</DashLayout>

</template>

<script>
import ArticleCreateModal from './Article/ArticleCreateModal.vue';
import ArticleEditModal from './Article/ArticleEditModal .vue';
import ArticleDeleteModal from './Article/ArticleDeleteModal.vue';
import DashLayout from './DashLayout.vue';
import Pagination from '../../Components/Pagination.vue';
  export default  {
    name: "tablearticles",
    props: {
        articles: Array,
    },
    data(){
        return {
            activemodal: false,
            activedit:false,
            articledites:null,
            activedelete:false,
            articleAsupprimer:null,
            search:'',
            message:''



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
        },
        // search(){
        //     // this.$inertia.get("/dashboard",{search:this.searchTerm})
        // }
        GererMessage(message) {
      this.message = message;
      setTimeout(() => {
        this.message = "";
      }, 3000);
    },
    searching(){
        this.$inertia.get('/dashboard/articles',{search: this.search},{
            preserveState: true,
            replace: true,
        });
    }



    },
    computed:{


    },

    components: { ArticleCreateModal, ArticleEditModal, ArticleDeleteModal, DashLayout, Pagination },

};


</script>

<style >

</style>
