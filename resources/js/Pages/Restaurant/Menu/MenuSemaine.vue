<template >

<div class="container mx-auto py-4">
  <ul class="flex flex-wrap justify-center mb-4">
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" href="#lundi">Lundi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" href="#mardi">Mardi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" href="#mercredi">Mercredi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" href="#jeudi">Jeudi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" href="#vendredi">Vendredi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" href="#samedi">Samedi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" href="#dimanche">Dimanche</a>
    </li>
  </ul>

  <div class="p-4 bg-white rounded-lg shadow-md">
    <div id="lundi">
      <h2 class="text-2xl font-bold mb-4">Lundi</h2>
      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr>
              <th class="py-2 px-4 bg-gray-200">Type de repas</th>
              <th class="py-2 px-4 bg-gray-200">Menu</th>
              <th class="py-2 px-4 bg-gray-200">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Liste des menus pour le lundi -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Répéter le même modèle pour les autres jours de la semaine -->
  </div>
</div>

</template>

<script lang="js">

  export default  {
    name: 'resources-js-pages-restaurant-menu-menu-semaine',
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

<style scoped >
  .resources-js-pages-restaurant-menu-menu-semaine {

  }
</style>
