<template >

<div class="flex flex-row space-x-4 mt-16">
  <div class="w-2/3  shadow-lg shadow-slate-300 bg-white rounded-md">
    <h2 class="text-lg font-semibold mb-2 p-2">Liste des commandes</h2>
    <table class="table-auto border border-gray-300">
      <thead>
        <tr>
          <th class="px-4 py-2">#</th>
          <th class="px-4 py-2">Client</th>
          <th class="px-4 py-2">Date</th>
          <th class="px-4 py-2">Total</th>
          <th class="px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-4 py-2">1</td>
          <td class="border px-4 py-2">John Doe</td>
          <td class="border px-4 py-2">2023-02-20</td>
          <td class="border px-4 py-2">$250.00</td>
          <td class="border px-4 py-2">
            <a href="#" class="text-blue-500 hover:text-blue-700">Voir</a> |
            <a href="#" class="text-yellow-500 hover:text-blue-700">Modifier</a> |
            <a href="#" class="text-red-500 hover:text-red-700">Supprimer</a>

          </td>
        </tr>
        <tr>
          <td class="border px-4 py-2">1</td>
          <td class="border px-4 py-2">John Doe</td>
          <td class="border px-4 py-2">2023-02-20</td>
          <td class="border px-4 py-2">$250.00</td>
          <td class="border px-4 py-2">
            <a href="#" class="text-blue-500 hover:text-blue-700">Voir</a> |
            <a href="#" class="text-yellow-500 hover:text-blue-700">Modifier</a> |
            <a href="#" class="text-red-500 hover:text-red-700">Supprimer</a>

          </td>
        </tr>
        <tr>
          <td class="border px-4 py-2">1</td>
          <td class="border px-4 py-2">John Doe</td>
          <td class="border px-4 py-2">2023-02-20</td>
          <td class="border px-4 py-2">$250.00</td>
          <td class="border px-4 py-2">
            <a href="#" class="text-blue-500 hover:text-blue-700">Voir</a> |
            <a href="#" class="text-yellow-500 hover:text-blue-700">Modifier</a> |
            <a href="#" class="text-red-500 hover:text-red-700">Supprimer</a>

          </td>
        </tr>
        <!-- Ajouter d'autres lignes ici -->
      </tbody>
    </table>
  </div>
  <div class="w-1/3 shadow-lg shadow-slate-300 bg-white rounded-md">
    <h2 class="text-lg font-semibold mb-2 p-2">Derniers clients</h2>
    <table class="table-auto border border-gray-300">
      <thead>
        <tr>
          <th class="px-4 py-2">#</th>
          <th class="px-4 py-2">Nom</th>
          <th class="px-4 py-2">Email</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border px-4 py-2">1</td>
          <td class="border px-4 py-2">Jane Doe</td>
          <td class="border px-4 py-2">jane.doe@example.com</td>
        </tr>
        <tr>
          <td class="border px-4 py-2">1</td>
          <td class="border px-4 py-2">Jane Doe</td>
          <td class="border px-4 py-2">jane.doe@example.com</td>
        </tr>
        <tr>
          <td class="border px-4 py-2">1</td>
          <td class="border px-4 py-2">Jane Doe</td>
          <td class="border px-4 py-2">jane.doe@example.com</td>
        </tr>
        <tr>
          <td class="border px-4 py-2">1</td>
          <td class="border px-4 py-2">Jane Doe</td>
          <td class="border px-4 py-2">jane.doe@example.com</td>
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

<style scoped>

</style>
