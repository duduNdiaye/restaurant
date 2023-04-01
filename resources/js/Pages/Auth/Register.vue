<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref, onMounted, computed } from "vue";

const isLoading = ref(false);
const click = ref("Partager votre position");
const latitude = ref(0);
const longitude = ref(0);
const panier = ref(false);
const getPosition = () => {
  //props.users = null;
  if (navigator.geolocation) {
    isLoading.value = true;

    click.value = "Patientez...";
    navigator.geolocation.getCurrentPosition(
      (position) => {
       form.Lalatitude= position.coords.latitude;
        form.Lalongitude = position.coords.longitude;
        console.log( form.Lalatitude);
        console.log(form.Lalongitude);
        click.value = "MERCI...";
        panier.value = true;
        click.value = "MERCI";
        setTimeout(() => {
          panier.value = false;
        }, 2000);
      },
      (error) => {
        console.log(error.message);
      }
    );
  } else {
    console.log("Your browser does not support geolocation API");
  }
};

const form = useForm({
  name: "",
  email: "",
  password: "",
  tel: "",
  heureOuvert: "",
  heureFerme: "",
  profile_photo: "",
  adresse: "",
  description: "",
  Lalatitude: "",
  Lalongitude: "",
  password_confirmation: "",
  terms: false,
});

