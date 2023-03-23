<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
    <Head title="Log in" />

    <AuthenticationCard class="">
        <template #logo>
            <h1
 class="text-3xl lg:ml-0 text-center bg-haver text-white px-2 md:ml-0  font-title font-extrabold">
                        EatEasy</h1>
        </template>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

    <div  class="max-w-md mx-auto my-10 ">
        <form @submit.prevent="submit"  class="">
            <div class=" ">
                <div class="w-full    md:w-1/2 lg:w-5/6 px-3 mb-6  md:mb-0">
                <InputLabel for="email" value="Email"  />
                <TextInput
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full ml-1"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4 w-full    md:w-1/2 lg:w-5/6 px-3 mb-6 md:mb-0">
                <InputLabel for="password" value="Mot de passe" />
                <TextInput
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full "
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4 lg:ml-3">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">Se Souvenir de moi</span>
                </label>
            </div>
            </div>

            <div class="flex   justify-start  mt-8 lg:ml-2">
                <PrimaryButton class="text-white bg-vert hover:bg-green-900 font-extrabold " :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Se connecter
                </PrimaryButton>
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline ml-4 mt-1  text-sm text-gray-600 hover:text-gray-900">
                    Mot de passe Oublié?
                </Link>


            </div>
        </form>
       </div>

    </AuthenticationCard>
</template>
