<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    user: Object,
});

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
        form.Lalatitude = position.coords.latitude;
        form.Lalongitude = position.coords.longitude;
        console.log(form.Lalatitude);
        console.log(form.Lalongitude);
        panier.value = true;
        click.value = "MERCI"
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
    _method: 'PUT',
    name: props.user.name,
    email: props.user.email,
    tel:props.user.tel,
    adresse:props.user.adresse,
    heureOuvert:props.user.heureOuvert,
    heureFerme:props.user.heureFerme,
    description:props.user.description,
    Lalatitude:props.user.latitude,
    Lalongitude:props.user.longitude,
    photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
    if (photoInput.value) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('user-profile-information.update'), {
        errorBag: 'updateProfileInformation',
        preserveScroll: true,
        onSuccess: () => clearPhotoFileInput(),

    });
    console.log(form.Lalatitude);
    console.log(form.Lalongitude);
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
    photoInput.value.click();
};

const updatePhotoPreview = () => {
    const photo = photoInput.value.files[0];

    if (! photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target.result;
    };

    reader.readAsDataURL(photo);
};

const deletePhoto = () => {
    router.delete(route('current-user-photo.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            photoPreview.value = null;
            clearPhotoFileInput();
        },
    });
};

const clearPhotoFileInput = () => {
    if (photoInput.value?.value) {
        photoInput.value.value = null;
    }
};
</script>

<template>
    <FormSection @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div v-if="$page.props.jetstream.managesProfilePhotos" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input
                    ref="photoInput"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview"
                >

                <InputLabel for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div v-show="! photoPreview" class="mt-2">
                    <!-- '/storage/'+user.profile_photo_path -->
                    <!-- :src="user.profile_photo_url" -->
                    <img :src="'/storage/'+user.profile_photo_path" :alt="user.name" class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div v-show="photoPreview" class="mt-2">
                    <span
                        class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + photoPreview + '\');'"
                    />
                </div>

                <SecondaryButton class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Select A New Photo
                </SecondaryButton>

                <SecondaryButton
                    v-if="user.profile_photo_path"
                    type="button"
                    class="mt-2"
                    @click.prevent="deletePhoto"
                >
                    Remove Photo
                </SecondaryButton>

                <InputError :message="form.errors.photo" class="mt-2" />
            </div>

                <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Name" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="name"
                />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-4 sm:col-span-4">
                <InputLabel for="email" value=" Adresse Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full"
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" class="mt-2" />

                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email address is unverified.

                        <Link
                            :href="route('verification.send')"
                            method="post"
                            as="button"
                            class="underline text-gray-600 hover:text-gray-900"
                            @click.prevent="sendEmailVerification"
                        >
                            Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
            </div>


            <!-- adresse -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="adresse" value="adresse" />
                <TextInput
                    id="adresse"
                    v-model="form.adresse"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="adresse"
                />
                <InputError :message="form.errors.adresse" class="mt-2" />
            </div>
            <!-- telephone -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="tel" value="numero telephone" />
                <TextInput
                    id="tel"
                    v-model="form.tel"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="tel"
                />
                <InputError :message="form.errors.tel" class="mt-2" />
            </div>
            <!-- description -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="description" value="description" />
                <TextInput
                    id="description"
                    v-model="form.description"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="description"
                />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <!-- heureOuvert -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="heureOuvert" value="heure d'ouverture" />
                <TextInput
                    id="heureOuvert"
                    v-model="form.heureOuvert"
                    type="number"
                    class="mt-1 block w-full"
                    autocomplete="heureOuvert"
                />
                <InputError :message="form.errors.heureOuvert" class="mt-2" />
            </div>
            <!-- heureFerme -->
            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="heureFerme" value="heure de fermeture" />
                <TextInput
                    id="heureFerme"
                    v-model="form.heureFerme"
                    type="number"
                    class="mt-1 block w-full"
                    autocomplete="heureFerme"
                />
                <InputError :message="form.errors.heureFerme" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="heureFerme" value="heure de fermeture" />

                <button type="button" @click="getPosition()"
                 class="border-2 w-full font-bold border-black p-3 text-black hover:text-white hover:bg-black hover:scale-105 transition duration-100">{{click}}</button>
            </div>

            <!-- photo -->


        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>

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
