<template >

<div class="container mx-auto py-4">
  <ul class="flex flex-wrap justify-center mb-4">
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" @click="changeLundi" >Lundi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" @click="changeMardi" >Mardi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" @click="changeMercredi" >Mercredi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" @click="changeJeudi">Jeudi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" @click="changeVendredi" >Vendredi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" @click="changeSamedi" >Samedi</a>
    </li>
    <li class="mr-4 mb-4">
      <a class="bg-gray-300 hover:bg-gray-400 rounded-lg py-2 px-4" @click="changeDimanche" >Dimanche</a>
    </li>
  </ul>
  <div class="flex justify-center flex-col">
    <button
      class="bg-green-500  hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-4"
      >
      Ajouter un menu
    </button>
  </div>
  <div class="p-4 bg-white rounded-lg shadow-md">
    <div>
     <h2 class="text-2xl font-bold mb-4">
        {{ dayOfWeek }}
     </h2>




      <div class="overflow-x-auto mt-2">

        <table class="w-full">
          <thead>
            <tr>
              <th class="py-2 px-4 bg-gray-300">Type de repas</th>
              <th class="py-2 px-4 bg-gray-300">Menu</th>
              <th class="py-2 px-4 bg-gray-300">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td class="py-2 px-4 bg-gray-100 border text-center">thieboudieune</td>
                <td class="py-2 px-4 bg-gray-100 border text-center ">Voir</td>
                <td class="py-2 px-4 bg-gray-100 border text-center ">Modifier|supprimer</td>

            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Répéter le même modèle pour les autres jours de la semaine -->
  </div>
</div>

</template>

<script>

  export default  {
    name: 'resources-js-pages-restaurant-menu-menu-semaine',
    props: [],
    mounted () {
        const days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        const date = new Date();
        const dayOfWeek = days[date.getDay()];
        this.dayOfWeek = dayOfWeek;
    },
    data () {
      return {
          dayOfWeek:'',
      }
    },
    methods: {
        changeLundi(){
            this.dayOfWeek='Lundi'
        },
        changeMardi(){
            this.dayOfWeek='Mardi'
        },
        changeMercredi(){
            this.dayOfWeek='Mercredi'
        },
        changeJeudi(){
            this.dayOfWeek='Jeudi'
        },
        changeVendredi(){
            this.dayOfWeek='Vendredi'
        },
        changeSamedi(){
            this.dayOfWeek='Samedi'
        },
        changeDimanche(){
            this.dayOfWeek='Dimanche'
        }
    },
    computed: {

    }
}


</script>

<style scoped >

</style>
