<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>

    <Head title="Welcome" />

    <div class="bg-gray-200">
        <header>
            <nav
                class="fixed md:flex border-b-2 border-gray-200 text-center items-center justify-between bg-white px-4  py-3 w-full">
                <div class="flex items-center">
                    <h1
                        class="text-3xl lg:ml-0 text-center bg-black text-white px-2 md:ml-0  font-title font-extrabold">
                        EatEasy Restaurant</h1>

                    <div class="pt-2 relative  mx-auto text-gray-600" v-if="showSearchBar">
                        <input
                            class="border-none bg-gray-200 focus:ring-vert focus:border-none  lg:ml-16 lg:w-96 h-[3rem] px-5 pr-16 rounded-lg text-sm focus:outline-none"
                            type="search" name="search" placeholder="Search">
                        <button type="submit" class="absolute right-0 top-0 mt-5 mr-4">
                            <svg class="text-gray-600 h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px"
                                viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;"
                                xml:space="preserve" width="512px" height="512px">
                                <path
                                    d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                            </svg>
                        </button>
                    </div>


                </div>



                <div class="md:flex lg:border-none border-t-2 border-b-2 border-gray-200 bg-white md:items-center md:px-0 px-3 md:pb-0 pb-10 md:static absolute md:w-auto w-full top-14 duration-300 ease-in"
                    :class="[open ? 'left-0' : 'left-[-100%]']">
                    <div class="md:mx-4 md:my-0 my-6 flex">
                        <button @click="toggleCart()" class="px-3 py-2  text-black font-bold hover:text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                            </svg>
                        </button>
                        <span class="font-semibold text-black mt-2 w-[4rem] h-5 rounded-full">0 items</span>
                    </div>
                    <div class="md:mx-4 md:my-0 my-6">
                        <a href="#" class="px-3 py-2 font-bold text-black hover:text-indigo-600">Articles</a>
                    </div>
                    <div class="md:mx-4 md:my-0 my-6">
                        <a href="#" class="px-3 py-2 font-bold text-black hover:text-indigo-600">Contact</a>
                    </div>
                    <div v-if="canLogin" class="flex flex-col md:flex-row md:my-0 my-6">
                        <a v-if="$page.props.user" :href="route('dashboard')"
                            class="px-3 py-2   bg-vert font-bold text-white rounded hover:bg-green-200  mt-3 md:mt-0">Button
                            1</a>

                        <template v-else>
                            <a :href="route('login')"
                                class="px-3 py-2 lg:ml-4 text-center bg-vert font-bold text-white rounded hover:bg-green-200  mt-3 md:mt-0">Login
                            </a>
                            <a v-if="canRegister" :href="route('register')"
                                class="px-3 py-2 lg:ml-4 font-bold text-center bg-vert text-white rounded hover:bg-green-200  mt-3 md:mt-0">Register
                            </a>
                        </template>
                    </div>
                </div>
                <!-- <div class="block md:hidden">
                    <button
                        class="flex items-center px-3 py-2 border border-gray-400 rounded text-gray-500 hover:text-gray-600"
                        id="navbar-toggle">
                        <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <title>Menu</title>
                            <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                        </svg>
                    </button>
                </div> -->
            </nav>


        </header>

        <div class="bg-grocery h-screen  lg:block md:block hidden">

            <section class="text-gray-600 body-font">
                <div class="container mx-auto flex flex-col px-5 lg:py-56 py-16 justify-center items-center">

                    <div class="w-full md:w-2/3 flex flex-col mb-16 items-center text-center">
                        <h1 class="title-font  sm:text-6xl text-3xl mb-4 font-black text-gray-900">Plus besoin de faire
                            la
                            queue!</h1>
                        <p class="lg:block hidden mb-8 leading-relaxed">Découvrez le moyen le plus rapide et le plus
                            facile
                            de déguster vos
                            plats préférés chez votre restaurant
                            préféré sans quitter votre maison grâce à notre application de commande en ligne.</p>
                        <div class="flex w-full justify-center items-end">
                            <div class=" mr-4 lg:w-full xl:w-1/2 w-2/4 md:w-full text-left">
                                <input placeholder="Rechercher..." type="text" id="hero-field" name="hero-field"
                                    class="w-full bg-white focus:ring-vert  border-none shadow-2xl px-3 py-2 rounded-l-full text-gray-700 leading-8 transition-colors duration-200 ">
                            </div>
                            <button
                                class="inline-flex rounded-r-full text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-300 rounded text-lg">Button</button>
                        </div>
                        <p class="text-sm mt-2 text-gray-500 mb-8 w-full">Que voulez vous manger? Ou le voulez-vous?</p>

                    </div>
                </div>
            </section>




        </div>

        <section class="text-gray-600 body-font bg-white mt-1">
            <div class="container px-2 py-4 mx-auto flex flex-wrap lg:block md:block hidden">
                <div class="flex flex-wrap -m-4">
                    <div
                        class="p-4 lg:w-4/12 w-full lg:block md:block hidden hover:scale-105 transition duration-200  ">
                        <div
                            class="flex items-center justify-center bg-rose border-2 rounded-lg border-gray-200 border-opacity-50 p-4 sm:flex-row flex-col">
                            <div
                                class="w-16 h-16 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" class="w-8 h-8" viewBox="0 0 24 24">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                </svg>
                            </div>
                            <div class="flex-grow ">
                                <h2 class="text-white text-2xl title-font font-bold mb-3">Traitement rapide</h2>
                                <p class="leading-relaxed text-white text-base">Blue bottle crucifix vinyl post-ironic
                                    four dollar
                                </p>
                                <a class="mt-3 text-white inline-flex items-center">Learn More
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2"
                                        viewBox="0 0 24 24">
                                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 lg:w-4/12 w-full lg:block md:block hidden hover:scale-105 transition duration-200">
                        <div
                            class="flex items-center  justify-center bg-jaune border-2 rounded-lg border-gray-200 border-opacity-50 p-4 sm:flex-row flex-col">
                            <div
                                class="w-16 h-16 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" class="w-8 h-8" viewBox="0 0 24 24">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-white text-2xl title-font font-bold mb-3">Traitement efficace</h2>
                                <p class="leading-relaxed text-white text-base">Blue bottle crucifix vinyl post-ironic
                                    four dollar
                                </p>
                                <a class="mt-3 text-white inline-flex items-center">Learn More
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2"
                                        viewBox="0 0 24 24">
                                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 lg:w-4/12 w-full lg:block md:block hidden hover:scale-105 transition duration-200">
                        <div
                            class="flex items-center justify-center bg-vert border-2 rounded-lg border-gray-200 border-opacity-50 p-4 sm:flex-row flex-col">
                            <div
                                class="w-16 h-16 sm:mr-8 sm:mb-0 mb-4 inline-flex items-center justify-center rounded-full bg-indigo-100 text-indigo-500 flex-shrink-0">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" class="w-10 h-10" viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="flex-grow">
                                <h2 class="text-white  text-2xl title-font font-bold mb-3">Traitement securise</h2>
                                <p class="leading-relaxed text-white text-base">Blue bottle crucifix vinyl post-ironic
                                    four dollar</p>
                                <a class="mt-3 text-white inline-flex items-center">Learn More
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2"
                                        viewBox="0 0 24 24">
                                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="flex items-center justify-center p-2 m-2">
                <img src="./der.jpg"
                    class="w-[32rem] rounded-lg lg:hidden md:hidden h-52 mt-20 flex items-center justify-center" alt="">
            </div>

        </section>

        <section :class="[fixed ? 'fixed-top' : '', 'flex justify-between p-2 bg-white']">
            <button class="text-black bg-gray-200 px-3 font-bold p-2 rounded-lg flex m-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                </svg>
                Filtre</button>

            <select
                class="rounded focus:ring-vert lg:mt-0 focus:border-none font-bold w-32 px-4 py-2 text-black bg-gray-200 border border-gray-200">
                <option>Fast Food</option>
                <option>Complet</option>
            </select>
        </section>

        <footer
            class="fixed bottom-0 border-t-2 border-gray-200 shadow-2xl bg-white w-full px-6 py-3 lg:hidden md:hidden">

            <div class="flex justify-between items-center">
                <div>
                    <button @click="toggleMenu()"
                        class="absolute md:hidden mt-5 left-6 top-0.5 cursor-pointer text-4xl">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            :class="[open ? 'bi bi-x text-red-500' : 'bi bi-filter-left text-blue-500']"
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 5.25h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5m-16.5 4.5h16.5" />
                        </svg>

                    </button>
                </div>
                <div>
                    <button @click="toggleMenu()" class="absolute md:hidden mt-5 top-0.5 cursor-pointer text-4xl">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>

                    </button>
                </div>
                <div>
                    <button @click="toggleCart()" class="px-3 py-2  text-black font-bold hover:text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                    </button>
                </div>
                <div>
                    <button class="mt-2" @click="showSearchBar = !showSearchBar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>

                </div>
            </div>
        </footer>


        <!-- <button class="fixed inset-2 flex items-center justify-end h-screen w-screen" @click="showComponent = true">
            <div class="bg-vert h-28 w-28 rounded-lg m-6 flex flex-col">
                <div class="flex text-center items-center justify-center p-2 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                    <span class=" font-bold ml-2 text-white">0 items</span>
                </div>
                <div class="flex items-center bg-white text-vert font-bold rounded py-1 w-20 ml-4 mt-4 justify-center">0
                    FCFA</div>
            </div>
        </button> -->




        <div :class="[showComponent ? 'right-0' : 'right-[-100%] lg:block md:block hidden']"
            class="border-l-2 border-gray-100 duration-700 ease-in-out fixed right-0 bottom-0 lg:h-screen lg:w-[32rem] w-[22rem]  h-screen bg-white text-white p-3">
            <div class="flex justify-between border-b-2 border-gray-100 py-3">
                <div class="justify-start">
                    <div class="flex text-center items-center justify-center p-2 text-vert">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                        </svg>
                        <span class=" font-bold ml-2 text-vert">0 items</span>
                    </div>
                </div>
                <div class="justify-end">
                    <button @click="showComponent = false"
                        class="btn btn-danger rounded-full p-1 bg-gray-200 text-gray-400  absolute top-6 right-2"><svg
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="fixed  left-100 lg:w-[30rem]  h-16 bg-vert rounded-full bottom-5">
                <div class="flex justify-between">
                    <div class="font-black text-white text-2xl mb-8 py-4 px-6">Commander</div>
                    <div
                        class="justify-end text-vert h-[3rem] mt-2 mr-3 py-3 w-[7rem] px-5 rounded-full bg-white font-bold text-xl">
                        0 FCFA
                    </div>
                </div>
            </div>
        </div>


    </div>







</template>

<script>
export default {
    data() {
        return {
            open: false,
            showSearchBar: false,
            scrollY: 0,
            fixed: false,
            showComponent: false,
        };
    },
    mounted() {
        window.addEventListener("scroll", this.handleScroll);
    },
    beforeDestroy() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    methods: {
        toggleMenu() {
            this.open = !this.open;
        },
        toggleCart() {
            this.showComponent = !this.showComponent;
        },
        handleScroll() {
            this.scrollY = window.scrollY;

            if (this.scrollY > 0) {
                this.showSearchBar = true;
            } else {
                this.showSearchBar = false;
            }
        }
    }
};
</script>
<style>
.bg-grocery {
    background-image: url(./grocery.png);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