const submit = () => {
  form.post(route("register"), {
    onSuccess: () => {
        console.log("all is fine");
    },
    onError: (error) => {
        console.error("Dara dialoul fall: ",error);
        console.log(form.Lalatitude, " ",form.Lalongitude);
    },
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};

const onFileChange = (e) => {
  form.profile_photo = e.target.files;
};
</script>

<template>
  <Head title="Register" />

  <AuthenticationCard>
    <template #logo>
      <h1
        class="text-3xl lg:ml-0 text-center bg-haver text-slate-900 px-2 md:ml-0 font-title font-extrabold"
      >
        ClicMiam
      </h1>
    </template>

    <form @submit.prevent="submit" enctype="multipart/form-data">
      <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <InputLabel for="name" value="Nom restaurant" />
          <TextInput
            id="name"
            v-model="form.name"
            type="text"
            class="mt-1 block w-72"
            autocomplete="name"
          />
          <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div mt="w-full md:w-1/2 px-3">
          <InputLabel for="email" value="Email" />
          <TextInput
            id="email"
            v-model="form.email"
            type="email"
            class="mt-1 block w-72"
            autocomplete="email"
          />
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
      </div>
      <div class="flex flex-wrap mt-4">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <InputLabel for="password" value="Mot de passe" />
          <TextInput
            id="password"
            v-model="form.password"
            type="password"
            class="mt-1 block w-72"
            autocomplete="new-password"
          />
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        <div mt="w-full md:w-1/2 px-3">
          <InputLabel for="password_confirmation" value="Confirmer mot de passe" />
          <TextInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            class="mt-1 block w-72"
            autocomplete="new-password"
          />
          <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>
      </div>
      <div class="flex flex-wrap mt-4">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <InputLabel for="tel" value="Numero telephone" />
          <TextInput
            id="tel"
            v-model="form.tel"
            type="text"
            class="mt-1 block w-72"
            autocomplete="tel"
          />
          <InputError class="mt-2" :message="form.errors.tel" />
        </div>
        <div mt="w-full md:w-1/2 px-3">
          <InputLabel for="adresse" value="Adresse" />
          <TextInput
            id="adresse"
            v-model="form.adresse"
            type="text"
            class="mt-1 block w-72"
            autocomplete="adresse"
          />
          <InputError class="mt-2" :message="form.errors.adresse" />
        </div>
      </div>
      <div class="flex flex-wrap mt-4">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
          <InputLabel for="heureOuvert" value="Heure ouverture" />
          <TextInput
            id="heureOuvert"
            v-model="form.heureOuvert"
            type="number"
            class="mt-1 block w-72"
            autocomplete="heureOuvert"
          />
          <InputError class="mt-2" :message="form.errors.heureOuvert" />
        </div>
        <div classe="w-full md:w-1/2 px-3">
          <InputLabel for="heureFerme" value="Heure Fermeture" />
          <TextInput
            id="heureFerme"
            v-model="form.heureFerme"
            type="number"
            class="mt-1 block w-72"
            autocomplete="heureFerme"
          />
          <InputError class="mt-2" :message="form.errors.heureFerme" />
        </div>
      </div>
      <div class="flex flex-wrap mt-4">
        <div class="w-full md:w-1/2 px-3">
          <InputLabel for="profile_photo" value="Photo de profil" />
          <TextInput
            id="profile_photo"
            type="file"
            class="mt-1 block w-72"
            autocomplete="profile_photo"
            @input="form.profile_photo = $event.target.files[0]"
            name="profile_photo"
          />

          <InputError class="mt-2" :message="form.errors.profile_photo" />
        </div>
        <div class="w-full md:w-1/2 px-3">
          <InputLabel for="profile_photo" value="Photo de profil" />
          <button
            type="button"
            @click="getPosition()"
            class="border-2 w-[17.5rem] font-bold border-black p-3 text-black hover:text-white hover:bg-black hover:scale-105 transition duration-100"
          >
            {{ click }}
          </button>


        </div>
      </div>
      <!-- <p>{{ form.profile_photo }}</p> -->

      <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
        <InputLabel for="terms">
          <div class="flex items-center">
            <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

            <div class="ml-2">
              I agree to the
              <a
                target="_blank"
                :href="route('terms.show')"
                class="underline text-sm text-gray-600 hover:text-gray-900"
                >Terms of Service</a
              >
              and
              <a
                target="_blank"
                :href="route('policy.show')"
                class="underline text-sm text-gray-600 hover:text-gray-900"
                >Privacy Policy</a
              >
            </div>
          </div>
          <InputError class="mt-2" :message="form.errors.terms" />
        </InputLabel>
      </div>

      <div class="flex items-center justify-center mt-8">
        <Link
          :href="route('login')"
          class="underline text-sm text-gray-600 hover:text-gray-900"
        >
          Déja Inscrit?
        </Link>

        <PrimaryButton
          class="ml-4 font-extrabold bg-haver hover:bg-vert text-slate-200"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          S'inscrire
        </PrimaryButton>
      </div>
    </form>
  </AuthenticationCard>
  <transition name="panier">
    <div
      v-if="panier"
      class="bg-vert font-bold flex h-14 z-[55] text-white rounded-md p-4 fixed top-[35rem] right-4"
    >
      <div class="flex mb-3">
        <span class="text-xl font-bold">Localisation recuperee avec succes!</span>
        <svg
          class="w-8 h-8 icon ml-4"
          viewBox="0 0 1024 1024"
          xmlns="http://www.w3.org/2000/svg"
          fill="#000000"
        >
          <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
          <g
            id="SVGRepo_tracerCarrier"
            stroke-linecap="round"
            stroke-linejoin="round"
          ></g>
          <g id="SVGRepo_iconCarrier">
            <path
              fill="#000000"
              d="M512 64a448 448 0 1 1 0 896 448 448 0 0 1 0-896zm-55.808 536.384-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.272 38.272 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336L456.192 600.384z"
            ></path>
          </g>
        </svg>
      </div>
    </div>
  </transition>
</template>
<style>

.panier-enter-active,
.panier-leave-active {
  transition: transform 0.5s ease, opacity 0.5s ease;
  transform: translateX(100%);
  opacity: 0;
}

.panier-enter,
.panier-leave-to {
  opacity: 0;
  transform: translateX(100%);
}

.panier-leave,
.panier-enter-to {
  opacity: 1;
  transform: translateX(0);
}

</style>
