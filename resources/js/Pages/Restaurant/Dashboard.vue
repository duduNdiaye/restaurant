
<script>

//   STATS FIN SCRIPT
export default {

    data() {
        return {
            showDropDown: false,
            showSide: true,
            user: "",
            ShowArticles: false,
            ShowCards: true,
            showMenu:false
        };
    },
    props: ["user"],
    methods: {
        sendMessage() {
            var user = JSON.parse(this.user);
            //do you thing here
        }
    },
    methods: {
        // hide show side bar
        toggleSideBar() {
            this.showSide = !this.showSide;
        },
        // toggle user
        toggleDrop() {
            this.showDropDown = !this.showDropDown;
        },
        ShowAllArticles() {
            this.ShowArticles = true;
            this.ShowCards = false;
            this.showMenu=false;




        },
        ShowAllCards() {
            this.ShowArticles = false;
            this.ShowCards = true;
            this.showMenu=false;

        },
        ShowWeekMenu(){
            this.showMenu=true;
            this.ShowArticles = false;
            this.ShowCards = false;


        }
    },
    created() {
},

    computed: {

    },
    components: { DashboardOther, MenuSemaine },


}
</script>
<script setup>

import { router } from '@inertiajs/core';
import { watch } from 'vue';
import DashboardCard from './DashboardCard.vue';
import DashboardOther from './DashboardOther.vue';
import MenuSemaine from './Menu/MenuSemaine.vue';
import DashLayout from './DashLayout.vue';
import Tablearticles from './Tablearticles.vue';
 const props = defineProps({
   articles: {},
   commandes: {},
   nbre_articles:{},
   nbre_commandes:{},
   nbre_clients:{},
   revenu_total:{}

 });
 const logout = () => {
    router.post(route('logout'));
};


</script>
<template>
   <DashLayout>
            <DashboardCard v-show="ShowCards" :nbre_articles="nbre_articles" :nbre_commandes="nbre_commandes" :nbre_clients="nbre_clients" :revenu_total="revenu_total" />
            <TableArticles v-if="ShowArticles"  :articles-all="articles" />
            <DashboardOther v-if="ShowCards" :commandes="commandes"/>
            <MenuSemaine v-if="showMenu"/>

<!-- STATS -->


<!--  END STATS -->
   </DashLayout>

</template>

<style scoped>
</style>
<!-- STATS SCRIPT -->
<script setup>

</script>
