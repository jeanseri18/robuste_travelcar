<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function showLoginForm()
    {
        // Si l'utilisateur est déjà connecté, le rediriger vers le tableau de bord
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }
        
        return view('auth.login');
    }

    /**
     * Traite la demande de connexion.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Tentative de connexion
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Vérifier le type d'utilisateur - pour le panneau d'admin, seuls les admin peuvent se connecter
            if (Auth::user()->type !== 'Administrateur') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->withErrors([
                    'email' => 'Vous n\'avez pas les autorisations nécessaires pour accéder à cette section.',
                ])->onlyInput('email');
            }
            
            return redirect()->intended(route('dashboard.index'));
        }

        // Échec de connexion
        throw ValidationException::withMessages([
            'email' => ['Les informations d\'identification fournies ne correspondent pas à nos enregistrements.'],
        ]);
    }

    /**
     * Déconnecte l'utilisateur.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }

    /**
     * Affiche le formulaire d'inscription pour un nouvel administrateur.
     * Remarque : Cette méthode peut être limitée selon vos besoins de sécurité.
     */
    public function showRegistrationForm()
    {
        // Vérifier si un administrateur existe déjà - pour limiter la création d'admin
        // Décommenter pour activer cette restriction
        // if (User::where('type', 'Administrateur')->exists()) {
        //     return redirect()->route('admin.login.form')
        //         ->with('error', 'Un administrateur existe déjà. Veuillez contacter le support pour plus d\'informations.');
        // }
        
        return view('auth.register');
    }

    /**
     * Traite la demande d'inscription d'un administrateur.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contact_telephone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Créer l'utilisateur
        $user = User::create([
            'type' => 'Administrateur',
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'contact_telephone' => $request->contact_telephone,
            'password' => Hash::make($request->password),
            'role' => 'Administrateur',
        ]);

        // Connecter l'utilisateur
        Auth::login($user);

        return redirect()->route('dashboard.index')
            ->with('success', 'Votre compte administrateur a été créé avec succès.');
    }

    /**
     * Affiche le formulaire de réinitialisation du mot de passe.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Affiche le formulaire de modification du mot de passe.
     */
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    /**
     * Traite la demande de modification du mot de passe.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);

        $user = Auth::user();

        // Vérifier le mot de passe actuel
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => ['Le mot de passe actuel est incorrect.'],
            ]);
        }

        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dashboard.index')
            ->with('success', 'Votre mot de passe a été modifié avec succès.');
    }

    /**
     * Affiche le profil de l'utilisateur connecté.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    /**
     * Met à jour le profil de l'utilisateur connecté.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'contact_telephone' => ['required', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($request->only([
            'nom', 'prenom', 'email', 'contact_telephone', 'whatsapp'
        ]));

        return redirect()->route('auth.profile')
            ->with('success', 'Votre profil a été mis à jour avec succès.');
    }
}