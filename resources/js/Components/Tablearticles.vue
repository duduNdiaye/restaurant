<template >

<div class="flex flex-col">
    <button
      class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-4"
      @click="showCreateModal = true"
    >
      Créer un nouvel article
    </button>
    <h1 class="text-3xl font-semibold mb-6">Liste des articles</h1>
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
            <tbody class="bg-white divide-y divide-gray-200">
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Article 1</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$10.00</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Catégorie 1</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">50</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">30 minutes</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <img src="https://picsum.photos/64" alt="Article 1" class="w-10 h-10 rounded-full">
                </td>
                <td class="border py-2 px-4">
            <button
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mr-2"
              @click="editArticle(article)"
            >
              Modifier
            </button>
            <button
              class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
              @click="deleteArticle(article.id)"
            >
              Supprimer
            </button>
          </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Article 2</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$15.00</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Catégorie 2</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">30</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">45 minutes</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <img src="https://picsum.photos/64" alt="Article" class="w-10 h-10 rounded-full" />
                </td>
                <td class="border py-2 px-4">
            <button
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mr-2"
              @click=""
            >
              Modifier
            </button>
            <button
              class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
              @click=""
            >
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
<div v-if="showCreateModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ajouter un article</h3>
            <form>
              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6">
                  <label for="nom" class="block text-sm font-medium text-gray-700">Nom Article</label>
                  <input type="text" name="nom" id="nom" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="prix" class="block text-sm font-medium text-gray-700">Prix</label>
                  <input type="number" name="prix" id="prix" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
                  <select id="categorie" name="categorie" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="aliments">Aliments</option>
                    <option value="boissons">Boissons</option>
                    <option value="desserts">Desserts</option>
                  </select>
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
                  <input type="number" name="quantite" id="quantite" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6 sm:col-span-3">
                  <label for="tempsPreparation" class="block text-sm font-medium text-gray-700">Temps de preparation</label>
                  <input type="number" name="tempsPreparation" id="tempsPreparation" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6 sm:col-span-3">
                  <label for="description" class="block text-sm font-medium text-gray-700">description</label>
                  <input type="text" name="description" id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-6 sm:col-span-3">
                  <label for="ingredients" class="block text-sm font-medium text-gray-700">Ingredients</label>
                  <input type="number" name="ingredients" id="ingredients" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="flex justify-start relative space-x-4 mt-4">
  <button class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" @click="showCreateModal=false">Quitter  </button>
  <button class="px-4 py-2 text-white bg-blue-400 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Ajouter</button>
</div>
              </div>
            </form>
          </div>
        </div>
      </div>
</div>


</template>

<script lang="js">

  export default  {
    name: 'resources-js-components-tablearticles',
    props: [],
    mounted () {

    },
    data () {
      return {
        showCreateModal:false
      }
    },
    methods: {

    },
    computed: {

    }
}


</script>

<style >

</style>
