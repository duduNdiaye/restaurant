<template >

<div class="flex flex-col">
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
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Article 2</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">$15.00</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Catégorie 2</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">30</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">45 minutes</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <img src="https://picsum.photos/64" alt="Article" class="w-10 h-10 rounded-full"/>
                </td>
              </tr>
            </tbody>
        </table>
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
