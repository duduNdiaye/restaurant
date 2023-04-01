<?php

namespace App\Actions\Fortify;

use App\Models\User;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Http\UploadedFile;
use Laravel\Jetstream\Features;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input,): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(),
            'tel' => ['required', 'string'],
            'heureOuvert' => ['required', 'Integer', 'min:0', 'max:23'],
            'heureFerme' => ['required', 'Integer', 'min:0', 'max:23'],
            'adresse' => ['required'],



            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        //
        //
        $request = app(Request::class);
        // Enregistrer la photo de profil de l'utilisateur
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos');
        } else {
            $path = null;
        }
        //fin stockage

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'tel' => $input['tel'],
            'heureOuvert' => $input['heureOuvert'],
            'heureFerme' => $input['heureFerme'],
            'adresse' => $input['adresse'],
            'latitude' => $input['Lalatitude'],
            'longitude' => $input['Lalongitude'],
            'profile_photo_path' => $path,

        ]);



        return $user;
    }
}
