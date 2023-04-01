<template >

<div class="flex flex-row space-x-4 mt-16">
  <div class="w-full  shadow-lg shadow-slate-300 bg-white rounded-md overflow-x-auto">
    <h2 class="text-lg font-semibold mb-2 p-2">Liste des commandes</h2>
    <table class=" table table-auto border border-gray-300 w-full">
      <thead>
        <tr>
          <th class="px-4 py-2">Client</th>
          <th class="px-4 py-2">Date</th>
          <th class="px-4 py-2">Total</th>
          <th class="px-4 py-2">Reception</th>
          <th class="px-4 py-2">Panier</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="commande in commandes">
          <td class="border px-4 py-2">{{ commande.nomClient }}</td>
          <td class="border px-4 py-2">{{ commande.date }}</td>
          <td class="border px-4 py-2">{{ commande.coutTotal }}</td>
          <td class="border px-4 py-2">{{ commande.modeReception }}</td>
          <td class="border px-4 py-2 text-center">
            <span  class="text-blue-500 hover:text-blue-700">{{commande.panier}}</span>
            <!-- <a href="#" class="text-yellow-500 hover:text-blue-700">Modifier</a> | -->

          </td>
        </tr>

        <!-- Ajouter d'autres lignes ici -->
      </tbody>
    </table>
  </div>

</div>

</template>

<script >

  export default  {
    name: 'resources-js-pages-restaurant-dashboard-other',
    props: ['commandes'],
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

<style scoped>

</style>
