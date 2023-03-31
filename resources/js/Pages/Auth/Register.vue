<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    tel:'',
    heureOuvert:'',
    heureFerme:'',
    profile_photo:'',
    adresse:'',
    description:'',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const onFileChange=(e)=>{
      form.profile_photo=e.target.files
    };
</script>


<template>
    <Head title="Register" />

    <AuthenticationCard>
        <template #logo>
            <h1
 class="text-3xl lg:ml-0 text-center bg-haver text-slate-900 px-2 md:ml-0  font-title font-extrabold">
                        ClicMiam</h1>
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
          <div class="w-full md:w-1/2 px-3">
            <InputLabel for="profile_photo" value="Photo de profil" />
            <TextInput
                    id="profile_photo"
                    type="file"
                    class="mt-1 block w-72"
                    autocomplete="profile_photo"
                    @input="form.profile_photo=$event.target.files[0]"
                    name="profile_photo"
                />


                <InputError class="mt-2" :message="form.errors.profile_photo" />
            </div>
           <!-- <p>{{ form.profile_photo }}</p> -->



            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <InputLabel for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ml-2">
                            I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </InputLabel>
            </div>

            <div class="flex items-center justify-center mt-8">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Déja Inscrit?
                </Link>

                <PrimaryButton class="ml-4 font-extrabold bg-haver hover:bg-vert text-slate-200" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    S'inscrire
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
