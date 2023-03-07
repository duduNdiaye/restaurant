<template lang="html">

<div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

      <div class="modal-content py-4 text-left px-6">
        <div class="flex justify-between items-center pb-3">
          <p class="text-2xl font-bold">Modifier un menu</p>
          <div class="modal-close cursor-pointer z-50">
            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
              <path d="M18 1.8l-1.8-1.8-7.2 7.2-7.2-7.2-1.8 1.8 7.2 7.2-7.2 7.2 1.8 1.8 7.2-7.2 7.2 7.2 1.8-1.8-7.2-7.2z"></path>
            </svg>
          </div>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="menu_jour">Jour du menu</label>
          <select class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="menu_jour" name="menu_jour">
            <option value="lundi">Lundi</option>
            <option value="mardi">Mardi</option>
            <option value="mercredi">Mercredi</option>
            <option value="jeudi">Jeudi</option>
            <option value="vendredi">Vendredi</option>
            <option value="samedi">Samedi</option>
            <option value="dimanche">Dimanche</option>
          </select>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="menu_articles">Articles</label>
            <!-- <Select2 class="js-example-basic-multiple bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" :options="articles" :settings="{ settingOption: id, settingOption: nom }"></Select2> -->
            <Multiselect size="3"
            v-model="selected"
            :options="options"
            :multiple="true"
            :close-on-select="true"
            :track-by="id"
            :label="nom"
            id="id"
            placeholder="Pick some"
            />

        </div>

        <div class="flex justify-end pt-2">
          <button class="modal-close px-4 bg-gray-400 p-3 rounded-lg text-white hover:bg-gray-300">Annuler</button>
          <button class="px-4 bg-blue-500 p-3 ml-3 rounded-lg text-white hover:bg-blue-400">Ajouter</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script lang="js">

  export default  {
    name: 'resources-js-pages-restaurant-menu-menu-edit',
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

<style scoped lang="scss">
  .resources-js-pages-restaurant-menu-menu-edit {

  }
</style>
