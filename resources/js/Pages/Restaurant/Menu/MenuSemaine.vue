<template >
<DashLayout>
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
      class="bg-green-500  hover:bg-green-700 text-white font-bold py-2 px-4 rounded my-4" @click="showCreate">
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
            <tr v-for="menu in menus">

                <td v-if="menu.jour_semaine==dayOfWeek.toLowerCase()" class="py-2 px-4 bg-gray-100 border text-center">{{ menu.jour_semaine }}</td>
                <td v-if="menu.jour_semaine==dayOfWeek.toLowerCase()" class="py-2 px-4 bg-gray-100 border text-center ">
                    <span v-for="article in menu.articles">{{ article.nom }},</span>
                </td>
                <td v-if="menu.jour_semaine==dayOfWeek.toLowerCase()"  class="py-2 px-4 bg-gray-100 border text-center ">
                    <button @click="showEdit(menu)" class="p-2 rounded-full bg-yellow-500 hover:bg-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.07 2.93a.75.75 0 011.06 0l5 5a.75.75 0 010 1.06l-8.8 8.8a1.5 1.5 0 01-.44.3l-4.14 1.38a.5.5 0 01-.62-.62l1.38-4.14a1.5 1.5 0 01.3-.44l8.8-8.8zm-1.13 2.47l-5 5 1.06 1.06 5-5-1.06-1.06z" />
                         </svg>
                    </button>

<button class="p-2 rounded-full bg-red-500 hover:bg-red-600">
  <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 20 20" fill="currentColor">
    <path fill-rule="evenodd" d="M15.85 4.15a.5.5 0 00-.7 0L10 9.29l-5.15-5.14a.5.5 0 00-.7.7L9.29 10l-5.14 5.15a.5.5 0 00.7.7L10 10.71l5.15 5.14a.5.5 0 00.7-.7L10.71 10l5.14-5.15a.5.5 0 000-.7z" clip-rule="evenodd" />
  </svg>
</button>

                </td>

            </tr>
          </tbody>
        </table>
        <p>{{ menus.articles }}</p>
      </div>
    </div>
    <MenuCreate @close="showCreateModal=false"  v-if="showCreateModal" :articles="articles"/>
    <!-- Répéter le même modèle pour les autres jours de la semaine -->
    <MenuEdit v-if="showEditModal" :menujour="menuedite" :articles="articles" @close="showEditModal=false"/>
  </div>
</div>

</DashLayout>

</template>

<script>
import DashLayout from '../DashLayout.vue';
import MenuCreate from './MenuCreate.vue';
import MenuEdit from './MenuEdit.vue';


  export default  {
    name: "resources-js-pages-restaurant-menu-menu-semaine",
    props: ['articles','menus'],
    mounted() {
        const days = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
        const date = new Date();
        const dayOfWeek = days[date.getDay()];
        this.dayOfWeek = dayOfWeek;
    },
    data() {
        return {
            dayOfWeek: "",
            showCreateModal:false,
            showEditModal:false,
            menuedite:null,
        };
    },
    methods: {
        changeLundi() {
            this.dayOfWeek = "Lundi";
        },
        changeMardi() {
            this.dayOfWeek = "Mardi";
        },
        changeMercredi() {
            this.dayOfWeek = "Mercredi";
        },
        changeJeudi() {
            this.dayOfWeek = "Jeudi";
        },
        changeVendredi() {
            this.dayOfWeek = "Vendredi";
        },
        changeSamedi() {
            this.dayOfWeek = "Samedi";
        },
        changeDimanche() {
            this.dayOfWeek = "Dimanche";
        },
        showCreate(){
            console.log(this.showCreateModal)
            this.showCreateModal=!this.showCreateModal;
            console.log(this.showCreateModal)
        },
        showEdit(menuedite)
        {
            console.log(this.showEditModal)
            this.showEditModal= !this.showEditModal;
            this.menuedite=menuedite;
        }
    },
    computed: {},
    components: { DashLayout, MenuCreate, MenuEdit }
}


</script>

<style scoped >

</style>
